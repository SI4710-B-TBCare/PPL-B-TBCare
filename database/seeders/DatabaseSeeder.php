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
            CreateGejalaSeeder::class,
            GejalaPenyakitSeeder::class,
            CreateFeedbackSeeder::class,
            CreateMonitoringSeeder::class,
            UserSeeder::class,
            CreateRiwayatSeeder::class,
        ]);
    }
}
