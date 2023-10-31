<?php

namespace Modules\Core\ViewModels\Admin\Comment;

use Exception;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Post;
use Modules\Core\Entities\Comment;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\ProductCatalog;

class CommentIndexViewModel extends BaseViewModel
{
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $source = $this->checkSourceType();
        $query = Comment::query()->where('commentable_type', $source);
        $this->rows = $query->paginate(40);
        return $this;
    }

    public function setColumns()
    {

        $this->addColumn([
            'name' => 'user_name',
            'title' => 'نویسنده',
        ]);

        $this->addColumn([
            'name' => 'content',
            'title' => 'متن',
        ]);
        $this->addColumn([
            'name' => 'approve',
            'title' => 'وضعیت',
        ]);

        /*** actions ***/
        $this->addAction([
            'name' => 'approve',
            'title' => 'تغییر وضعیت',
            'url' => array(
                'name' => 'admin.core.comments.approve',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class' => 'btn-warning',
        ]);

        $this->addAction([
            'name' => 'remove',
            'title' => 'حذف',
            'url' => array(
                'name' => 'admin.core.comments.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class' => 'btn-danger',
        ]);
        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->approve = $row->approve === 1 ? 'تایید' : 'در انتظار تایید';
        $row->user_name = $row->user->name ?? '-';

        return $row;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function checkSourceType(): string
    {
        $url = request()->url();
        $segment = Str::afterLast($url, '/');
        return match ($segment) {
            'index-product' => ProductCatalog::class,
            'index-post' => Post::class,
        };
    }

}
