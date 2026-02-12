<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AttachmentController;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::with('unit.subject.grade')
            ->join('units', 'lessons.unit_id', '=', 'units.id')
            ->join('subjects', 'units.subject_id', '=', 'subjects.id')
            ->join('grades', 'subjects.grade_id', '=', 'grades.id')
            ->select('lessons.*');

        // Filters
        if ($request->filled('unit_id')) {
            $query->where('lessons.unit_id', $request->unit_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('units.subject_id', $request->subject_id);
        }
        if ($request->filled('grade_id')) {
            $query->where('subjects.grade_id', $request->grade_id);
        }
        if ($request->filled('type')) {
            $query->where('lessons.type', $request->type);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('lessons.title', 'like', "%{$q}%")
                    ->orWhere('lessons.title_en', 'like', "%{$q}%")
                    ->orWhere('lessons.code', 'like', "%{$q}%");
            });
        }

        $lessons = $query
            ->orderBy('grades.id')
            ->orderBy('subjects.id')
            ->orderBy('units.id')
            ->orderBy('lessons.id')
            ->paginate(15)
            ->withQueryString();

        $units = Unit::with('subject.grade')->orderBy('id')->get();
        $subjects = Subject::with('grade')->orderBy('id')->get();
        $grades = Grade::with('stage')->orderBy('id')->get();

        return view('admin.lessons.index', compact('lessons', 'units', 'subjects', 'grades'));
    }

    public function create()
    {
        $units = Unit::with('subject.grade')->orderBy('id')->get();

        return view('admin.lessons.create', compact('units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'in:video,interactive,quiz'],
            'files' => ['nullable'],
            'files.*' => ['file', 'max:51200'],
        ]);

        $id = 'lesson-'.Str::slug($data['title_en']);

        $lesson = Lesson::create([
            'id' => $id,
            'unit_id' => $data['unit_id'],
            'title' => $data['title'],
            'title_en' => $data['title_en'],
            'duration' => $data['duration'] ?? null,
            'type' => $data['type'],
        ]);

        $attCount = AttachmentController::processAttachmentsFromRequest($request, $lesson, 'lesson');
        $msg = 'Lesson created.';
        if ($attCount > 0) {
            $msg .= ' ' . $attCount . ' attachment(s) added.';
        } else {
            $msg .= ' You can add attachments below.';
        }

        return redirect()->route('admin.lessons.edit', $lesson)->with('status', $msg);
    }

    public function edit(Lesson $lesson)
    {
        $units = Unit::with('subject.grade')->orderBy('id')->get();

        return view('admin.lessons.edit', compact('lesson', 'units'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'unit_id' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'in:video,interactive,quiz'],
        ]);

        $lesson->update($data);

        return redirect()->route('admin.lessons.index')->with('status', 'Lesson updated.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('status', 'Lesson deleted.');
    }
}

