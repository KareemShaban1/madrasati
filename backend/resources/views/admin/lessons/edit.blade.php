@extends('admin.layout')

@section('title', 'Edit Lesson')
@section('heading', 'Edit Lesson')
@section('subheading', 'Update lesson information.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit lesson: {{ $lesson->id }}</div>
            <div class="page-desc">You can change unit, titles, duration, and type.</div>
        </div>
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label for="unit_id">Unit</label>
                <select id="unit_id" name="unit_id" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id', $lesson->unit_id) === $unit->id)>
                            {{ $unit->id }} — {{ $unit->name }} ({{ $unit->subject?->name_en }} / {{ $unit->subject?->grade?->name_en }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="title">Title (Arabic)</label>
                <input id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
            </div>
            <div class="field">
                <label for="title_en">Title (English)</label>
                <input id="title_en" name="title_en" value="{{ old('title_en', $lesson->title_en) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="duration">Duration</label>
                <input id="duration" name="duration" value="{{ old('duration', $lesson->duration) }}">
            </div>
            <div class="field">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="video" @selected(old('type', $lesson->type) === 'video')>Video</option>
                    <option value="interactive" @selected(old('type', $lesson->type) === 'interactive')>Interactive</option>
                    <option value="quiz" @selected(old('type', $lesson->type) === 'quiz')>Quiz</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>

    @include('admin.partials.attachments_section', ['attachable' => $lesson->load('attachments'), 'attachableType' => 'lesson'])
@endsection

