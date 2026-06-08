<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbPrediction extends Model
{
    protected $table = 'tb_predictions';

    protected $fillable = [
        'user_id',
        'CO', 'NS', 'BD', 'FV', 'CP', 'SP', 'IS',
        'LP', 'CH', 'LC', 'IR', 'LA', 'LE', 'LNE', 'SBP', 'BMI',
        'risk_percentage',
        'risk_level',
    ];

    protected $casts = [
        'risk_percentage' => 'float',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Label nama fitur untuk ditampilkan di view
    public static function featureLabels(): array
    {
        return [
            'CO'  => 'Batuk',
            'NS'  => 'Keringat Malam',
            'BD'  => 'Kesulitan Bernapas',
            'FV'  => 'Demam',
            'CP'  => 'Nyeri Dada',
            'SP'  => 'Dahak (Sputum)',
            'IS'  => 'Penurunan Imunitas',
            'LP'  => 'Kehilangan Minat',
            'CH'  => 'Menggigil',
            'LC'  => 'Sulit Berkonsentrasi',
            'IR'  => 'Mudah Tersinggung',
            'LA'  => 'Kehilangan Nafsu Makan',
            'LE'  => 'Kehilangan Energi',
            'LNE' => 'Pembengkakan Kelenjar Limfa',
            'SBP' => 'Tekanan Darah Sistolik',
            'BMI' => 'Indeks Massa Tubuh',
        ];
    }

    // Opsi pilihan untuk form (kecuali SP yang berbeda)
    public static function severityOptions(): array
    {
        return [
            0 => 'Ringan',
            1 => 'Sedang',
            2 => 'Berat',
        ];
    }

    public static function sputumOptions(): array
    {
        return [
            0 => 'Berdarah',
            1 => 'Bening / Tidak Berwarna',
            2 => 'Kehijauan',
        ];
    }
}
