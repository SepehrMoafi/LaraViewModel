<?php

namespace Modules\Blog\ViewModels\Admin\Post;

use Modules\Blog\Entities\Post;
use Modules\Core\ViewModels\BaseViewModel;

class storeImageMediaViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function store($request)
    {
        $article = new Post();
        $article->id = 0;
        $article->exists = true;
        $image = $article->addMediaFromRequest('upload')->toMediaCollection('images');

        return response()->json([
            'url' => $image->getUrl('thumb')
        ]);

    }

}
