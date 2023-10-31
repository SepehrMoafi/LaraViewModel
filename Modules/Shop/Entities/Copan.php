<?php

namespace Modules\Shop\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\Entities\UserCopan;

class Copan extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'amount', 'status', 'allowed_number_of_uses', 'start_date', 'end_date', 'first_buy', 'user_id'];

    public static function schema()
    {
        Schema::create('copans', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('amount');
//            $table->tinyInteger('amount_type')->default(0)->comment('0 => percentage, 1 => price unit');
//            $table->unsignedBigInteger('discount_ceiling')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('allowed_number_of_uses')->nullable();
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->useCurrent();
            $table->boolean('first_buy')->default(false);
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function userCopan(): HasMany
    {
        return $this->hasMany(UserCopan::class, 'copan_id');
    }

    public function giftItems(): MorphMany
    {
        return $this->morphMany(GiftItem::class, 'itemable');
    }
}
