<?php

namespace Database\Seeders;

use App\Models\Permission;
use DB;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = DB::connection('old_mysql')->table('permissions')->get();
        foreach ($permissions as $permission){
            Permission::create([
                'id' => $permission->id,
                'name' => $permission->name,
            ]);
        }
    }
}
