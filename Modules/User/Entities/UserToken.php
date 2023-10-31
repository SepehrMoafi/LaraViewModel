<?php

namespace Modules\User\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserToken extends Model
{

    protected $fillable = ['user_id', 'token','type','expire_at','status'];

    public static function schema()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('token');
            $table->tinyInteger('type')->default(0)->comment('0 => mobile number , 1 => email')->default(0);
            $table->dateTime('expire_at')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1 = ok , 0 = not ok , 2 = used');
            $table->timestamps();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
