<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\TicketAnswer;

class TicketAnswerObserver
{
    /**
     * Handle the Ticketanswer "creating" event.
     */
    public function creating(Ticketanswer $ticketAnswer): void
    {
        $ticketAnswer->user_id = request()->user_id ?? Auth::id();
    }
    /**
     * Handle the Ticketanswer "created" event.
     */
    public function created(Ticketanswer $ticketAnswer): void
    {
        //
    }

    /**
     * Handle the Ticketanswer "updated" event.
     */
    public function updated(Ticketanswer $ticketAnswer): void
    {
        //
    }

    /**
     * Handle the Ticketanswer "deleted" event.
     */
    public function deleted(Ticketanswer $ticketAnswer): void
    {
        //
    }

    /**
     * Handle the Ticketanswer "restored" event.
     */
    public function restored(Ticketanswer $ticketAnswer): void
    {
        //
    }

    /**
     * Handle the Ticketanswer "force deleted" event.
     */
    public function forceDeleted(Ticketanswer $ticketAnswer): void
    {
        //
    }
}
