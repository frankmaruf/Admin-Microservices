<?php

namespace Database\Seeders;

use App\Models\UserRole;
use DB;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = DB::connection('old_mysql')->table('user_roles')->get();
        foreach ($user_roles as $user_role){
            UserRole::create([
                'id' => $user_role->id,
                'user_id' => $user_role->user_id,
                'role_id' => $user_role->role_id,
            ]);
        }
    }
}
