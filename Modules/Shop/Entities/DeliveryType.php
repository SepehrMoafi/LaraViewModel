<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cities_id',
        'status',
        'price',
        'params',
    ];
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\DeliveryTypeFactory::new();
    }

    public function catalog()
    {
        return $this->belongsTo(ProductCatalog::class , 'product_catalog_id' , 'id');
    }

}
