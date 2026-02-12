<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function global(Request $request)
    {
        $limit = (int) ($request->query('limit', 50));

        $users = UserProgress::with('user')
            ->orderByDesc('total_xp')
            ->limit($limit)
            ->get()
            ->map(function (UserProgress $progress) {
                return [
                    'userId' => $progress->user_id,
                    'fullName' => $progress->user?->full_name,
                    'gradeId' => $progress->user?->grade_id,
                    'totalXP' => $progress->total_xp,
                    'level' => $progress->level,
                ];
            });

        return response()->json($users);
    }

    public function byGrade(string $gradeId, Request $request)
    {
        $limit = (int) ($request->query('limit', 50));

        $users = UserProgress::whereHas('user', function ($q) use ($gradeId) {
                $q->where('grade_id', $gradeId);
            })
            ->with('user')
            ->orderByDesc('total_xp')
            ->limit($limit)
            ->get()
            ->map(function (UserProgress $progress) {
                return [
                    'userId' => $progress->user_id,
                    'fullName' => $progress->user?->full_name,
                    'gradeId' => $progress->user?->grade_id,
                    'totalXP' => $progress->total_xp,
                    'level' => $progress->level,
                ];
            });

        return response()->json($users);
    }
}

