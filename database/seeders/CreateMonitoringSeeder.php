<?php

namespace Database\Seeders;

use App\Models\Monitoring;
use Illuminate\Database\Seeder;

class CreateMonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Server Status',
                'keterangan' => 'Monitor status server aplikasi',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Database Backup',
                'keterangan' => 'Monitor backup database harian',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Monitoring::insert($data);
    }
}
