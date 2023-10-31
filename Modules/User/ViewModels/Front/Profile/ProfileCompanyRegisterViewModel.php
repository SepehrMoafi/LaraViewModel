<?php

namespace Modules\User\ViewModels\Front\Profile;

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
use Modules\Shop\Entities\ProductCatalog;
use Modules\User\Entities\UserFavorite;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class ProfileCompanyRegisterViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function companyRegister_1()
    {
        $this->modelData = User::find(auth()->user()->id);
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.company_register_1' ,$data);

    }
    public function companyRegisterSubmit_1($request){

        $validData = $request->validate([
            'params.company_name'=> 'required',
            'params.national_id'=> 'required',
            'params.economic_code'=> 'required',
            'company_doc_1'=> '',
        ]);

        try {
            DB::beginTransaction();
            $model = User::find(auth()->user()->id);

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            if ($request->company_doc_1){
                $params->company_doc_1 = $this->uploadFile($request , 'company_doc_1' , 'company_doc_1');
            }

            $model->params = json_encode($params);
            unset($validData['params']);
            unset($validData['company_doc_1']);

            $model->fill($validData);

            $model->company_confirm_status = 2;
            $model->type = 2;
            $model->save();
            DB::commit();

            alert()->toast( 'با موفقیت انجام شد' , 'success' );
            return redirect()->back()->withInput();

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



    public function companyRegister_2()
    {
        $this->modelData = User::find(auth()->user()->id);
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.company_register_2' ,$data);

    }
    public function companyRegisterSubmit_2($request){

        $validData = $request->validate([
            'params.company_name'=> 'required',
            'params.economic_code'=> 'required',
            'company_doc_2'=> '',
        ]);

        try {
            DB::beginTransaction();
            $model = User::find(auth()->user()->id);

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            if ($request->company_doc_2){
                $params->company_doc_2 = $this->uploadFile($request , 'company_doc_2' , 'company_doc_2');
            }

            $model->params = json_encode($params);
            unset($validData['params']);
            unset($validData['company_doc_2']);

            $model->fill($validData);

            $model->company_confirm_status = 2;
            $model->type = 3;
            $model->save();
            DB::commit();

            alert()->toast( 'با موفقیت انجام شد' , 'success' );
            return redirect()->back()->withInput();

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



}
