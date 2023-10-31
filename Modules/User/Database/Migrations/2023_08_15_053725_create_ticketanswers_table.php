<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\Entities\TicketAnswer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        TicketAnswer::schema();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticketanswers');
    }
};
