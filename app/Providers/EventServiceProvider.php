<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use App\Observers\TicketAnswerObserver;
use App\Observers\productObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Shop\Entities\Order;
use Modules\User\Entities\TicketAnswer;
use Modules\Shop\Entities\Product;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        TicketAnswer::class => [TicketAnswerObserver::class],
        ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Product::observe(productObserver::class);
        Order::observe(OrderObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
