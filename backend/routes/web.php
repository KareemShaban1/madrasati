<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\StageController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\LessonContentController;
use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AttachmentController;

Route::get('/', function () {
    return view('welcome');
});

// Admin auth (auth middleware redirects to route('login'), so we define it)
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::middleware(['auth', 'can:isAdmin', 'admin.locale'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/locale/{locale}', function (string $locale) {
        if (in_array($locale, ['en', 'ar'], true)) {
            session(['admin_locale' => $locale]);
        }
        return redirect()->back();
    })->name('locale');

    Route::post('/theme', function (\Illuminate\Http\Request $request) {
        $theme = $request->input('theme');
        if (in_array($theme, ['light', 'dark'], true)) {
            session(['admin_theme' => $theme]);
        }
        return response('', 204);
    })->name('theme');

    // Redirect dashboard to stages as an entry point
    Route::get('/dashboard', function () {
        return redirect()->route('admin.stages.index');
    })->name('dashboard');

    Route::resource('stages', StageController::class)->except('show');
    Route::resource('grades', GradeController::class)->except('show');
    Route::resource('subjects', SubjectController::class)->except('show');
    Route::resource('units', UnitController::class)->except('show');
    Route::resource('lessons', LessonController::class)->except('show');
    Route::resource('lesson-contents', LessonContentController::class)->except('show');
    Route::resource('badges', BadgeController::class)->except('show');
    Route::resource('achievements', AchievementController::class)->except('show');
    Route::post('/attachments', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
});

