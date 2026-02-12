<?php

namespace App\Http\Controllers;

use App\Models\CompletedLesson;
use App\Models\QuizResult;
use App\Models\UserBadge;
use App\Models\UserProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function completeLesson(Request $request)
    {
        $user = auth('api')->user();

        $data = $request->validate([
            'lesson_id' => ['required', 'string', 'max:100'],
        ]);

        $lessonId = $data['lesson_id'];

        $completed = CompletedLesson::firstOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            ['completed_at' => now()]
        );

        $this->addXp($user->id, 25);

        $this->updateStreak($user->id);

        $this->checkLessonBadges($user->id);

        return response()->json([
            'completed' => $completed,
            'progress' => UserProgress::where('user_id', $user->id)->first(),
        ]);
    }

    public function submitQuiz(Request $request)
    {
        $user = auth('api')->user();

        $data = $request->validate([
            'lesson_id' => ['required', 'string', 'max:100'],
            'score' => ['required', 'integer', 'min:0'],
            'max_score' => ['required', 'integer', 'min:1'],
            'answers' => ['required', 'array'],
        ]);

        $percentage = ($data['score'] / $data['max_score']) * 100;

        $quiz = QuizResult::create([
            'user_id' => $user->id,
            'lesson_id' => $data['lesson_id'],
            'score' => $data['score'],
            'max_score' => $data['max_score'],
            'answers' => $data['answers'],
            'completed_at' => now(),
        ]);

        if ($percentage >= 100) {
            $this->addXp($user->id, 25);
        } elseif ($percentage >= 75) {
            $this->addXp($user->id, 15);
        } else {
            $this->addXp($user->id, 10);
        }

        $this->updateStreak($user->id);

        $this->checkQuizBadges($user->id, $percentage);

        return response()->json([
            'quiz' => $quiz,
            'progress' => UserProgress::where('user_id', $user->id)->first(),
        ]);
    }

    public function streak()
    {
        $user = auth('api')->user();

        $progress = UserProgress::where('user_id', $user->id)->firstOrFail();

        return response()->json([
            'currentStreak' => $progress->current_streak,
            'longestStreak' => $progress->longest_streak,
            'lastActivityDate' => $progress->last_activity_date,
        ]);
    }

    public function checkStreak()
    {
        $user = auth('api')->user();

        $progress = $this->updateStreak($user->id);

        return response()->json([
            'currentStreak' => $progress->current_streak,
            'longestStreak' => $progress->longest_streak,
            'lastActivityDate' => $progress->last_activity_date,
        ]);
    }

    protected function addXp(int $userId, int $amount): void
    {
        $progress = UserProgress::firstOrCreate(
            ['user_id' => $userId],
            []
        );

        $progress->total_xp += $amount;
        $progress->level = $this->calculateLevel($progress->total_xp);
        $progress->save();
    }

    protected function calculateLevel(int $totalXp): int
    {
        return (int) floor(sqrt($totalXp / 50)) + 1;
    }

    protected function updateStreak(int $userId): UserProgress
    {
        $progress = UserProgress::firstOrCreate(
            ['user_id' => $userId],
            []
        );

        $today = Carbon::today();

        if (! $progress->last_activity_date) {
            $progress->current_streak = 1;
            $progress->longest_streak = max($progress->longest_streak, 1);
        } else {
            $last = Carbon::parse($progress->last_activity_date);

            if ($last->isSameDay($today)) {
                // nothing
            } elseif ($last->isYesterday()) {
                $progress->current_streak += 1;
                $progress->longest_streak = max($progress->longest_streak, $progress->current_streak);
            } else {
                $progress->current_streak = 1;
            }
        }

        $progress->last_activity_date = $today;
        $progress->save();

        return $progress;
    }

    protected function checkLessonBadges(int $userId): void
    {
        $count = CompletedLesson::where('user_id', $userId)->count();

        $this->maybeAwardBadge($userId, 'first-lesson', $count >= 1);
        $this->maybeAwardBadge($userId, 'five-lessons', $count >= 5);
        $this->maybeAwardBadge($userId, 'ten-lessons', $count >= 10);
        $this->maybeAwardBadge($userId, 'twenty-lessons', $count >= 20);
    }

    protected function checkQuizBadges(int $userId, float $percentage): void
    {
        $totalQuizzes = QuizResult::where('user_id', $userId)->count();

        $this->maybeAwardBadge($userId, 'first-quiz', $totalQuizzes >= 1);

        if ($percentage >= 100) {
            $this->maybeAwardBadge($userId, 'perfect-quiz', true);

            $perfectCount = QuizResult::where('user_id', $userId)
                ->whereColumn('score', 'max_score')
                ->count();

            $this->maybeAwardBadge($userId, 'five-perfect', $perfectCount >= 5);
        }
    }

    protected function maybeAwardBadge(int $userId, string $badgeId, bool $condition): void
    {
        if (! $condition) {
            return;
        }

        UserBadge::firstOrCreate(
            ['user_id' => $userId, 'badge_id' => $badgeId],
            ['earned_at' => now()]
        );
    }
}

