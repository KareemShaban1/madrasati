@extends('admin.layout')

@section('title', 'New Grade')
@section('heading', 'Create Grade')
@section('subheading', 'Attach a new grade to a stage.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New grade</div>
            <div class="page-desc">IDs are generated from the stage and English name.</div>
        </div>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.grades.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="stage_id">Stage</label>
                <select id="stage_id" name="stage_id" required>
                    <option value="">Select stage…</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(old('stage_id') === $stage->id)>
                            {{ $stage->id }} — {{ $stage->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en') }}" required>
            </div>
        </div>
        @include('admin.partials.attachments_create_section', ['attachableType' => 'grade'])
        <button type="submit" class="btn">Create grade</button>
    </form>
@endsection

