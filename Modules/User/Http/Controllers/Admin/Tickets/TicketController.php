<?php

namespace Modules\User\Http\Controllers\Admin\Tickets;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class TicketController
{
    public function index(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('admin.tickets.indexTickets')
            ->setAction('showGrid')
            ->render();
    }

    public function show($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.tickets.showTickets')
            ->setAction('show')
            ->render();
    }

    public function store($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.tickets.storeTickets')
            ->setAction('store')
            ->render();
    }
}
