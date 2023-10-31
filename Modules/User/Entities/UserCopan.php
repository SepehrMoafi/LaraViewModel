<?php

namespace Modules\User\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Shop\Entities\Copan;
use Modules\Shop\Entities\Order;

class UserCopan extends Model
{
    protected $fillable = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function copan(): BelongsTo
    {
        return $this->belongsTo(Copan::class);
    }

    public static function schema()
    {
        Schema::create('user_copans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('copan_id')->constrained('copans');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
