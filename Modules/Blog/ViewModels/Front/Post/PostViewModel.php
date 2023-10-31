<?php

namespace Modules\Blog\ViewModels\Front\Post;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\City;
use Modules\Core\Entities\State;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\ProductCatalog;
use Modules\User\Entities\UserFavorite;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class PostViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        $posts = Post::query()->take(6)->where('status', 1)->orderByDesc('id')->get();
        $allPosts = Post::where('status',1)->orderByDesc('id')->get();
        $postCategories = PostCategory::whereNull('parent_id')->where('type', 1)->get();
        $tutorialCategories = PostCategory::where('title', 'آموزشی')->first();
        if ($tutorialCategories !== null) {
            $tutorialCategories = $tutorialCategories->posts()->take(6)->where('status', 1)->get();
        }
        $data = [
            'posts' => $posts,
            'allPosts' => $allPosts,
            'postCategories' => $postCategories,
            'tutorialCategories' => $tutorialCategories,
        ];
        return $this->renderView('blog::post.index', $data);
    }

    public function show($request)
    {
        $post = Post::where('slug', request()->route()->post)->where('status', 1)->firstOrFail();
        $instantNews = Post::query()->take(6)->where('status', 1)->orderByDesc('id')->get();

        $nextPost = Post::where('id', '>', $post->id)->where('status', 1)->orderBy('id')->first();
        $previousPost = Post::where('id', '<', $post->id)->where('status', 1)->orderByDesc('id')->first();

        $data = [
            'post' => $post,
            'instantNews' => $instantNews,
            'nextPost' => $nextPost,
            'previousPost' => $previousPost,
        ];
        return $this->renderView('blog::post.show',$data);
    }
}
