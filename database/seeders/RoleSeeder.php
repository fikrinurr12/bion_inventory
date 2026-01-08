<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 'ROLE-' . Str::uuid(), 'role_name' => 'Admin'],
            ['id' => 'ROLE-' . Str::uuid(), 'role_name' => 'Staff Gudang'],
            ['id' => 'ROLE-' . Str::uuid(), 'role_name' => 'Manajer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
