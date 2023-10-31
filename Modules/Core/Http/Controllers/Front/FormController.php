<?php

namespace Modules\Core\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function store( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('form')->setAction('store')->render();
    }
}
