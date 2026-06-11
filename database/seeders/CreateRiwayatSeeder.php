<?php

namespace Database\Seeders;

use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreateRiwayatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        $samples = [
            ['days' => 14, 'cf' => 0.25, 'label' => 'TBC Ringan'],
            ['days' => 10, 'cf' => 0.45, 'label' => 'TBC Sedang'],
            ['days' => 7, 'cf' => 0.55, 'label' => 'TBC Sedang'],
            ['days' => 4, 'cf' => 0.70, 'label' => 'TBC Berat'],
            ['days' => 1, 'cf' => 0.82, 'label' => 'TBC Berat'],
        ];

        foreach ($users as $user) {
            foreach ($samples as $sample) {
                Riwayat::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'created_at' => Carbon::now()->subDays($sample['days'])->startOfDay(),
                    ],
                    [
                        'nama' => 'Tuberkulosis',
                        'hasil_diagnosa' => $sample['label'],
                        'cf_max' => serialize([$sample['cf'], $sample['label']]),
                        'gejala_terpilih' => '',
                        'file_pdf' => null,
                        'updated_at' => Carbon::now()->subDays($sample['days'])->startOfDay(),
                    ]
                );
            }
        }
    }
}
