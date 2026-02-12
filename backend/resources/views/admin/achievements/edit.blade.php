@extends('admin.layout')

@section('title', 'Edit Achievement')
@section('heading', 'Edit Achievement')
@section('subheading', 'Update achievement progress target and XP reward.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit achievement: {{ $achievement->id }}</div>
            <div class="page-desc">Adjust name, description, max progress, and reward.</div>
        </div>
        <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.achievements.update', $achievement) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label>ID</label>
                <input value="{{ $achievement->id }}" disabled>
            </div>
            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name', $achievement->name) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="max_progress">Max progress</label>
                <input id="max_progress" type="number" min="1" name="max_progress" value="{{ old('max_progress', $achievement->max_progress) }}" required>
            </div>
            <div class="field">
                <label for="xp_reward">XP reward</label>
                <input id="xp_reward" type="number" min="0" name="xp_reward" value="{{ old('xp_reward', $achievement->xp_reward) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon', $achievement->icon) }}">
            </div>
            <div class="field">
                <label for="description">Description</label>
                <input id="description" name="description" value="{{ old('description', $achievement->description) }}">
            </div>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>
@endsection

