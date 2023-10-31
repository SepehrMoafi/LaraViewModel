<?php

namespace Modules\Core\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function mainSettingForm( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')->setViewModel('admin.setting.main_setting')->setAction('showForm')->render();
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function mainSettingSave(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel->setModule('Core')->setRequest($request)->setViewModel('admin.setting.main_setting')->setAction('save')->render();
    }

}
