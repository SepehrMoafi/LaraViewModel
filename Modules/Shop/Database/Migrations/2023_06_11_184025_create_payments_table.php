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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->on('orders')->references('id');

            $table->bigInteger('amount')->default(0);

            $table->string('type');

            $table->string('bank')->nullable();

            $table->string('reference_id')->unique();

            $table->integer('status')->default(0);

            $table->dateTime('paid_date')->nullable();

            $table->string('transaction_type')->default('debtor');

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
        Schema::dropIfExists('payments');
    }
};
