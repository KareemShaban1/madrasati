@extends('admin.layout')

@section('title', 'New Lesson Content')
@section('heading', 'Create Lesson Content')
@section('subheading', 'Define objectives, sections, and quick quiz for a lesson.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New lesson content</div>
            <div class="page-desc">Add sections (video, text, quiz) and questions. One line per objective / key point.</div>
        </div>
        <a href="{{ route('admin.lesson-contents.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.lesson-contents.store') }}">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="lesson_id">Lesson</label>
                <select id="lesson_id" name="lesson_id" required>
                    <option value="">Select lesson…</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" @selected(old('lesson_id') === $lesson->id)>
                            {{ $lesson->id }} — {{ $lesson->title }} ({{ $lesson->unit?->subject?->grade?->name_en }} / {{ $lesson->unit?->subject?->name_en }} / {{ $lesson->unit?->name_en }})
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
                <label for="prev_lesson_id">Previous lesson ID (optional)</label>
                <input id="prev_lesson_id" name="prev_lesson_id" value="{{ old('prev_lesson_id') }}">
            </div>
            <div class="field">
                <label for="next_lesson_id">Next lesson ID (optional)</label>
                <input id="next_lesson_id" name="next_lesson_id" value="{{ old('next_lesson_id') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="objectives_text">Objectives (one per line)</label>
                <textarea id="objectives_text" name="objectives_text" rows="4">{{ old('objectives_text') }}</textarea>
            </div>
            <div class="field">
                <label for="key_points_text">Key points (one per line)</label>
                <textarea id="key_points_text" name="key_points_text" rows="4">{{ old('key_points_text') }}</textarea>
            </div>
        </div>

        @include('admin.partials.sections_section', ['sections' => old('sections', [])])

        @include('admin.partials.questions_section', ['questions' => old('questions', [])])

        <button type="submit" class="btn">Create content</button>
    </form>
@endsection

@include('admin.partials.questions_script')
@include('admin.partials.sections_script')

