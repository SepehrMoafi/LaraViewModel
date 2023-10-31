<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    protected $fillable = ['title' ,'src','type' ,'position' ,'sort', 'params'];

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }
}
