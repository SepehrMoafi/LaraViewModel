<?php

namespace Modules\Shop\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Entities\UserCopan;
use Modules\User\Entities\UserToken;

class Order extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->latest();
        });
    }

    protected $fillable = [];

    const STATUS = [
        '0' => 'درانتظار پرداخت',
        '1' => 'درحال آماده سازی',
        '2' => 'ارسال شده',
        '3' => 'تحویل شده',
    ];

    public function getStatusTextBadageAttribute()
    {
        switch ($this->status){
            case '0':
                return '<div class="badge badge-danger"> درانتظار پرداخت </div>';
                break;

            case '1':
                return '<div class="badge badge-warning"> درحال آماده سازی </div>';
                break;

            case '2':
                return '<div class="badge badge-info"> ارسال شده </div>';
                break;

            case '3':
                return '<div class="badge badge-success"> تحویل شده </div>';
                break;

            default:
                return '';
                break;

        }
    }
    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function order_info()
    {
        return $this->hasOne(OrderInfo::class);
    }

    public function userCopan(): HasMany
    {
        return $this->hasMany(UserCopan::class, 'order_id');
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()->where('status',1)->sum('amount');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
