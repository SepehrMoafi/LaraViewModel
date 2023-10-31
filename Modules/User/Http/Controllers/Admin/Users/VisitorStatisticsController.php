<?php

namespace Modules\User\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class VisitorStatisticsController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('User')
            ->setViewModel('admin.user.VisitorStatistics')
            ->setAction('index')->render();
    }
}
