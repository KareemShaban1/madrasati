<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AttachmentController;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('grade');

        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $subjects = $query->orderBy('id')->paginate(15)->withQueryString();
        $grades = Grade::with('stage')->orderBy('id')->get();

        return view('admin.subjects.index', compact('subjects', 'grades'));
    }

    public function create()
    {
        $grades = Grade::orderBy('id')->get();

        return view('admin.subjects.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'grade_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:100'],
            'files' => ['nullable'],
            'files.*' => ['file', 'max:51200'],
        ]);

        $id = $data['grade_id'].'-'.Str::slug($data['name_en']);

        $subject = Subject::create([
            'id' => $id,
            'grade_id' => $data['grade_id'],
            'name' => $data['name'],
            'name_en' => $data['name_en'],
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
        ]);

        $attCount = AttachmentController::processAttachmentsFromRequest($request, $subject, 'subject');
        $msg = 'Subject created.';
        if ($attCount > 0) {
            $msg .= ' ' . $attCount . ' attachment(s) added.';
        } else {
            $msg .= ' You can add attachments below.';
        }

        return redirect()->route('admin.subjects.edit', $subject)->with('status', $msg);
    }

    public function edit(Subject $subject)
    {
        $grades = Grade::orderBy('id')->get();

        return view('admin.subjects.edit', compact('subject', 'grades'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'grade_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:100'],
        ]);

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with('status', 'Subject updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('status', 'Subject deleted.');
    }
}

