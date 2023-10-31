<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValueProduct extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function value()
    {
        return $this->belongsTo(AttributeValue::class , 'value_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class , 'attribute_id');
    }


}
