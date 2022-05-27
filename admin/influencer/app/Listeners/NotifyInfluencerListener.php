<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class NotifyInfluencerListener
{
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->order;
        Mail::send('influencer.influencer',["order"=>$order],function(Message $message) use ($order){
            $message->to($order->influencer_email)->subject("A New Order Has Been Placed");
        });
    }
}
