<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Message;
use Mail;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderData;
    public $orderItemsData;
    public function __construct($orderData, $orderItemsData)
    {
        $this->orderData = $orderData;
        $this->orderItemsData = $orderItemsData;
    }
    public function handle()
    {
        Mail::send('influencer.admin',[
            "id"=>$this->orderData["id"],
            "payment_transaction_amount"=>$this->orderData["payment_transaction_amount"],
            "payment_transaction_currency"=>$this->orderData["payment_transaction_currency"],
            "admin_total"=>$this->orderData["admin_total"],
        ],function(Message $message){
            $message->to("admin@admin.com")->subject("A New Order Has Been Placed");
        });
        Mail::send('influencer.influencer',[
            "influencer_total"=>$this->orderData["influencer_total"],
            "link"=>$this->orderData["link"],
        ],function(Message $message){
            $message->to($this->orderData["influencer_email"])->subject("A New Order Has Been Placed");
        });
    }
}
