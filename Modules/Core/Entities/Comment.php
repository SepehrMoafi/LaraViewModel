<?php

namespace Modules\Core\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Entities\Wallet;
use Modules\User\ViewModels\Front\Wallet\WalletViewModel;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content', 'commentable_id', 'commentable_type', 'parent_id','approve','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public static function schema()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->morphs('commentable');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->boolean('approve')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->references('id')->on('comments')->cascadeOnDelete();
        });
    }

}
