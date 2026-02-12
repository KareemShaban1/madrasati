@extends('admin.layout')

@section('title', 'Edit Lesson Content')
@section('heading', 'Edit Lesson Content')
@section('subheading', 'Update lesson pipeline, sections, and quiz.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit content: {{ $content->lesson_id }}</div>
            <div class="page-desc">Edit objectives, key points, sections, and questions.</div>
        </div>
        <a href="{{ route('admin.lesson-contents.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.lesson-contents.update', $content) }}">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="field">
                <label for="lesson_id">Lesson</label>
                <select id="lesson_id" name="lesson_id" required>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" @selected(old('lesson_id', $content->lesson_id) === $lesson->id)>
                            {{ $lesson->id }} — {{ $lesson->title }} ({{ $lesson->unit?->subject?->grade?->name_en }} / {{ $lesson->unit?->subject?->name_en }} / {{ $lesson->unit?->name_en }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="title">Title (Arabic)</label>
                <input id="title" name="title" value="{{ old('title', $content->title) }}" required>
            </div>
            <div class="field">
                <label for="title_en">Title (English)</label>
                <input id="title_en" name="title_en" value="{{ old('title_en', $content->title_en) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="prev_lesson_id">Previous lesson ID (optional)</label>
                <input id="prev_lesson_id" name="prev_lesson_id" value="{{ old('prev_lesson_id', $content->prev_lesson_id) }}">
            </div>
            <div class="field">
                <label for="next_lesson_id">Next lesson ID (optional)</label>
                <input id="next_lesson_id" name="next_lesson_id" value="{{ old('next_lesson_id', $content->next_lesson_id) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="objectives_text">Objectives (one per line)</label>
                <textarea id="objectives_text" name="objectives_text" rows="4">{{ old('objectives_text', $objectivesText) }}</textarea>
            </div>
            <div class="field">
                <label for="key_points_text">Key points (one per line)</label>
                <textarea id="key_points_text" name="key_points_text" rows="4">{{ old('key_points_text', $keyPointsText) }}</textarea>
            </div>
        </div>

        @include('admin.partials.sections_section', ['sections' => old('sections', $sections)])

        @include('admin.partials.questions_section', ['questions' => $questions])

        <button type="submit" class="btn">Save changes</button>
    </form>
@endsection

@include('admin.partials.questions_script')
@include('admin.partials.sections_script')

