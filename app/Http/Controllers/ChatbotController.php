<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\TbPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    const GROQ_URL = 'https://api.groq.com/openai/v1/chat/completions';
    const GROQ_MODELS = [
        'llama-3.3-70b-versatile',
        'llama-3.1-8b-instant',
        'mixtral-8x7b-32768'
    ];

    const SYSTEM_PROMPT = 'Kamu adalah asisten kesehatan bernama TBCare AI. Kamu HANYA menjawab pertanyaan seputar Tuberkulosis (TBC/TB), gejalanya, pengobatan, pencegahan, pola hidup sehat untuk penderita TBC, dan topik yang berkaitan dengan kesehatan paru-paru. Jika pengguna bertanya di luar topik tersebut, tolak dengan sopan dan arahkan kembali ke topik TBC. Gunakan bahasa Indonesia yang ramah, mudah dipahami, dan penuh empati. Berikan informasi yang akurat berdasarkan pengetahuan medis umum, namun selalu sarankan pengguna untuk berkonsultasi ke dokter untuk diagnosis dan penanganan medis yang tepat.';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:user');
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
                $contextText = $this->buildPredictionContext($prediction);
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
        $apiKey = config('services.groq.key');
        $aiText = null;
        $lastErrorStatus = null;

        foreach (self::GROQ_MODELS as $model) {
            $payload = [
                'model'    => $model,
                'messages' => $messages,
            ];
            
            try {
                $response = Http::withoutVerifying()
                    ->withToken($apiKey)
                    ->retry(3, 1500, function ($exception) {
                        return $exception instanceof \Illuminate\Http\Client\ConnectionException || 
                               ($exception instanceof \Illuminate\Http\Client\RequestException && $exception->response->status() == 429);
                    })->asJson()->timeout(30)->post(self::GROQ_URL, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $aiText = $data['choices'][0]['message']['content'] ?? null;
                    if ($aiText) {
                        break;
                    }
                } else {
                    $lastErrorStatus = $response->status();
                    \Illuminate\Support\Facades\Log::error("Groq API Error [$model]: " . $response->body());
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Groq Connection Error [$model]: " . $e->getMessage());
                $lastErrorStatus = 'Error: ' . $e->getMessage();
                continue;
            }
        }

        if (!$aiText) {
            // Jika semua model dan retry gagal, HAPUS pesan user dari DB agar tidak ada ghost message
            $userMessageModel->delete();

            $errorMsg = $lastErrorStatus == 429 
                ? 'Sistem kami sedang sibuk karena terlalu banyak permintaan. Silakan coba beberapa saat lagi.' 
                : 'Gagal menghubungi AI (Status: ' . ($lastErrorStatus ?? 'Unknown') . '). Silakan coba lagi.';

            return response()->json([
                'error' => $errorMsg,
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

    /**
     * Bangun teks konteks prediksi untuk dikirim ke Gemini.
     */
    private function buildPredictionContext(TbPrediction $prediction)
    {
        $labels   = TbPrediction::featureLabels();
        $features = [];

        foreach ($labels as $key => $label) {
            $value = $prediction->{$key};
            $features[] = '- ' . $label . ': ' . $value;
        }

        $featuresText = implode("\n", $features);

        return "Berikut adalah data hasil prediksi risiko TBC saya:\n"
            . "Tingkat Risiko: " . $prediction->risk_level . "\n"
            . "Persentase Risiko: " . $prediction->risk_percentage . "%\n"
            . "Tanggal Prediksi: " . $prediction->created_at->format('d M Y, H:i') . "\n\n"
            . "Data Gejala yang Saya Inputkan:\n" . $featuresText . "\n\n"
            . "Berdasarkan data di atas, tolong berikan saran, rekomendasi langkah selanjutnya, "
            . "dan informasi penting yang perlu saya ketahui terkait kondisi ini.";
    }
}
