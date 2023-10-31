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
        Schema::create('route_block_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_block_id');
            $table->foreign('route_block_id')->on('route_blocks')->references('id');

            $table->unsignedBigInteger('block_id');
            $table->string('template')->nullable();
            $table->integer('sort')->default(1);
            $table->json('config')->nullable();
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
        Schema::dropIfExists('route_block_items');
    }
};
