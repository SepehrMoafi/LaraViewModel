<?php

namespace Modules\Core\ViewModels\Admin\Comment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Comment;
use Modules\Core\ViewModels\BaseViewModel;

class CommentDestroyViewModel extends BaseViewModel
{
    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            $comment = Comment::query()->findOrFail(request()->model_id);
            $comment->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical($exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return redirect()->back();
    }
}
