<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;

class CreatePenyakitSeeder extends Seeder
{
    public function run()
    {
        Penyakit::create([
            'kode' => 'P001',
            'nama' => 'Tuberkulosis (TBC)',
            'penyebab' => 'Infeksi bakteri Mycobacterium tuberculosis yang menyerang paru-paru'
        ]);
    }
}