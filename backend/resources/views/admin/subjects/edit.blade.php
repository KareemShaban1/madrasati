@extends('admin.layout')

@section('title', 'Edit Subject')
@section('heading', 'Edit Subject')
@section('subheading', 'Update subject information.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit subject: {{ $subject->id }}</div>
            <div class="page-desc">You can change grade, names, icon, and color.</div>
        </div>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label for="grade_id">Grade</label>
                <select id="grade_id" name="grade_id" required>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" @selected(old('grade_id', $subject->grade_id) === $grade->id)>
                            {{ $grade->id }} — {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name', $subject->name) }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en', $subject->name_en) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon', $subject->icon) }}">
            </div>
            <div class="field">
                <label for="color">Color class</label>
                <input id="color" name="color" value="{{ old('color', $subject->color) }}">
            </div>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>

    @include('admin.partials.attachments_section', ['attachable' => $subject->load('attachments'), 'attachableType' => 'subject'])
@endsection

