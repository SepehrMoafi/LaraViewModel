<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class NewsletterSubscription extends Model
{
    use Notifiable;
    protected $table = 'newsletter_subscriptions';
    protected $fillable = [
        'email',
        'mobile_number',
        'is_subscribed',
    ];

    public static function schema()
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_number')->unique()->nullable();
            $table->boolean('is_subscribed')->default(true);
            $table->timestamps();
        });
    }

    public static function validationRules(): array
    {
        return [
            'email' => [
                'nullable',
                'email',
                Rule::requiredIf(function () {
                    return empty(request('mobile_number'));
                }),
                Rule::unique('newsletter_subscriptions', 'email'),
            ],
            'mobile_number' => [
                'nullable',
                'numeric',
                Rule::requiredIf(function () {
                    return empty(request('email'));
                }),
                Rule::unique('newsletter_subscriptions', 'mobile_number'),
            ],
            'is_subscribed' => ['boolean'],
        ];
    }
}
