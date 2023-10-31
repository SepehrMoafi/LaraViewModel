<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $fillable = [];

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getHasLuckyWheelAttribute()
    {

    }

    public function product()
    {
        return $this->item()->first();

    }

    public function getItemObjAttribute(){
        $obj = new $this->item_type;
        return $obj->find( $this->item_id );
    }

}
