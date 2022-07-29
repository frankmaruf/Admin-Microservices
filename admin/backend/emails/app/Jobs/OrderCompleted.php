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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('influencer.admin',[
            "id"=>$this->data["id"],
            "payment_transaction_amount"=>$this->data["payment_transaction_amount"],
            "payment_transaction_currency"=>$this->data["payment_transaction_currency"],
            "admin_total"=>$this->data["admin_total"],
        ],function(Message $message){
            $message->to("admin@admin.com")->subject("A New Order Has Been Placed");
        });
        Mail::send('influencer.influencer',[
            "influencer_total"=>$this->data["influencer_total"],
            "link"=>$this->data["link"],
        ],function(Message $message){
            $message->to($this->data["influencer_email"])->subject("A New Order Has Been Placed");
        });
    }
}
