<?php

namespace Modules\User\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Address extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'state',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function schema()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->text('address');
            $table->text('zip_code');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('state');
            $table->integer('city');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

