<?php

namespace Modules\Core\ViewModels\Admin\Comment;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Blog\Entities\Post;
use Modules\Core\Entities\Comment;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\ProductCatalog;

class CommentStoreViewModel extends BaseViewModel
{
    public function store()
    {
        try {
            DB::beginTransaction();
            $sourceClass = $this->checkModelType();
            $comment = new Comment();
            $validated = request()->merge(['user_id' => 2,
                'approve' => false,
                'commentable_type' => $sourceClass,
                'commentable_id' => request()->id])->validate([
                'user_id' => 'required|exists:users,id',
                'commentable_id' => 'required|numeric',
                'commentable_type' => 'required|string',
                'parent_id' => 'nullable|exists:comments,id',
                'content' => 'required|string',
            ]);
            $comment->fill($validated);

            $comment->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            alert()->toast( 'مشکلی در ذخیره سازی به وجود آمد' , 'error' );
            return redirect()->back();
        }
        DB::commit();
        alert()->toast( 'با موفقیت انجام شد' , 'success' );
        return redirect()->back();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function checkModelType(): string
    {
        $source = request()->source;

        return match ($source) {
            'ProductCatalog' => ProductCatalog::class,
            'Post' => Post::class,
            default => throw new Exception("کاربر " . auth()->user()->id . " سعی به عوض کردن تگ ها داشته"),
        };
    }
}
