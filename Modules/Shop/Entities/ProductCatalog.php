<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Core\Entities\Comment;
use Modules\Core\Entities\Image;
use Modules\User\Entities\UserFavorite;
use Modules\User\Entities\VisitorStatistics;
use Modules\User\Entities\UserNotifyItem;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ProductCatalog extends Model
{
    use HasFactory,HasSEO;

    protected $fillable = [
        'title',
        'en_title',
        '2nd_title',
        'description',
        'product_attribute',
        'type',
        'brand_id',
        'is_active',
        'is_special',
        'is_coming_soon',
        'out_of_sell',
        'image',
        'params',
    ];
    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->description,
            image: $this->image,
            url: url()->current(),
            tags: $this->params,
            robots: 'index',
        );
    }

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductCatalogFactory::new();
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function getPriceBoxAttribute(){
        if ($this->activeProducts->count() > 0 ){

            $firstActiveProduct = $this->firstActiveProduct;

            if ($firstActiveProduct->discount > 0){
                $price = '<p class="text-gray-300 text-center line-through font-medium text-sm lg:mb-2">'.number_format($firstActiveProduct->price).' تومان</p>'.
                    '<p class="text-red-600 font-semibold text-center text-xl">'.number_format( ($firstActiveProduct->price)*(1-($firstActiveProduct->discount/100)) ).' تومان</p>';

            }else{
                $price = '<p class="text-blue-400 font-semibold text-base mb-2">'.number_format($firstActiveProduct->price) .' تومان</p>';
            }

            return $price;
        }else{
            if ($this->is_coming_soon ){
                return ' <p class="text-blue-400 font-semibold text-base mb-2">بزودی</p>';

            }else if ($this->out_of_sell){
                return ' <p class="text-blue-400 font-semibold text-base mb-2">توقف فروش</p>';

            }else{
                return ' <p class="text-blue-400 font-semibold text-base mb-2">ناموجود</p>';

            }
        }

    }

    public function getFirstActiveProductAttribute()
    {
        return $this->activeProducts->first() ;
    }

    public function categories()
    {
        return $this->hasMany(ProductCatalogCategoryRel::class );
    }

    public function products()
    {
        return $this->hasMany(Product::class );
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class )->where('qty' , '>', 0)
            ->where('price' , '>', 0)
            ->whereHas('catalog' , function ($q){
                $q->where('is_active' , 1)
                    ->where('is_coming_soon' , 0)
                    ->where('out_of_sell' , 0);
            });
    }

    public function images(): MorphOneOrMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function relProductAccessory()
    {
        return $this->hasMany(ProductCatalogRelAccessory::class  , 'parent_product_catalog_id');
    }

    public function relProduct()
    {
        return $this->hasMany(ProductCatalogRel::class  , 'parent_product_catalog_id');
    }

    public function attributes()
    {
        return $this->hasMany(AttributeValueProduct::class  , 'product_catalogs_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class , 'brand_id','id');
    }

    public function getIsUserFavAttribute()
    {
        if ( ! auth()->user()){
            return false;
        }
        $fav_obj = UserFavorite::where('user_id' , auth()->user()->id)
            ->where('favable_id' , $this->id )
            ->where('favable_type' , ProductCatalog::class)->first();
        if ($fav_obj){
            return true;
        }
        return false ;
    }

    public function getIsUserNotifyAttribute()
    {
        if ( ! auth()->user()){
            return false;
        }
        $item_obj = UserNotifyItem::where('user_id' , auth()->user()->id)
            ->where('item_id' , $this->id )
            ->where('item_type' , ProductCatalog::class)->first();
        if ($item_obj){
            return true;
        }
        return false ;
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }

    public function giftItems(): MorphMany
    {
        return $this->morphMany(GiftItem::class, 'itemable');
    }

    public function getClickCountAttribute()
    {
        return VisitorStatistics::query()->where([
            'route_name' => 'front.shop.product.show-product',
            'route_value->id' => $this->id,
        ])->count();
    }

}
