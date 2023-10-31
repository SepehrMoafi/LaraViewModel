<?php

namespace Modules\Core\Http\Controllers\Admin\block;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class BlockController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.block.block')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setViewModel('admin.block.block_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request)
            ->setViewModel('admin.block.block_action')
            ->setAction('store')
            ->render();
    }
    public function edit($id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.block.block_action')
            ->setAction('edit')
            ->render();
    }

    public function update($id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.block.block_action')
            ->setAction('update')
            ->render();
    }

    public function addBlockToRouteBlock( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.block.block_action')
            ->setAction('addBlockToRouteBlock')->render();
    }

    public function updateRouteBlockItemConfig( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.block.block_action')
            ->setAction('updateRouteBlockItemConfig')->render();
    }

    public function removeRouteBlockItem( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.block.block_action')
            ->setAction('removeRouteBlockItem')->render();
    }







}
