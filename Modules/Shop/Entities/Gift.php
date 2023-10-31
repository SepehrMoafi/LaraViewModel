<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Gift extends Model
{
    protected $fillable = ['product_catalog_id','title','active_date','expire_date','maximum_use'];

    public function items(): MorphMany
    {
        return $this->morphMany(GiftItem::class, 'itemable');
    }

    public function productCatalog(): BelongsTo
    {
        return $this->belongsTo(ProductCatalog::class);
    }

    public static function schema()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_catalog_id')->constrained('product_catalogs');
            $table->string('title');
            $table->date('active_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->integer('maximum_use')->default(1);
            $table->timestamps();
        });
    }
}
