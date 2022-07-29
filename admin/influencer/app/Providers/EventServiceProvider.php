<?php

namespace App\Providers;


use App\Events\OrderCompletedEvent;
use App\Events\ProductUpdateEvent;
use App\Listeners\ProductCacheFlush;
use App\Listeners\UpdateRankingsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCompletedEvent::class => [
            UpdateRankingsListener::class,
        ],
        ProductUpdateEvent::class => [
            ProductCacheFlush::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
