<?php

namespace Modules\Core\ViewModels\Admin\Comment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Comment;
use Modules\Core\Entities\RouteBlock;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;

class CommentApproveViewModel extends BaseViewModel
{
    public function approve()
    {
        try {
            DB::beginTransaction();
            $comment = Comment::query()->findOrFail(request()->model_id);
            $comment->approve = !$comment->approve;
            $comment->save();
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
