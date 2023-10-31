<?php

namespace Modules\Blog\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PostCategory extends Model
{
    use HasFactory,HasSEO;
    protected $fillable = ['title','description','params','parent_id','type','image','user_id'];

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->description,
            author: $this->user()->name,
            url: url()->current(),
            tags: $this->params,
            robots: 'index',
        );
    }
    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostCategoryFactory::new();
    }

    public function parent(){
        return $this->belongsTo(PostCategory::class , 'parent_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class );
    }

    public function childs()
    {
        return $this->hasMany(PostCategory::class , 'parent_id' , 'id');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category_relations','category_id');
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }
}
