<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminRoleSeeder extends Seeder
{
    public function run()
    {
        if (!Role::where('name','Super Admin')->first()){
            Role::create([
                'name' => 'Super Admin',
            ]);
        }
    }
}
