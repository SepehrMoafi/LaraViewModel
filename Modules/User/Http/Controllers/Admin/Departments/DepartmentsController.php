<?php

namespace Modules\User\Http\Controllers\Admin\Departments;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class DepartmentsController
{
    public function index(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('admin.Departments.Department')
            ->setAction('showGrid')
            ->render();
    }

    public function show($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.Departments.Department')
            ->setAction('show')
            ->render();
    }

    public function create(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request )
            ->setViewModel('admin.Departments.Department')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request )
            ->setViewModel('admin.Departments.Department')
            ->setAction('store')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.Departments.Department')
            ->setAction('destroy')
            ->render();
    }
    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.Departments.Department')
            ->setAction('update')
            ->render();
    }
}
