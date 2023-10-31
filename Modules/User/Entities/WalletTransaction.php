<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Entities\Payment;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\WalletTransactionFactory::new();
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
