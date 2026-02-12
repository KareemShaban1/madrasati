@extends('admin.layout')

@section('title', 'New Unit')
@section('heading', 'Create Unit')
@section('subheading', 'Create a unit inside a subject.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New unit</div>
            <div class="page-desc">IDs are generated from the English name.</div>
        </div>
        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.units.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="subject_id">Subject</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">Select subject…</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected(old('subject_id') === $subject->id)>
                            {{ $subject->id }} — {{ $subject->name }}
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
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        @include('admin.partials.attachments_create_section', ['attachableType' => 'unit'])
        <button type="submit" class="btn">Create unit</button>
    </form>
@endsection

