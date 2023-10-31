<?php

namespace Modules\Shop\ViewModels\Admin\Copan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;

class CopanDestroyViewModel extends BaseViewModel
{
    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            Copan::query()->findOrFail(request()->model_id)->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical($exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت پاک شد');
        return redirect()->back();
    }
}
