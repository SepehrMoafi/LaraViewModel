<?php

namespace Modules\Blog\Entities;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Modules\Core\Entities\Image;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model
{
    use HasFactory,Sluggable,HasSEO;


    protected $fillable = [
        'title' ,
        'slug' ,
        'body',
        'description',
        'params.meta_tag',
        'params.meta_key',
        'author_id',
        'post_date',
    ];

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->body,
            author: $this->author()->name,
            url: url()->current(),
            tags: $this->params,
            robots: 'index',
        );
    }

    /**
     * Get the post's image.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function images(): MorphOneOrMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function categories()
    {
        return $this->hasMany(PostCategoryRelation::class );
    }
    public function tags()
    {
        return $this->hasMany(PostTagRelation::class );
    }

    public function postsRelated()
    {
        return $this->hasMany(PostRelation::class  , 'parent_post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class ,'author_id' );
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(630)->height(440);
    }

}
