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
        Schema::create('product_rel_accessories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_product_id');
            //$table->foreign('parent_product_id')->on('products')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            //$table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('product_rel_accessories');
    }
};
