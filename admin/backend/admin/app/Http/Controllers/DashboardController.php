<?php

namespace App\Http\Controllers;

use App\Common\UserService;
use App\Http\Resources\ChartResource;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function chart()
    {
        $this->userService->allows('edit', 'products');
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity*order_items.price) as sum")
            ->groupBy('date')
            ->get();
        return ChartResource::collection($orders);
    }
    public function chartByDateAndTime(Request $request)
    {
        // Send in jsong format with date and time
        // {
        //     "start" : "2022-03-15 12:08:40",
        //     "end" : "2022-03-15 12:08:40"
        // }
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity*order_items.price) as sum")
            ->where('orders.created_at', '>=', $request->start)
            ->where('orders.created_at', '<=', $request->end)
            ->groupBy('date')
            ->get();
        return response()->json($orders);
    }
    public function chartByOrderID(Request $request)
    {
        // Send in jsong format
        // {
        //     "start": "272",
        //     "end": "272"
        // }
        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity*order_items.price) as sum")
            ->where('orders.id', '>=', $request->start)
            ->where('orders.id', '<=', $request->end)
            ->groupBy('date')
            ->get();
        return response()->json($orders);
    }
}
