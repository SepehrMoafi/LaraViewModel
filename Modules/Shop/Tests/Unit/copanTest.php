<?php

namespace Modules\Shop\Tests\Unit;

use http\Client\Curl\User;
use Modules\Shop\Entities\Copan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class copanTest extends TestCase
{
    use WithFaker;

    public function testStore()
    {
        $this->actingAs(\App\Models\User::findOrFail(2));

        $data = [
            'code' => 'COUPON123',
            'amount' => 12,
            'status' => 0,
            'allowed_number_of_uses' => 100,
            'start_date' => '2023-06-17',
            'end_date' => '2023-06-30',
            'first_buy' => false,
        ];

        $response = $this->post(route('admin.shop.copan.store'), $data);
        $this->assertDatabaseHas('copans',$data);
        $response->assertStatus(302);
    }

    public function testUpdate()
    {
        $this->actingAs(\App\Models\User::findOrFail(2));

        // Create a coupon in the database
        $coupon = Copan ::create([
            'code' => 'COUPON123',
            'amount' => 12,
            'status' => 0,
            'allowed_number_of_uses' => 100,
            'start_date' => '2023-06-17',
            'end_date' => '2023-06-30',
            'first_buy' => false,
            'user_id' => 2,
        ]);

        // Update the coupon data
        $updatedData = [
            'code' => 'UPDATEDCOUPON',
            'amount' => 15,
            'status' => 1,
            'allowed_number_of_uses' => 200,
            'start_date' => '2023-06-18',
            'end_date' => '2023-07-01',
            'first_buy' => true,
            'user_id' => 2,
        ];
        $response = $this->put(route('admin.shop.copan.update', ['id' => $coupon->id]), $updatedData);
        $this->assertDatabaseHas('copans', $updatedData);
        $response->assertStatus(302);
    }

    public function testDelete()
    {
        $this->actingAs(\App\Models\User::findOrFail(2));

        $coupon = Copan::create([
            'code' => 'TRYTODELETE',
            'amount' => 15,
            'status' => 1,
            'allowed_number_of_uses' => 200,
            'start_date' => '2023-06-18',
            'end_date' => '2023-07-01',
            'first_buy' => true,
            'user_id' => 1,
        ]);

        $response = $this->delete(route('admin.shop.copan.destroy', ['id' => $coupon->id]));
        $this->assertSoftDeleted('copans', $coupon->toArray());
        $response->assertStatus(302);
    }


}
