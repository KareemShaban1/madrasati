@extends('admin.layout')

@section('title', 'New Lesson')
@section('heading', 'Create Lesson')
@section('subheading', 'Create a lesson inside a unit.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New lesson</div>
            <div class="page-desc">IDs are generated from the English title.</div>
        </div>
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.lessons.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="unit_id">Unit</label>
                <select id="unit_id" name="unit_id" required>
                    <option value="">Select unit…</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id') === $unit->id)>
                            {{ $unit->id }} — {{ $unit->name }} ({{ $unit->subject?->name_en }} / {{ $unit->subject?->grade?->name_en }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="title">Title (Arabic)</label>
                <input id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="field">
                <label for="title_en">Title (English)</label>
                <input id="title_en" name="title_en" value="{{ old('title_en') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="duration">Duration (e.g. 15 دقيقة)</label>
                <input id="duration" name="duration" value="{{ old('duration') }}">
            </div>
            <div class="field">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="video" @selected(old('type') === 'video')>Video</option>
                    <option value="interactive" @selected(old('type') === 'interactive')>Interactive</option>
                    <option value="quiz" @selected(old('type') === 'quiz')>Quiz</option>
                </select>
            </div>
        </div>
        @include('admin.partials.attachments_create_section', ['attachableType' => 'lesson'])
        <button type="submit" class="btn">Create lesson</button>
    </form>
@endsection

