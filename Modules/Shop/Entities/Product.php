<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Product extends Model
{
    use HasSEO;
    protected $fillable = [
        'product_catalog_id',
        'product_code',
        'price',
        'discount',
        'qty',
        'color',
        'warranty',
        'wight',
    ];

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->catalog()->title,
            description: $this->catalog()->description,
            url: url()->current(),
            robots: 'index',
        );
    }

    public function catalog()
    {
        return $this->belongsTo(ProductCatalog::class , 'product_catalog_id' , 'id');
    }

    public function getPriceBoxAttribute(){
        //dd($this);
        if ($this->price && $this->qty > 0 ){
            if ($this->discount > 0){
                $price = '<p class="text-gray-300 text-center line-through font-medium text-sm lg:mb-2">'.number_format($this->price).' تومان</p>'.
                    '<p class="text-red-600 font-semibold text-center text-xl">'.number_format( ($this->price)*(1-($this->discount/100)) ).' تومان</p>';

            }else{
                $price = '<p class="text-blue-400 font-semibold text-base mb-2">'.number_format($this->price) .' تومان</p>';
            }
            return $price ;
        }else{
            return ' <p class="text-blue-400 font-semibold text-base mb-2">ناموجود</p>';
        }

    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function getGoodInfoJsonAttribute(){
        return $this->good_info ? json_decode($this->good_info) : new \stdClass();
    }

}
