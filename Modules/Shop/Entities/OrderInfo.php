<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Address;

class OrderInfo extends Model
{
    protected $fillable = [];

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
