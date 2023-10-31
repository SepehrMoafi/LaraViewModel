<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Core\Database\factories\ImageFactory::new();
    }


    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

}
