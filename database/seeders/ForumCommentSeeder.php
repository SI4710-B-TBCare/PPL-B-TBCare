<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Forum;
use App\Models\ForumComment;

class ForumCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $forums = Forum::all();

        if ($user && $forums->count() >= 2) {
            ForumComment::create([
                'forum_id' => $forums[0]->id,
                'user_id' => $user->id,
                'konten' => 'Cara terbaik adalah dengan menjaga ventilasi udara di rumah, menggunakan masker saat berinteraksi dengan penderita, dan menjaga sistem imun tubuh kita.'
            ]);

            ForumComment::create([
                'forum_id' => $forums[1]->id,
                'user_id' => $user->id,
                'konten' => 'Sebaiknya Anda segera memeriksakan diri ke Puskesmas atau rumah sakit terdekat. Batuk lebih dari dua minggu adalah salah satu gejala utama TBC, walaupun belum pasti.'
            ]);
        }
    }
}
