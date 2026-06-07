<?php

namespace Database\Seeders;

use App\Models\Monitoring;
use Illuminate\Database\Seeder;

class CreateMonitoringSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'nama' => 'Budi Santoso',
                'tanggal' => now(),
                'hasil_lab' => 'Negatif',
                'keterangan' => 'Kondisi membaik, batuk berkurang',
                'status' => 'sembuh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama' => 'Siti Aminah',
                'tanggal' => now()->subDays(3),
                'hasil_lab' => 'Positif',
                'keterangan' => 'Masih dalam perawatan intensif',
                'status' => 'proses',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'nama' => 'Andi Wijaya',
                'tanggal' => now()->subDays(7),
                'hasil_lab' => 'Positif',
                'keterangan' => 'Gejala mulai berkurang',
                'status' => 'proses',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Monitoring::insert($data);
    }
}