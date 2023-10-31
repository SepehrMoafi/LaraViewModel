<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('admin')->setAction('index')->render();
    }

    public function fileManager( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('admin')->setAction('fileManager')->render();
    }

}
