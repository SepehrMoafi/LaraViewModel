<?php
namespace Modules\User\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class NewsletterSubscriptionTest extends TestCase
{
    use WithFaker;
    public string $mobileNumber = '+989128934392';

    /** @test */
    public function it_can_store_a_newsletter_subscription_with_email()
    {
        $email = $this->faker->safeEmail;

        $response = $this->post(route('front.user.newsletter-subscriptions.store'), [
            'email' => $email,
            'mobile_number' => null,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => $email,
            'mobile_number' => null,
            'is_subscribed' => true,
        ]);
    }

    /** @test */
    public function it_can_store_a_newsletter_subscription_with_mobile_number()
    {

        $response = $this->post(route('front.user.newsletter-subscriptions.store'), [
            'email' => null,
            'mobile_number' => $this->mobileNumber,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => null,
            'mobile_number' => $this->mobileNumber,
            'is_subscribed' => true,
        ]);
    }

    /** @test */
    public function it_can_store_a_newsletter_subscription_with_email_and_mobile_number()
    {
        $email = $this->faker->safeEmail;
        $mobileNumber = '09198950549';
        $response = $this->post(route('front.user.newsletter-subscriptions.store'), [
            'email' => $email,
            'mobile_number' => $mobileNumber,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => $email,
            'mobile_number' => $mobileNumber,
            'is_subscribed' => true,
        ]);
    }

    /** @test */
    public function it_cant_store_a_newsletter_subscription_with_empty_email_and_mobile_number()
    {
        $response = $this->post(route('front.user.newsletter-subscriptions.store'), []);

        $response->assertStatus(302);

    }
}

