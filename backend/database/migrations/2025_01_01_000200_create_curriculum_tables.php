<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. "primary"
            $table->string('name');
            $table->string('name_en');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('stages')->cascadeOnDelete();
            $table->string('code')->unique(); // e.g. "primary-6"
            $table->string('name');
            $table->string('name_en');
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->string('code')->unique(); // e.g. "p6-math"
            $table->string('name');
            $table->string('name_en');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('code'); // e.g. "numbers-operations" (unique per subject)
            $table->string('name');
            $table->string('name_en');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['subject_id', 'code']);
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->string('code'); // e.g. "lesson-1" (unique per unit)
            $table->string('title');
            $table->string('title_en');
            $table->string('duration')->nullable();
            $table->enum('type', ['video', 'interactive', 'quiz']);
            $table->timestamps();

            // Ensure the same code is unique only within a unit
            $table->unique(['unit_id', 'code']);
        });

        Schema::create('lesson_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->string('title');
            $table->string('title_en');
            $table->json('objectives')->nullable();
            $table->json('key_points')->nullable();
            $table->json('sections')->nullable();
            $table->json('quick_quiz')->nullable();
            $table->string('prev_lesson_id')->nullable();
            $table->string('next_lesson_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_contents');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('units');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('stages');
    }
};
