<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;

class PostRelation extends Model
{

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostRelationFactory::new();
    }
}
