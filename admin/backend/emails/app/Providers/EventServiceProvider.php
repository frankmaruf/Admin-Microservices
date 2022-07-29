<?php

namespace App\Providers;

use App;
use App\Events\AdminAddedEvent;
use App\Jobs\AdminAdded;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    public function boot()
    {
        App::bindMethod(AdminAdded::class,'@handle',fn($job)=>$job->handle());
    }
}
