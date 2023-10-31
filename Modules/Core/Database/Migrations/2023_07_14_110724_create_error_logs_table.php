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

        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('errorable');
            $table->string('description')->nullable();
            $table->string('reason')->nullable();

            $table->string('resolve_class')->nullable();
            $table->string('resolve_method')->nullable();

            $table->dateTime('resolved_at')->nullable();

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
        Schema::dropIfExists('error_logs');
    }
};
