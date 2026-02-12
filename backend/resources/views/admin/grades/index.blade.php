@extends('admin.layout')

@section('title', __('admin.grades'))
@section('heading', __('admin.grades'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.grades') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.grades.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.grades')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.grades.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.stage') }}</label>
            <select name="stage_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($stages as $s)
                    <option value="{{ $s->id }}" {{ request('stage_id') == $s->id ? 'selected' : '' }}>{{ $s->name_en }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.stage') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.name_en') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($grades as $grade)
            <tr>
                <td><span class="badge-pill">{{ $grade->code }}</span></td>
                <td>{{ $grade->stage?->name_en ?? $grade->stage_id }}</td>
                <td>{{ $grade->name }}</td>
                <td>{{ $grade->name_en }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.grades.edit', $grade) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">{{ __('admin.no_records') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('admin.partials.pagination', ['paginator' => $grades])
@endsection

