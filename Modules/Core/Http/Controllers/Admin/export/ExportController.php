<?php

namespace Modules\Core\Http\Controllers\Admin\export;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ExportController
{
    public function export( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.export.export')
            ->setAction('export')->render();
    }

    public function import( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.export.export')
            ->setAction('import')->render();
    }

}
