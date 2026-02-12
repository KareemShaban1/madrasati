@extends('admin.layout')

@section('title', 'Edit Unit')
@section('heading', 'Edit Unit')
@section('subheading', 'Update unit information.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit unit: {{ $unit->id }}</div>
            <div class="page-desc">You can change subject, names, and description.</div>
        </div>
        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.units.update', $unit) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label for="subject_id">Subject</label>
                <select id="subject_id" name="subject_id" required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected(old('subject_id', $unit->subject_id) === $subject->id)>
                            {{ $subject->id }} — {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name', $unit->name) }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en', $unit->name_en) }}" required>
            </div>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $unit->description) }}</textarea>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>

    @include('admin.partials.attachments_section', ['attachable' => $unit->load('attachments'), 'attachableType' => 'unit'])
@endsection

