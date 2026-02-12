<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $query = Badge::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            });
        }

        $badges = $query->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['nullable', 'string', 'max:50', 'unique:badges,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'in:learning,streak,mastery,special'],
            'requirement_type' => ['required', 'in:lessons_completed,quizzes_passed,streak_days,perfect_quizzes,subject_mastery'],
            'requirement_value' => ['required', 'integer', 'min:1'],
            'subject_id' => ['nullable', 'string', 'max:50'],
        ]);

        $id = $data['id'] ?: Str::slug($data['name_en']);

        Badge::create([
            'id' => $id,
            'name' => $data['name'],
            'name_en' => $data['name_en'],
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? null,
            'category' => $data['category'],
            'requirement_type' => $data['requirement_type'],
            'requirement_value' => $data['requirement_value'],
            'subject_id' => $data['subject_id'] ?? null,
        ]);

        return redirect()->route('admin.badges.index')->with('status', 'Badge created.');
    }

    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    public function update(Request $request, Badge $badge)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'in:learning,streak,mastery,special'],
            'requirement_type' => ['required', 'in:lessons_completed,quizzes_passed,streak_days,perfect_quizzes,subject_mastery'],
            'requirement_value' => ['required', 'integer', 'min:1'],
            'subject_id' => ['nullable', 'string', 'max:50'],
        ]);

        $badge->update($data);

        return redirect()->route('admin.badges.index')->with('status', 'Badge updated.');
    }

    public function destroy(Badge $badge)
    {
        $badge->delete();

        return redirect()->route('admin.badges.index')->with('status', 'Badge deleted.');
    }
}

