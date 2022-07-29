<?php

namespace App\Console\Commands;

use App\Jobs\AdminAdded;
use App\Jobs\OrderCompleted;
use App\Models\Order;
use Illuminate\Console\Command;

class FireEventCommand extends Command
{

    protected $signature = 'fire';

    public function handle()
    {
        $order = Order::find(1);
        $data = $order->toArray();
        $data['id'] = $order->id;
        $data['admin_total'] = $order->admin_total;
        $data['payment_transaction_amount'] = $order->payment_transaction_amount;
        $data['payment_transaction_currency'] = $order->payment_transaction_currency;
        $data['influencer_total'] = $order->influencer_total;
        $data['influencer_email'] = $order->influencer_email;
        $data['link'] = $order->link;
        OrderCompleted::dispatch($data);
        // AdminAdded::dispatch('a@a.com');
    }
}
 