<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class NotifyAdminListener
{
    
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->order;
        Mail::send('influencer.admin',["order"=>$order],function(Message $message){
            $message->to("admin@admin.com")->subject("A New Order Has Been Placed");
        });
    }
}
