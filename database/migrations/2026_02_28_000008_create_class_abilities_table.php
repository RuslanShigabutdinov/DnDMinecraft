<?php

use App\Enums\ActionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_abilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('character_classes')->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->smallInteger('action_type')->default(ActionType::Passive->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_abilities');
    }
};
