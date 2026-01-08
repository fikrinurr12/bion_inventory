<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'Admin')->first();

        User::create([
            'initial' => 'ADM001',
            'name' => 'Administrator',
            'email' => 'admin@bion.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        $staffRole = Role::where('role_name', 'Staff Gudang')->first();

        User::create([
            'initial' => 'STF001',
            'name' => 'Staff Gudang 1',
            'email' => 'staff@bion.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id,
        ]);
    }
}