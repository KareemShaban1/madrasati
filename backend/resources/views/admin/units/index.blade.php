@extends('admin.layout')

@section('title', __('admin.units'))
@section('heading', __('admin.units'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.units') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.units.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.units')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.units.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.subject') }}</label>
            <select name="subject_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name_en }} ({{ $s->grade?->name_en }})</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.subject') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.name_en') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($units as $unit)
            <tr>
                <td><span class="badge-pill">{{ $unit->code }}</span></td>
                <td>{{ $unit->subject?->name_en ?? $unit->subject_id }}</td>
                <td>{{ $unit->name }}</td>
                <td>{{ $unit->name_en }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
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
    @include('admin.partials.pagination', ['paginator' => $units])
@endsection

