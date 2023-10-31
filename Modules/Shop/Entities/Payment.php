<?php

namespace Modules\Shop\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->latest();
        });
    }

    protected $fillable = [];
    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function getStatusTextBadageAttribute()
    {
        if ( $this->status == 0 ){
            if ($this->type == 'online' ){
                $status = 'ناموفق';
                $color = 'danger';
            }else{
                $status = 'در انتظار برسی';
                $color = 'warning';
            }
        }elseif( $this->status == 1 ){
            $status = 'موفق';
            $color = 'success';
        }else{
            $status = 'رد شده';
            $color = 'danger';
        }
        $text = '<div class="badge badge-'.$color.'">'. $status .'</div>';
        return $text;
    }

    public function getTypeTextAttribute()
    {
        if ( $this->type == 'bank_receipt' ){
            $text = 'فیش بانکی';
        }elseif( $this->type == 'online' ){
            $text = 'پرداخت آنلاین';
        }
        elseif( $this->type == 'wallet' ){
            $text = 'پرداخت با کیف پول';
        }
        return $text;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
