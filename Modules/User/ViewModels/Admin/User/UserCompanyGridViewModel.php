<?php

namespace Modules\User\ViewModels\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
class UserCompanyGridViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = User::query();

        if ( request('title') ){
            $query->where('title' , 'like' , '%' . request('title') . '%');
        }

        if (request('type')){
            $query->where('type' , request('type') );
        }else{
            $query->where('type' , '!=' , 1);
        }

        if (request('company_confirm_status')){
            $query->where('company_confirm_status' , request('company_confirm_status') );
        }else{
            $query->where('company_confirm_status' , 2);
        }

        $this->rows = $query->paginate(40);
        return $this;
    }
    public function setColumns()
    {
        $this->addColumn([
            'name'=>'avatar',
            'title'=>'تصویر',
        ]);

        $this->addColumn([
            'name'=>'name',
            'title'=>'نام و نام‌خانوادگی	',
        ]);
        $this->addColumn([
            'name'=>'email',
            'title'=>'ایمیل',
        ]);

        $this->addColumn([
            'name'=>'mobile',
            'title'=>'شماره تماس',
        ]);

        $this->addColumn([
            'name'=>'date_last_order',
            'title'=>'تاریخ آخرین سفارش ',
        ]);

        $this->addColumn([
            'name'=>'created_at',
            'title'=>'تاریخ ایجاد حساب 	 ',
        ]);

        $this->addColumn([
            'name'=>'order_count',
            'title'=>'تعداد سفارشات	',
        ]);

        $this->addColumn([
            'name'=>'amount',
            'title'=>'کیف پول',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.user.users-company.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        /*** buttons ***/
        $this->addButton([
            'name' => 'addNew',
            'title' => 'دریافت خروجی اکسل',
            'url' => '',
            'class' => 'btn-primary',
        ]);

        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);

        $this->addFilter([
            'name'=>'company_confirm_status',
            'title'=>'وضعیت',
            'type'=>'select',
            'options' => [
                '2'=>'درانتظار تایید',
                '1'=>'تایید',
                '3'=>'رد',
            ]
        ]);
        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);
        $this->addFilter([
            'name'=>'type',
            'title'=>'نوع',
            'type'=>'select',
            'options' => [
                '0'=>' همه',
                '3'=>'حقوقی با جواز',
                '2'=>'حقوقی',
            ]
        ]);

        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->avatar = $row->avatar ? '<img src="'.url($row->avatar).'" style="width: 100px">' : '';
        return $row;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

    public function edit($request)
    {
        $this->modelData = User::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::user.formCompany' ,$data);

    }

    public function update($request)
    {
        $validData = $request->validate([
            'type'=> 'required',
            'company_confirm_status'=> 'required',
            'params.company_name'=> '',
            'params.economic_code'=> '',
            'params.national_id'=> '',
        ]);
        try {
            DB::beginTransaction();
            $model = User::find( $request->model_id ) ?? new User();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
            unset($validData['params']);

            $model->fill($validData);
            $model->save();

            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect()->back()->withInput();

        } catch (\Exception $e) {

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
