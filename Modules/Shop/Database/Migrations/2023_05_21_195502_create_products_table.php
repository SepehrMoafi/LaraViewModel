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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_catalog_id');
            $table->foreign('product_catalog_id')->on('product_catalogs')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('product_code');

            $table->bigInteger('price')->default(0);

            $table->integer('discount')->default(0);

            $table->bigInteger('qty')->default(0);

            $table->string('color')->nullable();

            $table->string('warranty')->nullable();

            $table->integer('wight')->default(0);

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
        Schema::dropIfExists('products');
    }
};
