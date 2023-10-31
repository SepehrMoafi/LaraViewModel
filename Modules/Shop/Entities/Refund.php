<?php

namespace Modules\Shop\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Refund extends Model
{
    protected $fillable = [
        'user_id',
        'order_item_id',
        'status',
        'amount',
        'reason',
        'refund_method',
        'approved',
        'refund_date',
        'notes',
        'qty',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $status = $this->attributes['status'];
        $statusLabels = [
            0 => 'در انتظار تایید',
            1 => 'تایید شده',
            2 => 'رد شد',
        ];
        if (array_key_exists($status, $statusLabels)) {
            return $statusLabels[$status];
        }
        return 'ناشناخته';
    }

    public function getApproveLabelAttribute(): string
    {
        $status = $this->approved;
        $statusLabels = [
            0 => 'در انتظار تایید',
            1 => 'پرداخت شده',
            2 => 'رد شد',
        ];
        if (array_key_exists($status, $statusLabels)) {
            return $statusLabels[$status];
        }
        return 'ناشناخته';
    }

    public static function schema()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('order_item_id')->constrained('order_items');
            $table->tinyInteger('status')->default(0);
            $table->integer('qty');
            $table->integer('amount');
            $table->text('reason')->nullable();
            $table->string('refund_method')->nullable();
            $table->boolean('approved')->default(0);
            $table->timestamp('refund_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
}
