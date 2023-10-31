<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public static function schema()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
