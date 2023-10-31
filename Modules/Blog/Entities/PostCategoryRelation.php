<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;

class PostCategoryRelation extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostCategoryRelationFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class , 'category_id' , 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class , 'post_id' , 'id');
    }
}
