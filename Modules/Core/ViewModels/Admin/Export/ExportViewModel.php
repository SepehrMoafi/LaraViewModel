<?php

namespace Modules\Core\ViewModels\Admin\Export;
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

class ExportViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function export()
    {
        $view_model = new (request('class'));
        $view_model->setGridData(true)->setColumns();
        ob_end_clean();
        ob_start();
        $export_rows = $view_model->rows->get();
        return Excel::download(new MasterExport($export_rows , $view_model), 'export-'.jdate()->format('y-m-d-h-i-s').'.xlsx');
    }

    public function import()
    {
        try {
            $view_model = new (request('class'));
            $view_model->setGridData(true)->setColumns();
            ob_end_clean();
            ob_start();
            $export_rows = $view_model->rows->get();

            if ( ! request()->file('file') ){
                alert()->error('مشکلی پیش آمد','فایل اکسل را وارد کنبد' );
                return redirect()->back()->withInput();
            }
            Excel::import(new MasterImport($export_rows , $view_model), request()->file('file') );

            toast('با موفقیت انجام شد','success' );
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
