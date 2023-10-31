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
        Schema::create('product_catalogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('en_title')->nullable();
            $table->string('2nd_title')->nullable();
            $table->text('description')->nullable();
            $table->text('product_attribute')->nullable();

            $table->unsignedBigInteger('brand_id')->nullable();

            $table->integer('type');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_special')->default(0);
            $table->boolean('is_coming_soon')->default(0);
            $table->boolean('out_of_sell')->default(0);

            $table->text('image')->nullable();

            $table->json('params')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('product_catalogs');
    }
};
