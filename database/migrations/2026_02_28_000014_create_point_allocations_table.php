<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->morphs('allocatable');
            $table->smallInteger('amount');
            $table->timestamps();

            $table->unique(['character_id', 'allocatable_type', 'allocatable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_allocations');
    }
};
