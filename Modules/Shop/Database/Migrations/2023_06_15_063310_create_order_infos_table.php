<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->on('orders')->references('id');

            $table->unsignedBigInteger('send_type')->nullable();

            $table->string('send_date')->nullable();

            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->on('addresses')->references('id');

            $table->softDeletes();
            $table->json('params')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_infos');
    }
};
