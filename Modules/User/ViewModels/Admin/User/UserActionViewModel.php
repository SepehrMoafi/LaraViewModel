<?php

namespace Modules\User\ViewModels\Admin\User;

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
use Modules\User\Entities\WalletTransaction;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class UserActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new User();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('blog::postCategory.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'mobile'=> 'required',
            'email'=> 'required',
            'permission_level'=> 'required',
            'params.company_name'=> '',
            'params.economic_code'=> '',
            'params.national_id'=> '',
        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {

        $this->modelData = User::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::user.form' ,$data);
    }

    public function showWallet($request)
    {


        $this->modelData = User::find( $request->model_id );
        $transactions = WalletTransaction::where('user_id' , $request->model_id )->get();
        $data = [
            'transactions' =>$transactions,
            'view_model' => $this,
        ];
        return $this->renderView('user::user.wallet' ,$data);
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
            $model = User::find( $request->model_id ) ?? new User();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
            unset($validData['params']);

            $model->fill($validData);
            if ($request->avatar){
                $model->avatar = $this->uploadFile($request , 'avatar' , 'users');
            }
            $model->save();

            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect(route('admin.user.users.index'));

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

    public function getAuthorsList()
    {
        $users = User::query()->get();
        return $users ;
    }
    public function getCategoriesList()
    {
        $categories = PostCategory::query()->get();
        return $categories;
    }

    public function getTagsList()
    {
        $tags = PostTag::query()->get();
        return $tags;
    }

    public function getPostList()
    {
        $posts = Post::query()->get();
        return $posts;
    }

}
