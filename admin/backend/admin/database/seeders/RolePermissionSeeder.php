<?php

namespace Database\Seeders;

use App\Models\UserRole;
use DB;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles_permissions = DB::connection('old_mysql')->table('role_permission')->get();
        foreach ($roles_permissions as $roles_permission){
            DB::table('role_permission')->insert([
                'id' => $roles_permission->id,
                'role_id' => $roles_permission->role_id,
                'permission_id' => $roles_permission->permission_id,
            ]);
        }
    }
}
