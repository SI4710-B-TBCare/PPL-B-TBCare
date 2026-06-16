<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Forum;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        if ($user) {
            Forum::create([
                'user_id' => 4,
                'judul' => 'Bagaimana cara mencegah TBC?',
                'konten' => 'Saya baru saja membaca artikel tentang TBC dan ingin tahu lebih lanjut mengenai langkah-langkah pencegahannya secara efektif di lingkungan yang padat.'
            ]);

            Forum::create([
                'user_id' => 3,
                'judul' => 'Bagaimana pengalaman pelayanan TBC di Rumah Sakit XYZ?',
                'konten' => 'Saya baru saja mendapat informasi tidak enak mengenai pelayanan di Rumah Sakit XYZ.'
            ]);

            Forum::create([
                'user_id' => $user->id,
                'judul' => 'Apakah batuk 2 minggu selalu berarti TBC?',
                'konten' => 'Saya sudah batuk berdahak selama lebih dari dua minggu, tapi tidak ada demam. Apakah ini gejala TBC?'
            ]);
        }
    }
}
