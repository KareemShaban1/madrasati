@extends('admin.layout')

@section('title', 'New Achievement')
@section('heading', 'Create Achievement')
@section('subheading', 'Add a new achievement definition.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">New achievement</div>
            <div class="page-desc">Leave ID empty to auto-generate from the name.</div>
        </div>
        <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.achievements.store') }}">
        @csrf
        <div class="form-row">
            <div class="field">
                <label for="id">ID (optional)</label>
                <input id="id" name="id" value="{{ old('id') }}">
            </div>
            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="max_progress">Max progress</label>
                <input id="max_progress" type="number" min="1" name="max_progress" value="{{ old('max_progress', 1) }}" required>
            </div>
            <div class="field">
                <label for="xp_reward">XP reward</label>
                <input id="xp_reward" type="number" min="0" name="xp_reward" value="{{ old('xp_reward', 50) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="icon">Icon (Lucide name)</label>
                <input id="icon" name="icon" value="{{ old('icon') }}">
            </div>
            <div class="field">
                <label for="description">Description</label>
                <input id="description" name="description" value="{{ old('description') }}">
            </div>
        </div>
        <button type="submit" class="btn">Create achievement</button>
    </form>
@endsection

