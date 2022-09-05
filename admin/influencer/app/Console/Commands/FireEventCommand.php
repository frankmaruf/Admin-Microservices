<?php

namespace App\Console\Commands;

use App\Jobs\Checked;
use Illuminate\Console\Command;

class FireEventCommand extends Command
{

    protected $signature = 'fire';

    public function handle()
    {
        
        Checked::dispatch("admin@gmail.com")->onQueue("checkout_queue");
    }
}
 