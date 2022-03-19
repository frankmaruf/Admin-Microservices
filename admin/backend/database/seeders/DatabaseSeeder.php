<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // first seed Role then wait for RoleSeeder to finish
            RoleSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
