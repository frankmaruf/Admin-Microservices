<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class AdminAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        Mail::send('admin.adminAdded',[],function(Message $message){
            $message->to($this->email)->subject("You Have Been Added To The Admin App");
        });
        echo $this->email . PHP_EOL;
    }
}
