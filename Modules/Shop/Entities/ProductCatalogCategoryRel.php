<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCatalogCategoryRel extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductCatalogCategoryRelFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(ProductCatalogCategory::class , 'category_id' , 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductCatalog::class , 'product_catalog_id' , 'id');
    }
}
