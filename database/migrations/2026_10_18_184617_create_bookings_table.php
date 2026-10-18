<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('departure_id')->constrained('departures')->restrictOnDelete();
            $table->unsignedSmallInteger('seats');
            $table->unsignedDecimal('total_price', 8, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'rejected'])
                ->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['departure_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
