<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Entities\ProductCatalogCategory;

class Menu extends Model
{
    protected $fillable = ['title', 'sort' , 'parent_id' , 'link'];

    public function parent()
    {
        return $this->belongsTo(Menu::class , 'parent_id' , 'id');
    }

    public function childs()
    {
        return $this->hasMany(Menu::class , 'parent_id' , 'id');
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

}
