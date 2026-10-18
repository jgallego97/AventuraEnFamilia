<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->restrictOnDelete();
            $table->unsignedDecimal('amount', 8, 2);
            $table->enum('method', ['card', 'paypal', 'bank_transfer']);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])
                ->default('pending');
            $table->string('reference')->unique();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
