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
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'user_id' => $order->user_id,
                'phone' => $order->phone,
                'address' => $order->address,
                'city' => $order->city,
                'country' => $order->country,
                'postal_code' => $order->postal_code,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'payment_id' => $order->payment_id,
                'payment_amount' => $order->payment_amount,
                'payment_currency' => $order->payment_currency,
                'payment_description' => $order->payment_description,
                'payment_status_detail' => $order->payment_status_detail,
                'payment_created_at' => $order->payment_created_at,
                'payment_updated_at' => $order->payment_updated_at,
                'payment_transaction_id' => $order->payment_transaction_id,
                'payment_transaction_type' => $order->payment_transaction_type,
                'payment_transaction_status' => $order->payment_transaction_status,
                'payment_transaction_amount' => $order->payment_transaction_amount,
                'payment_transaction_currency' => $order->payment_transaction_currency,
                'influencer_email' => $order->influencer_email,
                'completed' => $order->completed,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }
    }