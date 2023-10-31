<?php

namespace Modules\Shop\Http\Controllers\Admin\Copan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class CopanController extends Controller
{
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.Copan.copanIndex')
            ->setAction('showGrid')->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.copan.copanStore')
            ->setAction('store')
            ->render();
    }

    public function update($id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.copan.copanUpdate')
            ->setAction('update')
            ->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
        ->setModule('Shop')
        ->setViewModel('admin.copan.copanCreate')
        ->setAction('create')
        ->render();
    }

    public function destroy($id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.copan.copanDestroy')
            ->setAction('destroy')
            ->render();
    }
}
