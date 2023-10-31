<?php

namespace Modules\Core\Http\Controllers\Admin\slider;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class SliderController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.slider.slider')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setViewModel('admin.slider.slider_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request)
            ->setViewModel('admin.slider.slider_action')
            ->setAction('store')
            ->render();
    }
    public function edit($slider_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['slider_id' => $slider_id ] )
            ->setViewModel('admin.slider.slider_action')
            ->setAction('edit')
            ->render();
    }

    public function update($slider_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['slider_id' => $slider_id ] )
            ->setViewModel('admin.slider.slider_action')
            ->setAction('update')
            ->render();
    }




}
