<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('name_en');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->enum('category', ['learning', 'streak', 'mastery', 'special']);
            $table->enum('requirement_type', ['lessons_completed', 'quizzes_passed', 'streak_days', 'perfect_quizzes', 'subject_mastery']);
            $table->integer('requirement_value');
            $table->string('subject_id')->nullable();
            $table->timestamps();
        });

        Schema::create('achievements', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('max_progress');
            $table->integer('xp_reward');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('badges');
    }
};

