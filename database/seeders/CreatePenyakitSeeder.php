<?php

namespace Database\Seeders;

use App\Models\FasilitasKesehatan;
use Illuminate\Database\Seeder;

class CreatePenyakitSeeder extends Seeder
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
            'nama' => 'Pneumonia',
            'kode' => 'P001',
            'penyebab' => 'Infeksi bakteri, virus, atau jamur yang masuk ke paru-paru melalui udara atau aspirasi dari saluran pernapasan atas.'
        ],
        [
            'nama' => 'Bronkitis',
            'kode' => 'P002',
            'penyebab' => 'Peradangan saluran bronkus akibat infeksi virus, bakteri, atau iritasi dari asap rokok dan polusi udara.'
        ],
        [
            'nama' => 'Kanker Paru-paru',
            'kode' => 'P003',
            'penyebab' => 'Pertumbuhan sel abnormal di paru-paru yang sering dipicu oleh kebiasaan merokok, paparan zat kimia berbahaya, atau polusi.'
        ],
        [
            'nama' => 'Asma',
            'kode' => 'P004',
            'penyebab' => 'Penyempitan saluran napas akibat reaksi alergi, debu, asap, udara dingin, atau aktivitas fisik berlebih.'
        ],
        [
            'nama' => 'COVID-19',
            'kode' => 'P005',
            'penyebab' => 'Infeksi virus corona (SARS-CoV-2) yang menular melalui droplet saat batuk, bersin, atau berbicara.'
        ],
        [
            'nama' => 'Infeksi Jamur Paru',
            'kode' => 'P006',
            'penyebab' => 'Paparan spora jamur dari lingkungan yang masuk ke paru-paru, terutama pada orang dengan daya tahan tubuh lemah.'
        ],
        [
            'nama' => 'PPOK (Penyakit Paru Obstruktif Kronis)',
            'kode' => 'P007',
            'penyebab' => 'Kerusakan paru-paru jangka panjang akibat paparan asap rokok, polusi udara, atau zat iritan lainnya.'
        ],
        [
            'nama' => 'Sarkoidosis',
            'kode' => 'P008',
            'penyebab' => 'Peradangan yang menyebabkan terbentuknya granuloma (benjolan kecil) di organ tubuh, terutama paru-paru, penyebab pastinya belum diketahui.'
        ]
    ];

        FasilitasKesehatan::insert($data);
    }
}
