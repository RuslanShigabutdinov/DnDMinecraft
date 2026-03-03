<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feat_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feat_id')->constrained()->cascadeOnDelete();
            $table->morphs('modifiable');
            $table->smallInteger('value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feat_bonuses');
    }
};
