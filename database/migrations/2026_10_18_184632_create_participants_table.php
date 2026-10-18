<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('national_id', 9)->nullable();
            $table->timestamps();

            $table->unique(['booking_id', 'national_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
