@extends('admin.layout')

@section('title', __('admin.achievements'))
@section('heading', __('admin.achievements'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.achievements') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.achievements.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.achievements')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.achievements.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.max_progress') }}</th>
            <th>{{ __('admin.xp_reward') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($achievements as $achievement)
            <tr>
                <td><span class="badge-pill">{{ $achievement->id }}</span></td>
                <td>{{ $achievement->name }}</td>
                <td>{{ $achievement->max_progress }}</td>
                <td>{{ $achievement->xp_reward }}</td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
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
    @include('admin.partials.pagination', ['paginator' => $achievements])
@endsection

