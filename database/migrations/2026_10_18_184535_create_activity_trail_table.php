<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_trail', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->foreignId('trail_id')->constrained('trails')->restrictOnDelete();
            $table->unsignedTinyInteger('position');
            $table->enum('type', ['main', 'optional', 'alternative'])->default('main');
            $table->enum('pace', ['relaxed', 'moderate', 'intense'])->default('moderate');

            $table->primary(['activity_id', 'trail_id']);
            $table->unique(['activity_id', 'position']);
            $table->index('trail_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_trail');
    }
};
