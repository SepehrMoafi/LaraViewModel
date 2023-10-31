<?php

namespace Modules\Core\ViewModels\Admin\Block;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Block\Post\PostBlock;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Block\CardConnectedBlock\CardConnectedBlock;
use Modules\Core\Block\CustomerComment\CustomerComment;
use Modules\Core\Block\Faq\Faq;
use Modules\Core\Block\Form\Form;
use Modules\Core\Block\IconText\IconTextBlock;
use Modules\Core\Block\imageAndText\imageAndText;
use Modules\Core\Block\Map\Map;
use Modules\Core\Block\SingleImage\SingleImage;
use Modules\Core\Block\Slider\SliderBlock;
use Modules\Core\Entities\RouteBlock;
use Modules\Core\Entities\RouteBlockItem;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Block\ProductCategory\ProductCategoryBlock;
use Modules\Shop\Block\Products\DiscountProductBlock;
use Modules\Shop\Block\Products\ProductBlock;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\ProductCatalogCategory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class BlockActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }
    public function create()
    {
        $this->modelData = new RouteBlock();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('core::Block.form' ,$data);
    }
    public function store($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'route_name'=> 'required',
        ]);
        return $this->saveService($validated , $request);
    }

    public function edit($request)
    {
        $this->modelData = RouteBlock::find( $request->model_id );
        $data=[
            'view_model' => $this,
        ];
        return $this->renderView('core::Block.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();

            $model = RouteBlock::find( $request->model_id );
            $model->delete();
            alert()->success('با موفقیت انجام شد');

            DB::commit();
            return redirect(route('admin.core.blocks.index'));
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
            $model = RouteBlock::find( $request->model_id ) ?? new RouteBlock();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            if ($request['params']){
                foreach ($request['params'] as $key => $data){
                    $params->$key = $data;
                }
                $model->params = json_encode($params);
                unset($validData['params']);
            }


            $model->fill($validData);

            $model->save();

            DB::commit();
            alert()->success('با موفقیت انجام شد');

            return redirect(route('admin.core.blocks.index'));

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

    public function getRouteList()
    {
        $items = array();

        $index = new \stdClass();
        $index->id = 1 ; $index->title = 'صفحه اصلی'; $index->route_name = 'front.core.index';
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 2 ; $index->title = 'درباره ما'; $index->route_name = 'front.core.about';
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 3 ; $index->title = 'ارتباط با ما'; $index->route_name = 'front.core.contact';
        $items[] = $index;

        return $items;

    }

    public static function getBlockList()
    {

        $items = array();

        $index = new \stdClass();
        $index->id = 1 ; $index->title = 'اسلایدر'; $index->class = SliderBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 2 ; $index->title = 'دسته بندی محصولات'; $index->class = ProductCategoryBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 3 ; $index->title = 'نمایش محصول'; $index->class = ProductBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 4 ; $index->title = 'پیشنهاد و تخفیف'; $index->class = DiscountProductBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 5 ; $index->title = 'مقالات'; $index->class = PostBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 6 ; $index->title = 'ایکون و متن'; $index->class = IconTextBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 7 ; $index->title = 'فرم'; $index->class = Form::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 8 ; $index->title = 'نقشه'; $index->class = Map::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 9 ; $index->title = 'سوالات پر تکرار'; $index->class = Faq::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 10 ; $index->title = 'تک عکس'; $index->class = SingleImage::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 11 ; $index->title = 'عکس و متن'; $index->class = imageAndText::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 12 ; $index->title = 'کارت و ایکون'; $index->class = CardConnectedBlock::class;
        $items[] = $index;

        $index = new \stdClass();
        $index->id = 13 ; $index->title = 'نظر مشتریان'; $index->class = CustomerComment::class;
        $items[] = $index;

        return Collect($items);
    }

    public function addBlockToRouteBlock($request)
    {

        try {
            DB::beginTransaction();
            $block_item = new RouteBlockItem();
            $block_item->route_block_id = request('route_block_id');
            $block_item->block_id = request('block_id');
            $block_item->save();
            alert()->toast('با موفقیت انجام شد' , 'success');
            DB::commit();
            return redirect()->back()->withInput();
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

    public function updateRouteBlockItemConfig()
    {

        try {
            DB::beginTransaction();
            $block_route_item = RouteBlockItem::find( request('block_route_item_id') );

            $block_obj = BlockActionViewModel::getBlockList()->where('id' , $block_route_item->block_id)->first();
            $block_class = new $block_obj->class($block_route_item->id );
            $block_class->saveConfig();
            alert()->toast('با موفقیت انجام شد' , 'success');
            DB::commit();
            return redirect()->back()->withInput();
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

    public function removeRouteBlockItem()
    {

        try {
            DB::beginTransaction();
            $block_route_item = RouteBlockItem::find( request('block_route_item_id') );
            $block_route_item->delete();

            alert()->toast('با موفقیت انجام شد' , 'success');
            DB::commit();
            return redirect()->back()->withInput();
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


}
