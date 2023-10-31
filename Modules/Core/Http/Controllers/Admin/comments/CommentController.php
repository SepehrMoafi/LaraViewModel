<?php

namespace Modules\Core\Http\Controllers\Admin\comments;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class CommentController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.comment.commentIndex')
            ->setAction('showGrid')->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request)
            ->setViewModel('admin.comment.commentStore')
            ->setAction('store')
            ->render();
    }

    public function approve($id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request,['model_id' => $id ])
            ->setViewModel('admin.comment.commentApprove')
            ->setAction('approve')
            ->render();
    }

    public function update($id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.comment.commentUpdate')
            ->setAction('update')
            ->render();
    }

    public function destroy($id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $id ] )
            ->setViewModel('admin.comment.commentDestroy')
            ->setAction('destroy')
            ->render();
    }

}
