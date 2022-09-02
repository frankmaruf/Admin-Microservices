<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsCommand extends Command
{
    protected $signature = 'update:rankings';
    protected $description = "
     Just Update Influencer's Rankings
    ";
    public function handle()
    {
        $userService = new UserService();
        $users = collect($userService->all(-1));
        // print($users);
        $users = $users->filter(fn($user) => $user["is_influencer"] === 1);
        // $users = $users->filter(function ($user){
        //     return  $user->is_influencer;
        // });
            $users->each(function($user){
                $orders = Order::where('user_id',$user["id"])->where("completed",1)->get();
                $revenue = $orders->sum(function (Order $order){
                    return number_format(
                        $order->influencer_total,
                        2,
                        '.',
                        ''
                    );
                });
                Redis::zadd('rankings',$revenue,$user["first_name"] . "" . $user["last_name"]);
            });  
    }
}
