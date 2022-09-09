<?php

namespace App\Providers;

use App;
use App\Jobs\AdminAdded;
use App\Jobs\OrderCompleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    public function boot()
    {
        App::bindMethod(AdminAdded::class,'@handle',fn($job)=>$job->handle());
        App::bindMethod(OrderCompleted::class,'@handle',fn($job)=>$job->handle());
    }
}
