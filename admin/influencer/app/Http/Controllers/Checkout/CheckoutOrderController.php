<?php

namespace App\Http\Controllers\Checkout;

use App\Events\OrderCompletedEvent;
use App\Jobs\OrderCompleted;
use App\Models\Links;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class CheckoutOrderController
{
    public function store(Request $request)
    {
        $links = Links::whereLink($request->input("link"))->first();
        DB::beginTransaction();
        $order = new Order();
        // get logged in user first name
        $order->first_name = $request->input("first_name");
        $order->last_name = $request->input("last_name");
        $order->email = $request->input("email");
        $order->link = $links->link;
        $order->user_id = $links->user->id;
        $order->influencer_email = $links->user->email;
        $order->phone = $request->input("phone");
        $order->address = $request->input("address");
        $order->city = $request->input("city");
        $order->country = $request->input("country");
        $order->postal_code = $request->input("postal_code");
        $order->payment_method = $request->input("payment_method");
        $order->payment_status = $request->input("payment_status");
        $order->payment_id = $request->input("payment_id");
        $order->payment_amount = $request->input("payment_amount");
        $order->payment_currency = $request->input("payment_currency");
        $order->payment_description = $request->input("payment_description");
        $order->payment_status_detail = $request->input("payment_status_detail");
        $order->payment_created_at = $request->input("payment_created_at");
        $order->payment_updated_at = $request->input("payment_updated_at");
        $order->payment_transaction_id = $request->input("payment_transaction_id");
        $order->payment_transaction_type = $request->input("payment_transaction_type");
        $order->payment_transaction_status = $request->input("payment_transaction_status");
        $order->payment_transaction_amount = $request->input("payment_transaction_amount");
        $order->payment_transaction_currency = $request->input("payment_transaction_currency");
        $order->completed = $request->input("completed");
        $order->save();
        $lineItems = [];
        foreach ($request->input("items") as $item) {
            $product = Product::find($item["product_id"]);
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item["product_id"];
            $orderItem->name = $product->name;
            $orderItem->price = $product->price;
            $orderItem->quantity = $item["quantity"];
            $orderItem->influencer_revenue = 0.1 * $product->price * $item["quantity"];
            $orderItem->admin_revenue = 0.9 * $product->price * $item["quantity"];
            $orderItem->save();
            $lineItems[] = [
                "name" => $product->name,
                "description" => $product->description,
                "images" => [
                    $product->image
                ],
                "amount" => 100 * $product->price,
                "currency" => "USD",
                "quantity" => $item["quantity"],
            ];
            // $lineItems[] = [
            //     "name" => $product->name,
            //     "description" => $product->description,
            //     "images" => [
            //         $product->image
            //     ],
            //     "quantity" => $item["quantity"],
            //     "unit_amount" => [
            //         "value" => $product->price,
            //         "currency_code" => "USD",
            //     ],
            // ];
        }
        // $stripe = Stripe::make(env('STRIPE_SECRET'));
        // $stripe = Stripe::make('sk_test_51L0f1aK58sSCMALZGYRkmBHaXUQ1QsJsVyC1CdIY0a4a0G2NVnj5FbSEkRih2mXII0JgVBus45kKDPUCEv2c2uVC00u3az6nzt');
        // $source = $stripe->sources()->create([
        //     'payment_method_types' => 'card',
            // 'card' => [
            //     'number' => $request->input("card_number"),
            //     'exp_month' => $request->input("card_exp_month"),
            //     'exp_year' => $request->input("card_exp_year"),
            //     'cvc' => $request->input("card_cvc"),
            // ],
        //     "line_items" => $lineItems,
        //     "success_url" => env("CHECKOUT_URL") . "/success?source_id={CHECKOUT_SESSION_ID}",
        //     "cancel_url" => env("CHECKOUT_URL") . "/error?source_id={CHECKOUT_SESSION_ID}",
        // ]);
        // $order->payment_transaction_id = $source->id;
        $order->save();
        DB::commit();
        event(new OrderCompletedEvent($order));
        $data = $order->toArray();
        $data['admin_total'] = $order->admin_total;
        $data['influencer_total'] = $order->influencer_total;
        OrderCompleted::dispatch($data);
        return $order;
    }
    public function confirm(Request $request)
    {
        $order = Order::wherePaymentTransactionId($request->input("source_id"))->first();
        if (!$order) {
            return response()->json([
                "status" => "error",
                "message" => "Order not found"
            ]);
        }
        if($order->completed == 1){
            return response()->json([
                "status" => "error",
                "message" => "Order already completed"
            ]);
        }
        $order->payment_status = "paid";
        $order->completed = 1;
        $order->save();
        return response([
            'message' => 'Payment Successful',
        ]);
    }
}
