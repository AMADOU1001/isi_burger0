<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Les événements et leurs écouteurs.
     *
     * @var array
     */
    protected $listen = [
        // Événement : OrderValidated
        \App\Events\OrderValidated::class => [
            \App\Listeners\SendOrderValidatedNotification::class,
        ],
    ];

    /**
     * Enregistrez les événements pour votre application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
