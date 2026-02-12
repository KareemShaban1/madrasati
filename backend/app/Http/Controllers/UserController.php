<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserBadge;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $id)
    {
        $this->authorizeUser($id);

        return User::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeUser($id);

        $user = User::findOrFail($id);

        $data = $request->validate([
            'full_name' => ['sometimes', 'string', 'max:255'],
            'avatar_url' => ['sometimes', 'string', 'max:2048'],
            'grade_id' => ['sometimes', 'string', 'max:50'],
        ]);

        $user->update($data);

        return $user->fresh();
    }

    public function progress(string $id)
    {
        $this->authorizeUser($id);

        $progress = UserProgress::where('user_id', $id)->firstOrFail();

        return $progress;
    }

    public function badges(string $id)
    {
        $this->authorizeUser($id);

        $badges = UserBadge::where('user_id', $id)->get();

        return $badges;
    }

    public function achievements(string $id)
    {
        $this->authorizeUser($id);

        $achievements = UserAchievement::where('user_id', $id)->get();

        return $achievements;
    }

    private function authorizeUser(string $id): void
    {
        $user = auth('api')->user();

        if (! $user || ($user->id != $id && $user->role !== 'admin')) {
            abort(403, 'Unauthorized');
        }
    }
}

