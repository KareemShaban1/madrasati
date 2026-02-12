<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\LeaderboardController;

// Public curriculum & lesson content (no auth) – for frontend to show dashboard/DB data
Route::get('public/curriculum', [CurriculumController::class, 'publicCurriculum']);
Route::get('public/lesson-content', [CurriculumController::class, 'publicLessonContent']);

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::middleware('auth:api')->group(function () {
    // User profile & gamification
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::get('users/{id}/progress', [UserController::class, 'progress']);
    Route::get('users/{id}/badges', [UserController::class, 'badges']);
    Route::get('users/{id}/achievements', [UserController::class, 'achievements']);

    // Curriculum
    Route::get('stages', [CurriculumController::class, 'stages']);
    Route::get('stages/{id}', [CurriculumController::class, 'stage']);
    Route::get('stages/{id}/grades', [CurriculumController::class, 'stageGrades']);
    Route::get('grades/{id}', [CurriculumController::class, 'grade']);
    Route::get('grades/{id}/subjects', [CurriculumController::class, 'gradeSubjects']);
    Route::get('subjects/{id}', [CurriculumController::class, 'subject']);
    Route::get('subjects/{id}/units', [CurriculumController::class, 'subjectUnits']);
    Route::get('units/{id}', [CurriculumController::class, 'unit']);
    Route::get('units/{id}/lessons', [CurriculumController::class, 'unitLessons']);
    Route::get('lessons/{id}', [CurriculumController::class, 'lesson']);
    Route::get('lessons/{id}/content', [CurriculumController::class, 'lessonContent']);

    // Progress & gamification
    Route::post('progress/lesson', [ProgressController::class, 'completeLesson']);
    Route::post('progress/quiz', [ProgressController::class, 'submitQuiz']);
    Route::get('progress/streak', [ProgressController::class, 'streak']);
    Route::post('progress/streak/check', [ProgressController::class, 'checkStreak']);

    Route::get('leaderboard', [LeaderboardController::class, 'global']);
    Route::get('leaderboard/{gradeId}', [LeaderboardController::class, 'byGrade']);

    // Analytics
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('analytics/users', [AnalyticsController::class, 'users']);
        Route::get('analytics/lessons', [AnalyticsController::class, 'lessons']);
        Route::get('analytics/subjects', [AnalyticsController::class, 'subjects']);
    });
});

