<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StageController extends Controller
{
    public function index(Request $request)
    {
        $query = Stage::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $stages = $query->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.stages.index', compact('stages'));
    }

    public function create()
    {
        return view('admin.stages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $id = Str::slug($data['name_en']);

        Stage::create([
            'id' => $id,
            'name' => $data['name'],
            'name_en' => $data['name_en'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.stages.index')->with('status', 'Stage created.');
    }

    public function edit(Stage $stage)
    {
        return view('admin.stages.edit', compact('stage'));
    }

    public function update(Request $request, Stage $stage)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $stage->update($data);

        return redirect()->route('admin.stages.index')->with('status', 'Stage updated.');
    }

    public function destroy(Stage $stage)
    {
        $stage->delete();

        return redirect()->route('admin.stages.index')->with('status', 'Stage deleted.');
    }
}

