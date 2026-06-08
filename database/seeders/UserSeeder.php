<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['username' => 'johni'],
            [
                'name'     => 'Johni',
                'password' => bcrypt('john123')
            ]
        );

        $role = Role::firstOrCreate(['name' => 'user']);

        $user->assignRole($role);
    }
}
