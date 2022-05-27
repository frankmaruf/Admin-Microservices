<?php

namespace App\Http\Controllers\Influencer;

use App\Models\Links;
use App\Models\Order;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class InfluencerStatsController
{
    public function index(Request $request)
    {
        $user = $request->user();
        $links = Links::where('user_id', $user->id)->get();
        return $links->map(function (Links $link) {
            $orders = Order::where('link', $link->link)->where("completed", 1)->get();
            return [
                'link' => $link->link,
                'clicks' => $orders->count(),
                'revenue' => $orders->sum(function (Order $order) {
                    return $order->influencer_total;
                })
            ];
            // return [
            //     'id' => $link->id,
            //     'link' => $link->link,
            //     'clicks' => $link->clicks,
            //     'views' => $link->views,
            //     'revenue' => $link->revenue,
            //     'created_at' => $link->created_at,
            //     'updated_at' => $link->updated_at,
            // ];
        });
    }
    public function rankings(){
        return Redis::zrevrange('rankings',0,-1,'WITHSCORES');
        
    }
    // public function rankings(){
    //     $users = User::where('is_influencer', 1)->get();
    //     $rankings = $users->map(function(User $user){
    //         $orders = Order::where('user_id',$user->id)->where("completed",1)->get();
    //         return [
    //             'name' => $user->full_name,
    //             'revenue' => $orders->sum(function (Order $order) {
    //                 return number_format(
    //                     $order->influencer_total,
    //                     2,
    //                     '.',
    //                     ''
    //                 );
    //             })
    //         ];
    //     });
    //     return $rankings->sortByDesc('revenue')->values();    
    // }
}
