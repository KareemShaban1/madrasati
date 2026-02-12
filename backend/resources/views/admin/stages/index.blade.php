@extends('admin.layout')

@section('title', __('admin.stages'))
@section('heading', __('admin.stages'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.stages') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.stages.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.stages')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.stages.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.stages.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.name_en') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($stages as $stage)
            <tr>
                <td><span class="badge-pill">{{ $stage->code }}</span></td>
                <td>{{ $stage->name }}</td>
                <td>{{ $stage->name_en }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.stages.edit', $stage) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.stages.destroy', $stage) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">{{ __('admin.no_records') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('admin.partials.pagination', ['paginator' => $stages])
@endsection

