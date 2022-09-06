<?php

namespace App\Console\Commands;

use App\Jobs\ProductCreated;
use App\Models\Product;
use Illuminate\Console\Command;

class FireEventCommand extends Command
{

    protected $signature = 'fire';

    public function handle()
    {
        $product = Product::find(1)->toArray();
        ProductCreated::dispatch($product)->onQueue("checkout_queue");
    }
}