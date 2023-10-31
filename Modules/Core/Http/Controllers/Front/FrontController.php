<?php

namespace Modules\Core\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('front')->setAction('index')->render();
    }
    public function contact( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('front')->setAction('contact')->render();
    }
    public function about( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('front')->setAction('about')->render();
    }
    public function showPage( $page ,MasterViewModel $masterViewModel , Request $request)
    {
        return $masterViewModel->setModule('Core')->setViewModel('front')->setRequest($request , ['page' => $page])->setAction('showPage')->render();
    }

}
