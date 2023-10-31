<?php

namespace Modules\Core\Http\Controllers\Admin\errors;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ErrorController
{
    public function resolve( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.errors.errors')
            ->setAction('resolve')->render();
    }

}
