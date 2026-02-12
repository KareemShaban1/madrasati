<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AttachmentController;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::with('subject.grade');

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $units = $query->orderBy('id')->paginate(15)->withQueryString();
        $subjects = Subject::with('grade')->orderBy('id')->get();

        return view('admin.units.index', compact('units', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::with('grade')->orderBy('id')->get();

        return view('admin.units.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'files' => ['nullable'],
            'files.*' => ['file', 'max:51200'],
        ]);

        $id = Str::slug($data['name_en']);

        $unit = Unit::create([
            'id' => $id,
            'subject_id' => $data['subject_id'],
            'name' => $data['name'],
            'name_en' => $data['name_en'],
            'description' => $data['description'] ?? null,
        ]);

        $attCount = AttachmentController::processAttachmentsFromRequest($request, $unit, 'unit');
        $msg = 'Unit created.';
        if ($attCount > 0) {
            $msg .= ' ' . $attCount . ' attachment(s) added.';
        } else {
            $msg .= ' You can add attachments below.';
        }

        return redirect()->route('admin.units.edit', $unit)->with('status', $msg);
    }

    public function edit(Unit $unit)
    {
        $subjects = Subject::with('grade')->orderBy('id')->get();

        return view('admin.units.edit', compact('unit', 'subjects'));
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $unit->update($data);

        return redirect()->route('admin.units.index')->with('status', 'Unit updated.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('admin.units.index')->with('status', 'Unit deleted.');
    }
}

