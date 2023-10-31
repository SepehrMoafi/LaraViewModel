<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCatalogRelAccessory extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductCatalogRelAccessoryFactory::new();
    }
    public function product()
    {
        return $this->belongsTo(ProductCatalog::class , 'product_catalog_id' , 'id');
    }
}
