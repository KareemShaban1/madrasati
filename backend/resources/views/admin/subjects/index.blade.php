@extends('admin.layout')

@section('title', __('admin.subjects'))
@section('heading', __('admin.subjects'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.subjects') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.subjects')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.subjects.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.grade') }}</label>
            <select name="grade_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($grades as $g)
                    <option value="{{ $g->id }}" {{ request('grade_id') == $g->id ? 'selected' : '' }}>{{ $g->name_en }} ({{ $g->stage?->name_en }})</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.grade') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.name_en') }}</th>
            <th>Icon</th>
            <th>Color</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($subjects as $subject)
            <tr>
                <td><span class="badge-pill">{{ $subject->code }}</span></td>
                <td>{{ $subject->grade?->name_en ?? $subject->grade_id }}</td>
                <td>{{ $subject->name }}</td>
                <td>{{ $subject->name_en }}</td>
                <td>{{ $subject->icon }}</td>
                <td>{{ $subject->color }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
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
    @include('admin.partials.pagination', ['paginator' => $subjects])
@endsection

