<?php

namespace Modules\Shop\ViewModels\Admin\ProductCatalog;

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
use Modules\Shop\Entities\Attribute;
use Modules\Shop\Entities\AttributeValue;
use Modules\Shop\Entities\AttributeValueProduct;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class ProductCatalogActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new ProductCatalog();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::productCatalog.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'en_title' => 'required|max:255',
            //'2nd_title' => 'required|max:255',
            'type' => 'required',
            'brand_id' => '',
            'product_attribute' => '',
            'description' => '',
            'params.meta_description'=> '',
            'params.meta_key'=> '',
        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {

        $this->modelData = ProductCatalog::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::productCatalog.form' ,$data);
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
            $model = ProductCatalog::find( $request->model_id ) ?? new ProductCatalog();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
            unset($validData['params']);

            $model->fill($validData);

            if ($request->image){
                $model->image = $this->uploadFile($request , 'image' , 'product');
            }

            $model->is_active  = $request->is_active == "on" ? 1 : 0;
            $model->is_special  = $request->is_special == "on" ? 1 : 0;
            $model->is_coming_soon  = $request->is_coming_soon == "on" ? 1 : 0;
            $model->out_of_sell  = $request->out_of_sell == "on" ? 1 : 0;

            $model->save();

            if ( $request->file('images') ){

                foreach ($request->file('images') as $image ){

                    DropZoneController::SaveImage($image, 'shop', ProductCatalog::class , $model->id , 'product' , $model->title );

                }
            }

            // category
            $old_cats = ProductCatalogCategoryRel::where('product_catalog_id' ,$model->id )->delete();
            if ($request['categories'] && count($request['categories'] ) > 0 ){
                foreach ($request['categories'] as $category) {
                    $rel_cat = new ProductCatalogCategoryRel();
                    $rel_cat->product_catalog_id = $model->id;
                    $rel_cat->category_id = $category;
                    $rel_cat->save();
                }
            }


            $old_rel_products = ProductCatalogRel::where('parent_product_catalog_id' ,$model->id )->delete();

            if ($request['rel_products'] && count($request['rel_products'] ) > 0 ){
                foreach ($request['rel_products'] as $rel_products_id) {
                    $rel_p = new ProductCatalogRel();
                    $rel_p->parent_product_catalog_id = $model->id;
                    $rel_p->product_catalog_id = $rel_products_id;
                    $rel_p->save();
                }
            }

            $old_rel_products_ac = ProductCatalogRelAccessory::where('parent_product_catalog_id' ,$model->id )->delete();
            if ($request['rel_product_catalog_accessory'] && count($request['rel_product_catalog_accessory'] ) > 0 ){
                foreach ($request['rel_product_catalog_accessory'] as $rel_products_id_ac) {
                    $rel_p_ac = new ProductCatalogRelAccessory();
                    $rel_p_ac->parent_product_catalog_id = $model->id;
                    $rel_p_ac->product_catalog_id = $rel_products_id_ac;
                    $rel_p_ac->save();
                }
            }


            /// save attr
            $old_attr_items= AttributeValueProduct::where('product_catalogs_id' ,$model->id )->delete();
            if (request('attrs')){
                foreach (request('attrs') as $key => $item) {
                    foreach ($item as $attr_val) {

                        if (! $attr_val['value']){
                            continue;
                        }
                        $value_object = AttributeValue::where('attribute_id' , $key )->where('value' , $attr_val['value'])->first();
                        if ( ! $value_object){
                            $value_object = new AttributeValue();
                            $value_object->attribute_id = $key;
                            $value_object->value = $attr_val['value'];
                            $value_object->save();
                        }
                        $new_attr_item = new AttributeValueProduct();
                        $new_attr_item->product_catalogs_id = $model->id;
                        $new_attr_item->attribute_id = $key;
                        $new_attr_item->value_id = $value_object->id;
                        $new_attr_item->save();
                    }
                }

            }

            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect(route('admin.shop.product-catalog.index'));

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

    public function getAuthorsList()
    {
        return User::query()->get();
    }
    public function getCategoriesList()
    {
        return ProductCatalogCategory::query()->get();
    }

    public function getProductList()
    {
        return ProductCatalog::query()->where('type' , 1)->get();
    }

    public function getProductAccessoryList()
    {
        return ProductCatalog::query()->where('type' , 2)->get();
    }
    public function getBrandList()
    {
        return Brand::query()->get();
    }

    public function getAttributeList()
    {
        return Attribute::query()->get();
    }



}
