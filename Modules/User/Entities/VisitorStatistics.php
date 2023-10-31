<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VisitorStatistics extends Model
{
    protected $table = 'visitor_statistics';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'visit_date',
        'destination_link',
    ];

    public static function schema()
    {
        Schema::create('visitor_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('visit_date')->nullable();
            $table->string('destination_link')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('route_name')->nullable();
            $table->string('route_value')->nullable();
            $table->timestamps();
        });
    }
}
