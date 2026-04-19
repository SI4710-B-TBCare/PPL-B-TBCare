<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class CreateFeedbackSeeder extends Seeder
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
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'pesan' => 'Aplikasi ini sangat membantu dalam diagnosis penyakit.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane@example.com',
                'pesan' => 'Interface user-friendly dan mudah digunakan.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Feedback::insert($data);
    }
}
