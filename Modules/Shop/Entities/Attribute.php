<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'image' , 'params'];

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\AttributeFactory::new();
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class );
    }

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }


}
