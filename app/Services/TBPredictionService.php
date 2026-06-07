<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TBPredictionService
{
    protected string $apiUrl;

    public function __construct()
    {
        // Simpan URL Flask di .env: TB_API_URL=http://localhost:5000
        $this->apiUrl = config('services.tb_api.url', 'http://localhost:5000');
    }

    /**
     * Kirim data gejala ke Flask API dan dapatkan hasil prediksi.
     *
     * @param array $symptoms  Array dengan key CO, NS, BD, FV, dst (nilai integer 0-2)
     * @return array           ['probability' => float, 'risk_level' => string, 'risk_color' => string]
     * @throws \Exception
     */
    public function predict(array $symptoms): array
    {
        try {
            $response = Http::timeout(10)
                ->post("{$this->apiUrl}/predict", $symptoms);

            if ($response->failed()) {
                Log::error('TB Prediction API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new \Exception('Layanan prediksi sedang tidak tersedia.');
            }

            return $response->json();

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('TB Prediction API connection failed', ['error' => $e->getMessage()]);
            throw new \Exception('Tidak dapat terhubung ke layanan prediksi. Coba lagi nanti.');
        }
    }

    /**
     * Cek apakah Flask API aktif.
     */
    public function isHealthy(): bool
    {
        try {
            $response = Http::timeout(5)->get("{$this->apiUrl}/health");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
