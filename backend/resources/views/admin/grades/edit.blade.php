@extends('admin.layout')

@section('title', 'Edit Grade')
@section('heading', 'Edit Grade')
@section('subheading', 'Update grade names or stage.')

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">Edit grade: {{ $grade->id }}</div>
            <div class="page-desc">You can change the stage and display names.</div>
        </div>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Back to list</a>
    </div>

    <form method="POST" action="{{ route('admin.grades.update', $grade) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="field">
                <label for="stage_id">Stage</label>
                <select id="stage_id" name="stage_id" required>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" @selected(old('stage_id', $grade->stage_id) === $stage->id)>
                            {{ $stage->id }} — {{ $stage->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="name">Name (Arabic)</label>
                <input id="name" name="name" value="{{ old('name', $grade->name) }}" required>
            </div>
            <div class="field">
                <label for="name_en">Name (English)</label>
                <input id="name_en" name="name_en" value="{{ old('name_en', $grade->name_en) }}" required>
            </div>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </form>

    @include('admin.partials.attachments_section', ['attachable' => $grade->load('attachments'), 'attachableType' => 'grade'])
@endsection

