<?php

namespace Modules\Blog\Http\Controllers\Admin\PostCategory;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class PostCategoryController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Blog')
            ->setViewModel('admin.post_category.post_category')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('admin.post_category.post_action_category')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest($request)
            ->setViewModel('admin.post_category.post_action_category')
            ->setAction('store')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post_category.post_action_category')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post_category.post_action_category')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.post_category.post_action_category')
            ->setAction('destroy')
            ->render();
    }




}
