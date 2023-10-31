<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ProductCatalogCategory extends Model
{
    use HasFactory,HasSEO;

    protected $fillable = ['title','description','params','parent_id','type','image'];
    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->description,
            url: url()->current(),
            tags: $this->params,
            robots: 'index',
        );
    }
    public function parent()
    {
        return $this->belongsTo(ProductCatalogCategory::class , 'parent_id' , 'id');
    }

    public function childs()
    {
        return $this->hasMany(ProductCatalogCategory::class , 'parent_id' , 'id');
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }
}
