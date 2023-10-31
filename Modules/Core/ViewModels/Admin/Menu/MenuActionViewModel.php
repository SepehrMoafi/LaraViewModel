<?php

namespace Modules\Core\ViewModels\Admin\Menu;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\Menu;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\ProductCatalogCategory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class MenuActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Menu();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('core::Menu.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'link' => '',
            'sort' => '',
            'parent_id'=> '',

        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {
        $this->modelData = Menu::find( $request->model_id );
        $data=[
            'view_model' => $this,
        ];
        return $this->renderView('core::Menu.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();

            $model = Menu::find( $request->model_id );
            if ($model->childs->count() > 0 ){
                alert()->warning( '','منو انتخاب شده به دلیل داشتن زیر مجموعه امکان حذف ندارد');
                return redirect(route('admin.core.menus.index'));
            }
            $model->delete();
            alert()->success('با موفقیت انجام شد');

            DB::commit();
            return redirect(route('admin.core.menus.index'));
        }catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();
        }
    }

    public function saveService( $validData ,  $request)
    {
        try {
            DB::beginTransaction();
            $model = Menu::find( $request->model_id ) ?? new Menu();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            if ($request['params']){
                foreach ($request['params'] as $key => $data){
                    $params->$key = $data;
                }
            }
            $model->params = json_encode($params);
            unset($validData['params']);

            $model->fill($validData);
            if ($model->parent_id == 0 ){
                $model->parent_id = null;
            }
            if ( ! $model->link ){
                $model->link = '#';
            }

            $model->save();

            DB::commit();
            alert()->success('با موفقیت انجام شد');

            return redirect(route('admin.core.menus.index'));

        }catch (\Exception $e){
            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();
        }

    }

    public function getMenuList()
    {
        return Menu::query()->get();

    }

}
