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
        Schema::create('attribute_value_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_catalogs_id');
            $table->foreign('product_catalogs_id')->on('product_catalogs')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->on('attributes')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id')->on('attribute_values')->references('id')->onDelete('cascade');

            $table->bigInteger('additional_price')->nullable();

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
        Schema::dropIfExists('attribute_value_products');
    }
};
