<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $old_users = DB::connection('mysql2')->table('users')->get();
    foreach ($old_users as $old_user) {
        User::created([
            'id' => $old_user->id,
            'first_name' => $old_user->first_name,
            'last_name' => $old_user->last_name,
            'email' => $old_user->email,
            'password' => $old_user->password,
            "is_influencer" => $old_user->is_influencer,
            'created_at' => $old_user->created_at,
            'updated_at' => $old_user->updated_at,
        ]);
    }
    }
}
