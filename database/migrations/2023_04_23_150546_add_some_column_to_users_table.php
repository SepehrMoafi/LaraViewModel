<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->nullable();
            $table->string('national_code')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('permission_level')->default(1);
            $table->integer('type')->default(1);
            $table->json('params')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn( [ 'mobile','national_code','avatar','permission_level','type','params' ] );
        });
    }

};
