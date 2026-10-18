<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedDecimal('distance_km', 6, 2);
            $table->unsignedSmallInteger('ascent_m');
            $table->unsignedSmallInteger('descent_m');
            $table->enum('difficulty', ['easy', 'moderate', 'hard'])->index();
            $table->foreignId('zone_id')->constrained('zones')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trails');
    }
};
