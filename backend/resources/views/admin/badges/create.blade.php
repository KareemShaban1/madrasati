@extends('admin.layout')

@section('title', 'New Badge')
@section('heading', 'Create Badge')
@section('subheading', 'Add a new badge definition.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New badge</div>
            <div class="page-desc">Leave ID empty to auto-generate from English name.</div>
        </div>
        <a href="{{ route('admin.badges.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.badges.store') }}">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="id">ID (optional)</label>
                <input id="id" name="id" value="{{ old('id') }}">
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
        <div class="field">
            <label for="description">Description</label>
            <input id="description" name="description" value="{{ old('description') }}">
        </div>
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon') }}">
            </div>
            <div class="field">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    @foreach(['learning','streak','mastery','special'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="requirement_type">Requirement type</label>
                <select id="requirement_type" name="requirement_type" required>
                    @foreach(['lessons_completed','quizzes_passed','streak_days','perfect_quizzes','subject_mastery'] as $type)
                        <option value="{{ $type }}" @selected(old('requirement_type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="requirement_value">Requirement value</label>
                <input id="requirement_value" type="number" min="1" name="requirement_value" value="{{ old('requirement_value', 1) }}" required>
            </div>
            <div class="field">
                <label for="subject_id">Subject ID (optional)</label>
                <input id="subject_id" name="subject_id" value="{{ old('subject_id') }}" placeholder="e.g. p6-math">
            </div>
        </div>
        <button type="submit" class="btn">Create badge</button>
    </form>
@endsection

