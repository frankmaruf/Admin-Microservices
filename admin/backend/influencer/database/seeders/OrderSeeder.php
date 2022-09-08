<?php

namespace Database\Seeders;

use App\Models\Order;
use DB;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = DB::connection('old_mysql')->table('orders')->get();
        foreach ($orders as $order){
            Order::create([
                'id' => $order->id,
                'link' => $order->link,
                'user_id' => $order->user_id,
                'completed' => $order->completed,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
    }