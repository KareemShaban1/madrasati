@extends('admin.layout')

@section('title', 'New Subject')
@section('heading', 'Create Subject')
@section('subheading', 'Create a subject under a grade.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New subject</div>
            <div class="page-desc">IDs are generated from grade and English name.</div>
        </div>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.subjects.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="grade_id">Grade</label>
                <select id="grade_id" name="grade_id" required>
                    <option value="">Select grade…</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" @selected(old('grade_id') === $grade->id)>
                            {{ $grade->id }} — {{ $grade->name }}
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
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon') }}">
            </div>
            <div class="field">
                <label for="color">Color class (e.g. text-blue-500)</label>
                <input id="color" name="color" value="{{ old('color') }}">
            </div>
        </div>
        @include('admin.partials.attachments_create_section', ['attachableType' => 'subject'])
        <button type="submit" class="btn">Create subject</button>
    </form>
@endsection

