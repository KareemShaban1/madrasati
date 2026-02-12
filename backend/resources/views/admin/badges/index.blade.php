@extends('admin.layout')

@section('title', __('admin.badges'))
@section('heading', __('admin.badges'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.badges') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.badges.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.badges')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.badges.index') }}" class="filters">
        <div class="filter-group">
            <label>{{ __('admin.category') }}</label>
            <select name="category">
                <option value="">{{ __('admin.all') }}</option>
                <option value="learning" {{ request('category') === 'learning' ? 'selected' : '' }}>Learning</option>
                <option value="streak" {{ request('category') === 'streak' ? 'selected' : '' }}>Streak</option>
                <option value="mastery" {{ request('category') === 'mastery' ? 'selected' : '' }}>Mastery</option>
                <option value="special" {{ request('category') === 'special' ? 'selected' : '' }}>Special</option>
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.badges.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.name_ar') }}</th>
            <th>{{ __('admin.category') }}</th>
            <th>{{ __('admin.requirement') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($badges as $badge)
            <tr>
                <td><span class="badge-pill">{{ $badge->id }}</span></td>
                <td>{{ $badge->name }} ({{ $badge->name_en }})</td>
                <td>{{ ucfirst($badge->category) }}</td>
                <td>
                    {{ $badge->requirement_type }} ≥ {{ $badge->requirement_value }}
                    @if($badge->subject_id)
                        ({{ $badge->subject_id }})
                    @endif
                </td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.badges.edit', $badge) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
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
    @include('admin.partials.pagination', ['paginator' => $badges])
@endsection

