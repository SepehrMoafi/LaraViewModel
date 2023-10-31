<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GiftItem extends Model
{
    protected $fillable = ['itemable_type', 'itemable_id', 'gift_id'];

    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public static function schema()
    {
        Schema::create('gift_items', function (Blueprint $table) {
            $table->id();
            $table->morphs('itemable');
            $table->foreignId('gift_id')->constrained();
            $table->timestamps();
        });
    }
}
