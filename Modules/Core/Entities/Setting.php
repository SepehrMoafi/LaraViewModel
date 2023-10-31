<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    protected $fillable = ['code' , 'main_setting' , 'about_us_setting' , 'contact_setting' , 'other_setting' ];

    public function getMainSettingJsonAttribute(){
        return $this->main_setting ? json_decode($this->main_setting) : new \stdClass();
    }
}
