<?php

namespace Modules\Blog\Http\Controllers\Admin\posts;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class PostController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Blog')
            ->setViewModel('admin.post.post')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('admin.post.post_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest($request)
            ->setViewModel('admin.post.post_action')
            ->setAction('store')
            ->render();
    }
    public function storeImageMedia(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest($request)
            ->setViewModel('admin.post.storeImageMedia')
            ->setAction('storeImageMedia')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post.post_action')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post.post_action')
            ->setAction('update')
            ->render();
    }
    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post.post_action')
            ->setAction('destroy')
            ->render();
    }




}
