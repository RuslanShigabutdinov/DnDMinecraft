<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('character_classes');
            $table->foreignId('alignment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('background')->nullable();
            $table->string('gender')->nullable();
            $table->smallInteger('age')->nullable();
            $table->smallInteger('height_cm')->nullable();
            $table->integer('weight_g')->nullable();
            $table->string('size')->default('Medium');
            $table->smallInteger('current_hp')->default(0);
            $table->smallInteger('temporary_hp')->default(0);
            $table->smallInteger('sanity_meter')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
