<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFavorite extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function favable()
    {
        return $this->morphTo();
    }
}
