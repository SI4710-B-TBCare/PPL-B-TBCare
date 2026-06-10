<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqApiService
{
    const GROQ_URL = 'https://api.groq.com/openai/v1/chat/completions';
    const GROQ_MODELS = [
        'llama-3.3-70b-versatile',
        'llama-3.1-8b-instant',
        'mixtral-8x7b-32768'
    ];

    /**
     * Mengirim pesan ke Groq API dan mengembalikan response content.
     *
     * @param array $messages Array of messages in OpenAI format [['role' => '...', 'content' => '...']]
     * @return string|null
     * @throws \Exception
     */
    public function sendMessage(array $messages)
    {
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
                    Log::error("Groq API Error [$model]: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Groq Connection Error [$model]: " . $e->getMessage());
                $lastErrorStatus = 'Error: ' . $e->getMessage();
                continue;
            }
        }

        if (!$aiText) {
            $errorMsg = $lastErrorStatus == 429 
                ? 'Sistem kami sedang sibuk karena terlalu banyak permintaan. Silakan coba beberapa saat lagi.' 
                : 'Gagal menghubungi AI (Status: ' . ($lastErrorStatus ?? 'Unknown') . '). Silakan coba lagi.';
            
            throw new \Exception($errorMsg);
        }

        return $aiText;
    }
}
