@extends('admin.layout')

@section('title', 'Edit Stage')
@section('heading', 'Edit Stage')
@section('subheading', 'Update an existing education stage.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit stage: {{ $stage->id }}</div>
            <div class="page-desc">You can adjust display names and description.</div>
        </div>
        <a href="{{ route('admin.stages.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.stages.update', $stage) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name', $stage->name) }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en', $stage->name_en) }}" required>
            </div>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $stage->description) }}</textarea>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>
@endsection

