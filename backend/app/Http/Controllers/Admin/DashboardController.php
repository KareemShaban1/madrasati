<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stages' => Stage::orderBy('id')->get(),
            'grades' => Grade::orderBy('id')->get(),
            'subjects' => Subject::orderBy('id')->get(),
            'units' => Unit::orderBy('id')->get(),
        ]);
    }

    public function storeStage(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:stages,id'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Stage::create([
            'id' => $data['id'],
            'name' => $data['name'],
            'name_en' => $data['name_en'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Stage created');
    }

    public function storeGrade(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:grades,id'],
            'stage_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
        ]);

        Grade::create($data);

        return redirect()->route('admin.dashboard')->with('status', 'Grade created');
    }

    public function storeSubject(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:subjects,id'],
            'grade_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:100'],
        ]);

        Subject::create($data);

        return redirect()->route('admin.dashboard')->with('status', 'Subject created');
    }

    public function storeUnit(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:units,id'],
            'subject_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Unit::create($data);

        return redirect()->route('admin.dashboard')->with('status', 'Unit created');
    }

    public function storeLesson(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:lessons,id'],
            'unit_id' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'in:video,interactive,quiz'],
        ]);

        Lesson::create($data);

        return redirect()->route('admin.dashboard')->with('status', 'Lesson created');
    }
}

