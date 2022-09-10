<?php

namespace Database\Seeders;

use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::connection('old_mysql')->table('roles')->get();
        foreach ($roles as $role){
            Role::create([
                'id' => $role->id,
                'name' => $role->name,
            ]);
        }
    }
}
