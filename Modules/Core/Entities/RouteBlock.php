<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteBlock extends Model
{
    use HasFactory;

    protected $fillable = ['route_name','title','params'];

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\RouteBlockFactory::new();
    }

    public function blocks()
    {
        return $this->hasMany(RouteBlockItem::class , 'route_block_id' )->orderBy('sort');
    }
}
