<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteBlockItem extends Model
{
    use HasFactory;

    protected $fillable = ['sort'];

    public function getConfigJsonAttribute(){
        return $this->config ? json_decode($this->config) : new \stdClass();
    }

}
