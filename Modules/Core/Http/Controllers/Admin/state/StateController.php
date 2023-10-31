<?php

namespace Modules\Core\Http\Controllers\Admin\state;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class StateController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.state.stateIndex')
            ->setAction('showGrid')->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request)
            ->setViewModel('admin.state.stateStore')
            ->setAction('store')
            ->render();
    }

    public function update($id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.state.stateUpdate')
            ->setAction('update')
            ->render();
    }

    public function destroy($id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.state.stateDestroy')
            ->setAction('destroy')
            ->render();
    }

}
