<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'user']);

        $users = [
            [
                'username' => 'johni',
                'name' => 'Johni',
                'password' => bcrypt('john123'),
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
            ],
            [
                'username' => 'adi',
                'name' => 'Adi',
                'password' => bcrypt('adi123'),
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Semarang',
            ],
            [
                'username' => 'siti',
                'name' => 'Siti',
                'password' => bcrypt('siti123'),
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
            ],
            [
                'username' => 'budi',
                'name' => 'Budi',
                'password' => bcrypt('budi123'),
                'provinsi' => 'Jawa Timur',
                'kota' => 'Surabaya',
            ],
            [
                'username' => 'rita',
                'name' => 'Rita',
                'password' => bcrypt('rita123'),
                'provinsi' => 'Bali',
                'kota' => 'Denpasar',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['username' => $data['username']],
                $data
            );

            $user->assignRole($role);
        }
    }
}
