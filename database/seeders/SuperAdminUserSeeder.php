<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'user_name' => 'SuperAdmin',
            'user_first_name' => 'Super',
            'user_last_name' => 'Admin',
            'email' => 'superadmin@miaki.co',
            'user_mobile' => '01737962059',
            'password' => Hash::make('1234'),
            'role_id' => 1
        ]);
        $user->assignRole('Super Admin');
    }
}
