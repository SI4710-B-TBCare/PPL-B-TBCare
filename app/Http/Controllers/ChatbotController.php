<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\TbPrediction;
use App\Services\GroqApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    const SYSTEM_PROMPT = 'Kamu adalah asisten kesehatan bernama TBCare AI. Kamu HANYA menjawab pertanyaan seputar Tuberkulosis (TBC/TB), gejalanya, pengobatan, pencegahan, pola hidup sehat untuk penderita TBC, dan topik yang berkaitan dengan kesehatan paru-paru. Jika pengguna bertanya di luar topik tersebut, tolak dengan sopan dan arahkan kembali ke topik TBC. Gunakan bahasa Indonesia yang ramah, mudah dipahami, dan penuh empati. Berikan informasi yang akurat berdasarkan pengetahuan medis umum, namun selalu sarankan pengguna untuk berkonsultasi ke dokter untuk diagnosis dan penanganan medis yang tepat.';

    protected $groqApiService;

    public function __construct(GroqApiService $groqApiService)
    {
        $this->middleware('auth');
        $this->middleware('role:user');
        $this->groqApiService = $groqApiService;
    }

    /**
     * Tampilkan halaman chatbot.
     * URL: GET /users/chatbot          → chat umum (predictionId = null)
     * URL: GET /users/chatbot/{id}     → chat dengan konteks prediksi
     */
    public function index(Request $request, $predictionId = null)
    {
        $prediction = null;

        if ($predictionId) {
            $prediction = TbPrediction::where('id', $predictionId)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }

        $messages = ChatbotMessage::where('user_id', Auth::id())
            ->where('prediction_id', $predictionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('users.chatbot.index', compact('messages', 'prediction', 'predictionId'));
    }

    /**
     * Terima pesan user, kirim ke Gemini, simpan ke DB, kembalikan respons JSON.
     * URL: POST /users/chatbot/send
     */
    public function send(Request $request)
    {
        $request->validate([
            'message'       => 'required|string|max:1000',
            'prediction_id' => 'nullable|integer|exists:tb_predictions,id',
        ]);

        $userId       = Auth::id();
        $predictionId = $request->prediction_id ? (int) $request->prediction_id : null;
        $userMessage  = trim($request->message);

        // 1. Simpan pesan user ke DB
        $userMessageModel = ChatbotMessage::create([
            'user_id'       => $userId,
            'prediction_id' => $predictionId,
            'role'          => 'user',
            'content'       => $userMessage,
        ]);

        // 2. Ambil semua history (termasuk pesan yang baru disimpan)
        $history = ChatbotMessage::where('user_id', $userId)
            ->where('prediction_id', $predictionId)
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Bangun array messages untuk Groq API (OpenAI format)
        $messages = [];
        $messages[] = [
            'role'    => 'system',
            'content' => self::SYSTEM_PROMPT,
        ];

        // Jika ada prediksi, sisipkan konteks di awal
        if ($predictionId) {
            $prediction = TbPrediction::find($predictionId);
            if ($prediction) {
                $contextText = $prediction->buildPredictionContext();
                $messages[] = [
                    'role'    => 'user',
                    'content' => $contextText,
                ];
                $messages[] = [
                    'role'    => 'assistant',
                    'content' => 'Baik, saya sudah memahami hasil prediksi Anda. Silakan ajukan pertanyaan seputar kondisi ini atau TBC secara umum.',
                ];
            }
        }

        // Tambahkan history percakapan nyata dari DB (konversi 'model' ke 'assistant')
        foreach ($history as $msg) {
            $role = $msg->role === 'model' ? 'assistant' : 'user';
            $messages[] = [
                'role'    => $role,
                'content' => $msg->content,
            ];
        }

        // 4. Panggil Groq API
        try {
            $aiText = $this->groqApiService->sendMessage($messages);
        } catch (\Exception $e) {
            // Jika semua model dan retry gagal, HAPUS pesan user dari DB agar tidak ada ghost message
            $userMessageModel->delete();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }

        // 5. Simpan respons AI ke DB
        ChatbotMessage::create([
            'user_id'       => $userId,
            'prediction_id' => $predictionId,
            'role'          => 'model',
            'content'       => $aiText,
        ]);

        return response()->json(['reply' => $aiText]);
    }

    /**
     * Hapus semua pesan chatbot untuk konteks tertentu (reset percakapan).
     * URL: POST /users/chatbot/reset
     */
    public function reset(Request $request)
    {
        $predictionId = $request->prediction_id ? (int) $request->prediction_id : null;

        ChatbotMessage::where('user_id', Auth::id())
            ->where('prediction_id', $predictionId)
            ->delete();

        return response()->json(['status' => 'ok']);
    }
}
