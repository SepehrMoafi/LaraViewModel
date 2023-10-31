<?php

namespace Modules\User\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class TicketAnswerController extends Controller
{
    public function create($model_id , Request $request ,MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('admin.tickets.createTicketAnswer')
            ->setAction('create')
            ->render();
    }


    public function store($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest($request , ['ticket_id' => $model_id ])
            ->setViewModel('admin.tickets.storeTicketAnswer')
            ->setAction('store')
            ->render();
    }

}
