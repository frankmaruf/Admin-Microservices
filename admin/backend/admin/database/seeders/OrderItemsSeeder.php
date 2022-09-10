<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use DB;
use Illuminate\Database\Seeder;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderItems = DB::connection('old_mysql')->table('order_items')->get();
        foreach ($orderItems as $orderItem){
            OrderItem::create([
                'id' => $orderItem->id,
                'order_id' => $orderItem->order_id,
                'product_id' => $orderItem->product_id,
                'name' => $orderItem->name,
                'quantity' => $orderItem->quantity,
                'revenue' => $orderItem->admin_revenue,
                'price' => $orderItem->price,
                'created_at' => $orderItem->created_at,
                'updated_at' => $orderItem->updated_at,
            ]);
        }
    }
}
