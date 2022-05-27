<?php

namespace App\Listeners;

use Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductCacheFlush
{
   
    public function handle($event)
    {
        // \Artisan::call('cache:clear');
        Cache::forget('products');
    }
}
