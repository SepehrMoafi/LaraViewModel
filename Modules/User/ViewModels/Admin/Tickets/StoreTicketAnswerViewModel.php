<?php

namespace Modules\User\ViewModels\Admin\Tickets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Ticket;
use Modules\User\Entities\TicketAnswer;

class StoreTicketAnswerViewModel
{
    public function store()
    {
        $request = request();
        $ticket = Ticket::query()->findOrFail($request->ticket_id);
        $validatedData = $request->validate([
            'response' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            Ticketanswer::create([
                'ticket_id' => $ticket->id,
                'response' => $validatedData['response'],
            ]);
            $ticket->update(['status' => 'answered']);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::critical('ticket answer error is: ' . $exception->getMessage());
            alert()->toast('مشکلی پیش آمده است', 'error');
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.user.tickets.index');
    }

    public function clientTicketStore()
    {
        $request = request();
        $ticket = Ticket::query()->findOrFail($request->ticket_id);
        $validatedData = $request->validate([
            'response' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            Ticketanswer::create([
                'ticket_id' => $ticket->id,
                'response' => $validatedData['response'],
            ]);
            $ticket->update(['status' => 'open']);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::critical('ticket answer error is: ' . $exception->getMessage());
            alert()->toast('مشکلی پیش آمده است', 'error');
            return redirect()->back();
        }
        DB::commit();
        alert()->toast('پیام با موفقیت ذخیره شد!', 'success');
        return redirect()->back();
    }
}
