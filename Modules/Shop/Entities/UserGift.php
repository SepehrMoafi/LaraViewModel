<?php

namespace Modules\Shop\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UserGift extends Model
{
    protected $fillable = ['user_id', 'gift_id', 'gift_item_id'];
    protected $table = "user_gift";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gift(): BelongsTo
    {
        return $this->belongsTo(Gift::class);
    }

    public function giftItem(): BelongsTo
    {
        return $this->belongsTo(GiftItem::class);
    }

    public static function schema()
    {
        Schema::create('user_gift', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gift_id')->constrained();
            $table->foreignId('gift_item_id')->constrained('gift_items');
            $table->timestamps();
        });
    }
}
