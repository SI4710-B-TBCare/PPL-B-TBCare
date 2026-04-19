<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GejalaPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Influenza
            [
                'fasilitas_kesehatan_id' => 1,
                'artikel_id' => 1,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 1,
                'artikel_id' => 3,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 1,
                'artikel_id' => 7,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 1,
                'artikel_id' => 21,
                'value_cf' => 0.2
            ],

            // DBD
            [
                'fasilitas_kesehatan_id' => 2,
                'artikel_id' => 2,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 2,
                'artikel_id' => 17,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 2,
                'artikel_id' => 18,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 2,
                'artikel_id' => 20,
                'value_cf' => 0.4
            ],

            // Hepatitis
            [
                'fasilitas_kesehatan_id' => 3,
                'artikel_id' => 1,
                'value_cf' => 0.6
            ],
            [
                'fasilitas_kesehatan_id' => 3,
                'artikel_id' => 14,
                'value_cf' => 0.6
            ],
            [
                'fasilitas_kesehatan_id' => 3,
                'artikel_id' => 15,
                'value_cf' => 0.6
            ],
            [
                'fasilitas_kesehatan_id' => 3,
                'artikel_id' => 16,
                'value_cf' => 0.6
            ],

            // Malaria
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 2,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 5,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 6,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 11,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 12,
                'value_cf' => 0.2
            ],
            [
                'fasilitas_kesehatan_id' => 4,
                'artikel_id' => 13,
                'value_cf' => 0.2
            ],

            // Campak
            [
                'fasilitas_kesehatan_id' => 5,
                'artikel_id' => 1,
                'value_cf' => 0.8
            ],
            [
                'fasilitas_kesehatan_id' => 5,
                'artikel_id' => 3,
                'value_cf' => 0.8
            ],
            [
                'fasilitas_kesehatan_id' => 5,
                'artikel_id' => 10,
                'value_cf' => 0.8
            ],

            // Tifus
            [
                'fasilitas_kesehatan_id' => 6,
                'artikel_id' => 1,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 6,
                'artikel_id' => 4,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 6,
                'artikel_id' => 5,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 6,
                'artikel_id' => 8,
                'value_cf' => 0.4
            ],
            [
                'fasilitas_kesehatan_id' => 6,
                'artikel_id' => 9,
                'value_cf' => 0.4
            ],

            // Cacingan
            [
                'fasilitas_kesehatan_id' => 7,
                'artikel_id' => 4,
                'value_cf' => 1
            ],
            [
                'fasilitas_kesehatan_id' => 7,
                'artikel_id' => 5,
                'value_cf' => 1
            ],
            [
                'fasilitas_kesehatan_id' => 7,
                'artikel_id' => 6,
                'value_cf' => 1
            ],
            [
                'fasilitas_kesehatan_id' => 7,
                'artikel_id' => 11,
                'value_cf' => 1
            ],
            [
                'fasilitas_kesehatan_id' => 7,
                'artikel_id' => 19,
                'value_cf' => 1
            ]
            
        ];

        DB::table('artikel_fasilitas_kesehatan')->insert($data);
    }
}
