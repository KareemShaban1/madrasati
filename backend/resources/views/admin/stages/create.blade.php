@extends('admin.layout')

@section('title', 'New Stage')
@section('heading', 'Create Stage')
@section('subheading', 'Add a new education stage.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New stage</div>
            <div class="page-desc">IDs are generated automatically from the English name.</div>
        </div>
        <a href="{{ route('admin.stages.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.stages.store') }}">
        @csrf
        <div class="form-row">
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
        <button type="submit" class="btn">Create stage</button>
    </form>
@endsection

