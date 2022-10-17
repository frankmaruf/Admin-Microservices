<?php

namespace App\Http\Controllers;

use App\Common\UserService;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Response;

class OrderController
{
    private $userService;
    private function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index()
    {
        $this->userService->allows('view', 'users');
        $order = Order::paginate();
        return OrderResource::collection($order);
    }
    public function show($id)
    {
        $this->userService->allows('view', 'users');
        $order = Order::findOrFail($id);
        return new OrderResource($order);
    }
    public function export()
    {
        $this->userService->allows('view', 'users');
        $headers = [
            'content-type' => 'text/csv',
            'content-disposition' => 'attachment; filename=orders.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'id',
                'name',
                'email',
                'totalAmount',
                'product_id',
                'product_name',
                'quantity',
                'price',
                'payment_status',
                'pyment_method',
                'payment_id',
                'payment_amount',
                'payment_currency',
                'created_at',
                'updated_at',
            ]);
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->name,
                    $order->email,
                    $order->totalAmount,
                    '',
                    '',
                    '',
                    '',
                    $order->payment_status,
                    $order->pyment_method,
                    $order->payment_id,
                    $order->payment_amount,
                    $order->payment_currency,
                    $order->created_at,
                    $order->updated_at,
                ]);
                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, [
                        '',
                        '',
                        '',
                        '',
                        $orderItem->product_id,
                        $orderItem->product_name,
                        $orderItem->quantity,
                        $orderItem->price,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ]);
                }
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
