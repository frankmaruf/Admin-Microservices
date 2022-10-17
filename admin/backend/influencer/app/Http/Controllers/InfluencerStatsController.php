<?php

namespace App\Http\Controllers;

use App\Common\UserService;
use App\Models\Links;
use App\Models\Order;

class InfluencerStatsController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $user = $this->userService->getUser();
        $links = Links::where('user_id', $user->id)->get();
        return $links->map(function (Links $link) {
            $orders = Order::where('link', $link->link)->where("completed", 1)->get();
            return [
                'link' => $link->link,
                'clicks' => $orders->count(),
                'revenue' => $orders->sum(function (Order $order) {
                    return $order->total;
                })
            ];
        });
    }
    // public function rankings(){
    //     return Redis::zrevrange('rankings',0,-1,'WITHSCORES');
        
    // }
    public function rankings(){
        $users = collect($this->userService->all(-1));
        $users = $users->filter(function ($user){
            return $user['is_influencer'];
        });
        // print($users);
        $rankings = $users->map(function($user){
            $orders = Order::where('user_id',$user['id'])->where("completed",1)->get();
            return [
                'name' => $user["first_name"] ,
                'revenue' => $orders->sum(function (Order $order) {
                    return number_format(
                        $order->total,
                        2,
                        '.',
                        ''
                    );
                })
            ];
        });
        return $rankings->sortByDesc('revenue')->values();    
    }
}
