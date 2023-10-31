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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->nullable();
            $table->bigInteger('goodsCode')->nullable();
            $table->integer('typeCode')->nullable();
            $table->integer('tafsiliID')->nullable();
            $table->json('good_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('good_id');
            $table->dropColumn('goodsCode');
            $table->dropColumn('typeCode');
            $table->dropColumn('tafsiliID');
            $table->dropColumn('good_info');
        });

    }
};
