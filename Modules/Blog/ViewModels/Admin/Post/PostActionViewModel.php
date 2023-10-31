<?php

namespace Modules\Blog\ViewModels\Admin\Post;

use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\PostRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class PostActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Post();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('blog::post.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body'=> 'required',
            'description'=> 'required',
            'params.meta_tag'=> 'required',
            'params.meta_key'=> 'required',
            'author_id'=> 'required',
            'post_date'=> 'required',
        ]);

        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {

        $this->modelData = Post::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('blog::post.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function saveService( $validData ,  $request)
    {
        try {
            DB::beginTransaction();
            $model = Post::find( $request->model_id ) ?? new Post();

            $params = $model->params ? json_decode($model->params) : new \stdClass();
            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
            unset($validData['params']);

            $model->fill($validData);

            if ($request->image){
                $model->image = $this->uploadFile($request , 'image' , 'post');
            }
            $date = request('post_date');
            $date = Jalalian::fromFormat('Y-m-d',$date)->toCarbon()->format('Y-m-d');
            $model->post_date =$date;

            $model->type = 1;
            $model->status = request('publish') == 'on' ? 1 : 2;

            $model->slug = null;
            if ($request->slug){
                $model->slug = SlugService::createSlug(Post::class, 'slug', $request->slug);

            }

            $model->save();

            // category
            $old_cats = PostCategoryRelation::where('post_id' ,$model->id )->delete();
            if ($request['categories'] && count($request['categories'] ) > 0 ){
                foreach ($request['categories'] as $category) {

                    $post_cat = new PostCategoryRelation();
                    $post_cat->post_id = $model->id;
                    $post_cat->category_id = $category;
                    $post_cat->save();

                }
            }

            // tags
            $old_tags = PostTagRelation::where('post_id' ,$model->id )->delete();
            if ( $request['tags'] && count($request['tags'] ) > 0 ){
                foreach ($request['tags'] as $tag) {
                    $tag_object = PostTag::where('title' ,$tag )->first() ?? new PostTag();
                    if (! $tag_object->id){
                        //todo slug
                        $tag_object->title = $tag;
                        $tag_object->slug = $tag;
                        $tag_object->save();
                    }

                    $post_tag = new PostTagRelation();
                    $post_tag->post_id = $model->id;
                    $post_tag->tag_id = $tag_object->id;
                    $post_tag->save();
                }
            }

            // rel_posts
            $old_rel_posts = postRelation::where('parent_post_id' ,$model->id )->delete();
            if ($request['rel_posts'] && count($request['rel_posts'] ) > 0 ){
                foreach ($request['rel_posts'] as $rel_posts) {
                    $post_rel = new postRelation();
                    $post_rel->parent_post_id = $model->id;
                    $post_rel->post_id = $rel_posts;
                    $post_rel->save();

                }
            }



            if ( $request->file('images') ){
                foreach ($request->file('images') as $image ){
                    DropZoneController::SaveImage($image, 'blogs', Post::class , $model->id , 'post' , $model->title );
                }
            }

            DB::commit();
            alert()->success('با موفقیت انجام شد');

            return redirect(route('admin.blog.posts.index'));

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

    public function destroy($request)
    {

        try {

            DB::beginTransaction();
            $model = Post::find( $request->model_id );
            $cats = PostCategoryRelation::where('post_id' , $request->model_id)->delete();
            $model->delete();
            alert()->success('با موفقیت انجام شد');
            DB::commit();
            return redirect(route('admin.blog.posts.index'));

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
