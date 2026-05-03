<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Gejala;
use App\Models\Penyakit;

class GejalaPenyakitSeeder extends Seeder
{
    public function run()
    {
        $penyakit = Penyakit::where('kode', 'P001')->first();

        $data = [
            ['kode' => 'G001', 'cf' => 0.9],
            ['kode' => 'G002', 'cf' => 0.8],
            ['kode' => 'G003', 'cf' => 1.0],
            ['kode' => 'G004', 'cf' => 0.6],
            ['kode' => 'G005', 'cf' => 0.6],
            ['kode' => 'G006', 'cf' => 0.7],
            ['kode' => 'G007', 'cf' => 0.8],
            ['kode' => 'G008', 'cf' => 0.6],
            ['kode' => 'G009', 'cf' => 0.5],
            ['kode' => 'G010', 'cf' => 0.7],
            ['kode' => 'G011', 'cf' => 0.6],
        ];

        foreach ($data as $item) {
            $gejala = Gejala::where('kode', $item['kode'])->first();

            DB::table('gejala_penyakit')->insert([
                'penyakit_id' => $penyakit->id,
                'gejala_id' => $gejala->id,
                'value_cf' => $item['cf']
            ]);
        }
    }
}