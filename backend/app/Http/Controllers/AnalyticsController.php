<?php

namespace App\Http\Controllers;

use App\Models\CompletedLesson;
use App\Models\QuizResult;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function users()
    {
        $totalUsers = User::count();
        $byGrade = User::select('grade_id', DB::raw('count(*) as count'))
            ->groupBy('grade_id')
            ->get();

        return response()->json([
            'totalUsers' => $totalUsers,
            'byGrade' => $byGrade,
        ]);
    }

    public function lessons()
    {
        $completions = CompletedLesson::select('lesson_id', DB::raw('count(*) as completions'))
            ->groupBy('lesson_id')
            ->orderByDesc('completions')
            ->get();

        return response()->json($completions);
    }

    public function subjects()
    {
        $subjectStats = Subject::query()
            ->leftJoin('units', 'subjects.id', '=', 'units.subject_id')
            ->leftJoin('lessons', 'units.id', '=', 'lessons.unit_id')
            ->leftJoin('completed_lessons', 'lessons.id', '=', 'completed_lessons.lesson_id')
            ->groupBy('subjects.id', 'subjects.name', 'subjects.name_en')
            ->select(
                'subjects.id',
                'subjects.name',
                'subjects.name_en',
                DB::raw('count(distinct lessons.id) as lessons_count'),
                DB::raw('count(completed_lessons.id) as completions')
            )
            ->orderByDesc('completions')
            ->get();

        return response()->json($subjectStats);
    }
}

