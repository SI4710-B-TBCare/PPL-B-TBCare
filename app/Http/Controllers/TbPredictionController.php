<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use App\Models\TbPrediction;
use App\Services\GroqApiService;
use App\Services\TBPredictionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TbPredictionController extends Controller
{
    protected TBPredictionService $predictionService;
    protected GroqApiService $groqApiService;

    const FEATURES = ['CO','NS','BD','FV','CP','SP','IS','LP','CH','LC','IR','LA','LE','LNE','SBP','BMI'];

    public function __construct(TBPredictionService $predictionService, GroqApiService $groqApiService)
    {
        $this->predictionService = $predictionService;
        $this->groqApiService = $groqApiService;

        $this->middleware('auth');

        // Hanya role 'user' yang bisa mengisi form, melihat hasil, dan riwayat sendiri
        $this->middleware('role:user')->only(['create', 'store', 'show', 'index']);

        // Hanya role 'admin' yang bisa melihat log aktivitas
        $this->middleware('role:Admin')->only(['adminIndex']);
    }

    /**
     * Riwayat prediksi milik user yang sedang login.
     * URL: GET /users/prediksi
     * View: users/prediksi/index.blade.php
     */
    public function index()
    {
        $predictions = TbPrediction::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('users.prediksi.index', compact('predictions'));
    }

    /**
     * Log aktivitas prediksi untuk admin — hanya nama user dan waktu, tanpa data medis.
     * URL: GET /admin/prediksi
     * View: admin/prediksi/index.blade.php
     */
    public function adminIndex()
    {
        $predictions = TbPrediction::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.prediksi.index', compact('predictions'));
    }

    /**
     * Form kuesioner prediksi — hanya user.
     * URL: GET /users/prediksi/create
     * View: users/prediksi/create.blade.php
     */
    public function create()
    {
        $labels  = TbPrediction::featureLabels();
        $options = TbPrediction::severityOptions();
        $sputum  = TbPrediction::sputumOptions();

        return view('users.prediksi.create', compact('labels', 'options', 'sputum'));
    }

    /**
     * Proses prediksi dan simpan hasilnya.
     * URL: POST /users/prediksi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'CO'  => 'required|integer|between:0,2',
            'NS'  => 'required|integer|between:0,2',
            'BD'  => 'required|integer|between:0,2',
            'FV'  => 'required|integer|between:0,2',
            'CP'  => 'required|integer|between:0,2',
            'SP'  => 'required|integer|between:0,2',
            'IS'  => 'required|integer|between:0,3',
            'LP'  => 'required|integer|between:0,2',
            'CH'  => 'required|integer|between:0,2',
            'LC'  => 'required|integer|between:0,2',
            'IR'  => 'required|integer|between:0,2',
            'LA'  => 'required|integer|between:0,2',
            'LE'  => 'required|integer|between:0,3',
            'LNE' => 'required|integer|between:0,2',
            'SBP' => 'required|integer|between:0,2',
            'BMI' => 'required|integer|between:0,2',
        ]);

        foreach (self::FEATURES as $feature) {
            $validated[$feature] = (int) $validated[$feature];
        }

        try {
            $result = $this->predictionService->predict($validated);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $prediction = TbPrediction::create($validated + [
            'user_id'         => Auth::id(),
            'risk_percentage' => $result['probability'],
            'risk_level'      => $result['risk_level'],
        ]);

        // Redirect ke halaman show dengan route name baru
        return redirect()
            ->route('users.prediksi.show', $prediction->id)
            ->with('success', 'Prediksi berhasil dilakukan.');
    }

    /**
     * Hasil prediksi — hanya bisa diakses oleh user pemiliknya.
     * URL: GET /users/prediksi/{tbPrediction}
     * View: users/prediksi/show.blade.php
     */
    public function show(TbPrediction $tbPrediction)
    {
        if ($tbPrediction->user_id !== Auth::id()) {
            abort(403);
        }

        $labels  = TbPrediction::featureLabels();
        $options = TbPrediction::severityOptions();
        $sputum  = TbPrediction::sputumOptions();

        return view('users.prediksi.show', compact('tbPrediction', 'labels', 'options', 'sputum'));
    }

    /**
     * Generate auto recommendation using Groq API
     */
    public function generateAutoRecommendation(Request $request, $id)
    {
        $prediction = TbPrediction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $existingMessage = ChatbotMessage::where('prediction_id', $id)
            ->where('role', 'model')
            ->first();

        if ($existingMessage) {
            return response()->json([
                'reply' => $existingMessage->content
            ]);
        }

        $contextText = $prediction->buildPredictionContext();
        $contextText .= "\n\nBerikan ringkasan rekomendasi awal yang singkat, padat, dan jelas (maksimal 3 paragraf atau bullet points) terkait hasil ini untuk ditampilkan langsung di halaman hasil prediksi.";

        $messages = [
            [
                'role' => 'system',
                'content' => \App\Http\Controllers\ChatbotController::SYSTEM_PROMPT
            ],
            [
                'role' => 'user',
                'content' => $contextText
            ]
        ];

        try {
            $aiText = $this->groqApiService->sendMessage($messages);

            ChatbotMessage::create([
                'user_id' => Auth::id(),
                'prediction_id' => $id,
                'role' => 'model',
                'content' => $aiText
            ]);

            return response()->json([
                'reply' => $aiText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
