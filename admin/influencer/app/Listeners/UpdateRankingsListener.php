<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Services\UserService;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsListener
{
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->order;
        $revenue = $order->influencer_total;
        $userService = new UserService();
        $user = $userService->getUser($order->user_id);
        Redis::zincrby('rankings', $revenue, $user->fullName());
    }
}
