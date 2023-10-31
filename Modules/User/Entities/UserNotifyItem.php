<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotifyItem extends Model
{
    protected $fillable = [];

    public function item()
    {
        return $this->morphTo();
    }
}
