<?php

namespace Modules\Shop\ViewModels\Admin\Order;

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
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\User\Notifications\NewsletterSubscriptionNotification;
use Modules\User\Trait\authTaraz;
use Modules\User\Trait\orderTaraz;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class OrderActionViewModel extends BaseViewModel
{
    use orderTaraz;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Brand();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::Brand.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);
        return $this->saveService($validated , $request);
    }

    public function edit($request)
    {

        $this->modelData = Order::find( $request->model_id );
        $order = $this->modelData ;

        $data=[
            'order' => $order,
            'view_model' => $this,
        ];

        return $this->renderView('shop::Order.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function destroy($request)
    {
        try {
            DB::beginTransaction();

            $model = Order::find( $request->model_id );
            if ($model->childs->count() > 0 ){
                alert()->warning( '','دسته بندی انتخاب شده به دلیل داشتن زیر مجموعه امکان حذف ندارد');
                return redirect(route('admin.shop.brand.index'));
            }
            $model->delete();
            alert()->success('با موفقیت انجام شد');

            DB::commit();
            return redirect(route('admin.shop.brand.index'));
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
            $model = Order::find( $request->model_id ) ?? new Order();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            if ( $request['params'] ){
                foreach ($request['params'] as $key => $data){
                    $params->$key = $data;
                }
                $model->params = json_encode($params);
                unset($validData['params']);
            }
            $model->status = request('status');

            $model->save();

            DB::commit();
//            $modelStatus = Order::STATUS[$model->status];
//            $model->user->notifyNow(new NewsletterSubscriptionNotification("وضعیت سفارش شما در حالت {$modelStatus} قرار گرفت"));

            alert()->success('با موفقیت انجام شد');

            return redirect(route('admin.shop.orders.index'));

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

    public function sendApi($request)
    {
        $model = Order::findOrFail( $request->model_id ) ;
        $res = $this->syncOrder( $model );
        if ($res){

            alert()->success('با موفقیت انجام شد');
            return redirect()->back()->withInput();
        }else{

            alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            return redirect()->back()->withInput();
        }

    }

}
