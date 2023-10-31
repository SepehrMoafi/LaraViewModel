<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\UserGift;
use Modules\User\Entities\Address;
use Modules\User\Entities\UserCopan;
use Modules\User\Entities\UserToken;
use Modules\User\Entities\Wallet;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'national_code',
        'permission_level',
        'params',
        'avatar',
        'type',
        'password',
        'company_confirm_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getParamsJsonAttribute(){
        return $this->params ? json_decode($this->params) : new \stdClass();
    }

    public function isAdmin(){
        if ($this->permission_level == 15){
            return true;
        }
        return false;
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function userCopan(): HasMany
    {
        return $this->hasMany(UserCopan::class, 'user_id');
    }

    public function userGift($giftId): HasMany
    {
        return $this->hasMany(UserGift::class, 'user_id')->where('gift_id',$giftId);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
