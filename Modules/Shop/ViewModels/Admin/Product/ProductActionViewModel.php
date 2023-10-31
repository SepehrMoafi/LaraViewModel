<?php

namespace Modules\Shop\ViewModels\Admin\Product;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class ProductActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Product();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::product.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'product_catalog_id' => 'required',
            'product_code' => '',
            'price' => 'required',
            'discount' => '',
            'qty' => 'required',
            'color' => 'required',
            'warranty' => '',
            'wight' => 'required',
        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {

        $this->modelData = Product::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::product.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();

            $model = User::find( $request->model_id );
            if ($model->childs->count() > 0 ){
                alert()->warning( '','دسته بندی انتخاب شده به دلیل داشتن زیر مجموعه امکان حذف ندارد');
                return redirect(route('admin.blog.post-category.index'));
            }
            $model->delete();
            alert()->success('با موفقیت انجام شد');

            DB::commit();
            return redirect(route('admin.blog.post-category.index'));


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
            $model = Product::find( $request->model_id ) ?? new Product();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            if ($request['params']){

                foreach ($request['params'] as $key => $data){
                    $params->$key = $data;
                }
                $model->params = json_encode($params);
                unset($validData['params']);

            }

            $model->fill($validData);
            $model->product_code = rand(10000, 1000000000);
            $model->save();

            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect(route('admin.shop.product.index'));

        } catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();

        }

    }
    public function getCatalogList()
    {
        $product = ProductCatalog::query()->get();
        return $product ;
    }

}
