<?php

namespace Modules\Core\ViewModels\Admin\Errors;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Menu;
use Modules\Core\Entities\Slider;
use Modules\Core\Service\Export\MasterExport;
use Modules\Core\Service\Export\MasterImport;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class ErrorsViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function resolve()
    {
        dd('to do !!');
    }
}
