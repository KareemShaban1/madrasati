@extends('admin.layout')

@section('title', 'Edit Badge')
@section('heading', 'Edit Badge')
@section('subheading', 'Update badge metadata and requirement.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit badge: {{ $badge->id }}</div>
            <div class="page-desc">Adjust names, icon, category, and requirement rule.</div>
        </div>
        <a href="{{ route('admin.badges.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.badges.update', $badge) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label>ID</label>
                <input value="{{ $badge->id }}" disabled>
            </div>
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name', $badge->name) }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en', $badge->name_en) }}" required>
            </div>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <input id="description" name="description" value="{{ old('description', $badge->description) }}">
        </div>
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon', $badge->icon) }}">
            </div>
            <div class="field">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    @foreach(['learning','streak','mastery','special'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category', $badge->category) === $cat)>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="requirement_type">Requirement type</label>
                <select id="requirement_type" name="requirement_type" required>
                    @foreach(['lessons_completed','quizzes_passed','streak_days','perfect_quizzes','subject_mastery'] as $type)
                        <option value="{{ $type }}" @selected(old('requirement_type', $badge->requirement_type) === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="requirement_value">Requirement value</label>
                <input id="requirement_value" type="number" min="1" name="requirement_value" value="{{ old('requirement_value', $badge->requirement_value) }}" required>
            </div>
            <div class="field">
                <label for="subject_id">Subject ID (optional)</label>
                <input id="subject_id" name="subject_id" value="{{ old('subject_id', $badge->subject_id) }}">
            </div>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>
@endsection

