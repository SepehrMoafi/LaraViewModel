<?php

namespace Modules\User\ViewModels\Admin\Tickets;

use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Ticket;

class ShowTicketsViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function show()
    {
        $ticket = Ticket::query()->findOrFail(request()->model_id);
        $statusValue = match ($ticket->status) {
            'open' => 'باز',
            'closed' => 'بسته',
            'read' => 'خوانده شده',
            'unread' => 'خوانده نشده',
            'answered' => 'پاسخ داده شده',
            default => 'باز'
        };
        $ticket->status = $statusValue;
        $data = [
            'ticket' => $ticket,
        ];
        return $this->renderView('user::tickets.showForAnswer', $data);
    }
}
