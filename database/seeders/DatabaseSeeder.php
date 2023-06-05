<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws \Exception
     */
    public function run(): void
    {
        (new UserSeeder())->run();
        (new ProductSeeder())->run();
        (new ProductItemSeeder())->run();
        (new RoleSeeder())->run();
        (new PermissionSeeder())->run();
        $this->userRoleSeeder();
        $this->permissionRoleSeeder();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function userRoleSeeder(): void
    {
        foreach (User::all() as $user) {
            DB::table('role_user')->insert([
                'user_id'    => $user->id,
                'role_id'    => Role::query()->where('name', 'customer')->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        foreach (Role::query()->whereNot('name', 'customer')->get() as $role) {
            $users = User::inRandomOrder()->limit(random_int(1, 5))->get();
            foreach ($users as $user) {
                DB::table('role_user')->insert([
                    'user_id'    => $user->id,
                    'role_id'    => $role->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    private function permissionRoleSeeder(): void
    {
        foreach (Permission::all() as $permission) {
            DB::table('permission_role')->insert([
                'role_id'       => Role::where('name', 'super_admin')->first()->id,
                'permission_id' => $permission->id,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        }
    }
}
