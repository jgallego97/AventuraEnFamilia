<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->restrictOnDelete();
            $table->foreignId('guide_id')->nullable()->constrained('guides')->restrictOnDelete();
            $table->dateTime('starts_at')->index();
            $table->unsignedDecimal('price', 8, 2);
            $table->unsignedSmallInteger('capacity');
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])
                ->default('open')
                ->index();
            $table->timestamps();

            $table->unique(['activity_id', 'starts_at']);
            $table->index(['guide_id', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departures');
    }
};
