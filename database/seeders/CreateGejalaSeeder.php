<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gejala;

class CreateGejalaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode' => 'G001', 'nama' => 'Batuk lebih dari 2 minggu'],
            ['kode' => 'G002', 'nama' => 'Batuk berdahak'],
            ['kode' => 'G003', 'nama' => 'Batuk berdarah'],
            ['kode' => 'G004', 'nama' => 'Demam berkepanjangan'],
            ['kode' => 'G005', 'nama' => 'Demam malam hari'],
            ['kode' => 'G006', 'nama' => 'Keringat malam'],
            ['kode' => 'G007', 'nama' => 'Berat badan menurun'],
            ['kode' => 'G008', 'nama' => 'Nafsu makan menurun'],
            ['kode' => 'G009', 'nama' => 'Tubuh lemas'],
            ['kode' => 'G010', 'nama' => 'Nyeri dada'],
            ['kode' => 'G011', 'nama' => 'Sesak napas'],
        ];

        Gejala::insert($data);
    }
}