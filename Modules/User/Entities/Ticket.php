<?php

namespace Modules\User\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'status', 'department_id'];

    public static function schema()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['open','closed','read','unread','pending','answered'])->default('open');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function ticketAnswers(): HasMany
    {
        return $this->hasMany(TicketAnswer::class);
    }

    public function getTicketValueAttribute()
    {
        return match ($this->status) {
            'open' => 'باز',
            'closed' => 'بسته',
            'read' => 'خوانده شده',
            'unread' => 'خوانده نشده',
            'answered' => 'پاسخ داده شده',
            default => 'باز'
        };
    }
}
