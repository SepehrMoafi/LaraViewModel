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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');

            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->on('payments')->references('id');

            $table->unsignedBigInteger('wallet_id')->nullable();
            $table->foreign('wallet_id')->on('wallets')->references('id');


            $table->bigInteger('amount')->default(0);
            $table->string('transaction_type')->default('debtor');

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
        Schema::dropIfExists('wallet_transactions');
    }
};
