<?php

namespace Database\Seeders;

use App\Models\OrderItem;
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
            ProductSeeder::class,
            LinkSeeder::class,
            LinkProductSeeder::class,
            OrderSeeder::class,
            OrderItemsSeeder::class
        ]);
    }
}
