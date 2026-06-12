<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            CreatePenyakitSeeder::class,
            // CreateGejalaSeeder::class,
            ArtikelSeeder::class,
            // CreateFasilitasKesehatanSeeder::class,
            // GejalaPenyakitSeeder::class,
            CreateFeedbackSeeder::class,
            CreateMonitoringSeeder::class,
            UserSeeder::class,
            ForumSeeder::class,
            ForumCommentSeeder::class,
            // CreateRiwayatSeeder::class,
        ]);
    }
}
