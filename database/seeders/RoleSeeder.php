<?php

namespace Database\Seeders;

use App\Enums\RoleEnums;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnums::ADMIN_ROLES_NAME as $role) {
            Role::query()->create(['name' => $role]);
        }

        foreach (RoleEnums::STAFF_ROLES_NAME as $role) {
            Role::query()->create(['name' => $role]);
        }
        foreach (RoleEnums::THIRD_PARTY_ROLES_NAME as $role) {
            Role::query()->create(['name' => $role]);
        }

    }
}
