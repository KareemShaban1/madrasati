@extends('admin.layout')

@section('title', __('admin.lessons'))
@section('heading', __('admin.lessons'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.lessons') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.lessons')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.lessons.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.grade') }}</label>
            <select name="grade_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($grades as $g)
                    <option value="{{ $g->id }}" {{ request('grade_id') == $g->id ? 'selected' : '' }}>{{ $g->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.subject') }}</label>
            <select name="subject_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.unit') }}</label>
            <select name="unit_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($units as $u)
                    <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name_en }} ({{ $u->subject?->name_en }})</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.type') }}</label>
            <select name="type">
                <option value="">{{ __('admin.all') }}</option>
                <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Video</option>
                <option value="interactive" {{ request('type') === 'interactive' ? 'selected' : '' }}>Interactive</option>
                <option value="quiz" {{ request('type') === 'quiz' ? 'selected' : '' }}>Quiz</option>
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.unit') }}</th>
            <th>{{ __('admin.subject') }}</th>
            <th>{{ __('admin.grade') }}</th>
            <th>{{ __('admin.title') }} (AR)</th>
            <th>{{ __('admin.type') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($lessons as $lesson)
            <tr>
                <td><span class="badge-pill">{{ $lesson->code }}</span></td>
                <td>{{ $lesson->unit?->name_en ?? $lesson->unit_id }}</td>
                <td>{{ $lesson->unit?->subject?->name_en }}</td>
                <td>{{ $lesson->unit?->subject?->grade?->name_en }}</td>
                <td>{{ $lesson->title }}</td>
                <td>{{ ucfirst($lesson->type) }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">{{ __('admin.no_records') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('admin.partials.pagination', ['paginator' => $lessons])
@endsection

