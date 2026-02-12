<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AttachmentController;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with('stage');

        if ($request->filled('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $grades = $query->orderBy('id')->paginate(15)->withQueryString();
        $stages = Stage::orderBy('id')->get();

        return view('admin.grades.index', compact('grades', 'stages'));
    }

    public function create()
    {
        $stages = Stage::orderBy('id')->get();

        return view('admin.grades.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stage_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'files' => ['nullable'],
            'files.*' => ['file', 'max:51200'],
        ]);

        $id = $data['stage_id'].'-'.Str::slug($data['name_en']);

        $grade = Grade::create([
            'id' => $id,
            'stage_id' => $data['stage_id'],
            'name' => $data['name'],
            'name_en' => $data['name_en'],
        ]);

        $attCount = AttachmentController::processAttachmentsFromRequest($request, $grade, 'grade');
        $msg = 'Grade created.';
        if ($attCount > 0) {
            $msg .= ' ' . $attCount . ' attachment(s) added.';
        } else {
            $msg .= ' You can add attachments below.';
        }

        return redirect()->route('admin.grades.edit', $grade)->with('status', $msg);
    }

    public function edit(Grade $grade)
    {
        $stages = Stage::orderBy('id')->get();

        return view('admin.grades.edit', compact('grade', 'stages'));
    }

    public function update(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'stage_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
        ]);

        $grade->update($data);

        return redirect()->route('admin.grades.index')->with('status', 'Grade updated.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('admin.grades.index')->with('status', 'Grade deleted.');
    }
}

