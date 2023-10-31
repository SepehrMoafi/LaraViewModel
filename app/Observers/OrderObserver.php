<?php

namespace App\Observers;

use Modules\Shop\Entities\Order;
use Modules\User\Notifications\NewsletterSubscriptionNotification;
use Modules\User\Trait\orderTaraz;

class OrderObserver
{
    use orderTaraz;

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $originalParams = json_decode($order->getOriginal('params'), true);
        $updatedParams = json_decode($order->params, true);

        if ($updatedParams['track_code'] && !isset($originalParams['track_code']) ) {
            $user = $order->user;
            $user->notifyNow(new NewsletterSubscriptionNotification("کد پیگیری سفارش شما ثبت شد"));
        }

        if ($order->isDirty('status')) {
            $user = $order->user;
            $user->notify(new NewsletterSubscriptionNotification("وضعیت سفارش شما تغییر کرد"));
        }

        if ($order->payable_amount <= 0){
            $this->syncOrder( $order );
        }

    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
