<?php

namespace App\Listeners;

use App\Events\AdminAddedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class NotifyAddedAdminListener
{
    public function handle(AdminAddedEvent $event)
    {
        $user = $event->user;
        Mail::send('admin.adminAdded',["order"=>$user],function(Message $message) use ($user){
            $message->to($user->email)->subject("You Have Been Added To The Admin App");
        });
    }
}
