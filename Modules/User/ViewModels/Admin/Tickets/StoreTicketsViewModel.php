<?php

namespace Modules\User\ViewModels\Admin\Tickets;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\NewsletterSubscription;
use Modules\User\Entities\Ticket;

class StoreTicketsViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function store()
    {

        try {
            DB::beginTransaction();
            $validatedData = request()->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'department_id' => 'required|exists:departments,id',
            ]);

            $ticket = Ticket::create([
                'user_id' => auth()->id(),
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'department_id' => $validatedData['department_id'],
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('ticket error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.user.tickets.index');
    }
}
