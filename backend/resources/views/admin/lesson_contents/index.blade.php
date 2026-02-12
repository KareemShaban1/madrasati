@extends('admin.layout')

@section('title', __('admin.lesson_content'))
@section('heading', __('admin.lesson_content'))
@section('subheading', __('admin.manage_curriculum'))

@section('content')
    <div class="page-header">
        <div>
            <div class="page-title">{{ __('admin.lesson_content') }}</div>
            <div class="page-desc">{{ __('admin.subtitle') }}</div>
        </div>
        <a href="{{ route('admin.lesson-contents.create') }}" class="btn btn-secondary">{{ __('admin.new') }} {{ strtolower(__('admin.lesson_content')) }}</a>
    </div>

    <form method="GET" action="{{ route('admin.lesson-contents.index') }}" class="filters">
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
            <label>{{ __('admin.lesson') }}</label>
            <select name="lesson_id">
                <option value="">{{ __('admin.all') }}</option>
                @foreach($lessons as $l)
                    <option value="{{ $l->id }}" {{ request('lesson_id') == $l->id ? 'selected' : '' }}>{{ $l->title_en ?? $l->title }} ({{ $l->unit?->name_en }})</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>{{ __('admin.search') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin.search') }}">
        </div>
        <button type="submit" class="btn">{{ __('admin.apply') }}</button>
        <a href="{{ route('admin.lesson-contents.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.lesson') }}</th>
            <th>{{ __('admin.unit') }} / {{ __('admin.subject') }} / {{ __('admin.grade') }}</th>
            <th>{{ __('admin.title') }}</th>
            <th>{{ __('admin.objectives') }}</th>
            <th>{{ __('admin.quiz_questions') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($contents as $content)
            <tr>
                <td>
                    <span class="badge-pill">{{ $content->lesson?->code ?? $content->lesson_id }}</span>
                </td>
                <td>
                    {{ $content->lesson?->unit?->name_en ?? '' }} /
                    {{ $content->lesson?->unit?->subject?->name_en ?? '' }} /
                    {{ $content->lesson?->unit?->subject?->grade?->name_en ?? '' }}
                </td>
                <td>{{ $content->title }}</td>
                <td>{{ $content->objectives ? count($content->objectives) : 0 }}</td>
                <td>{{ $content->quick_quiz ? count($content->quick_quiz) : 0 }}</td>
                <td style="text-align:right;">
                    <button type="button" class="btn btn-secondary view-json-btn" style="margin-right:0.25rem;" data-sections="{{ e(json_encode($content->sections ?? [])) }}" data-title="{{ e($content->title) }}">{{ __('admin.view_json') }}</button>
                    <a href="{{ route('admin.lesson-contents.edit', $content) }}" class="btn btn-secondary" style="margin-right:0.25rem;">{{ __('admin.edit') }}</a>
                    <form action="{{ route('admin.lesson-contents.destroy', $content) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">{{ __('admin.no_records') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('admin.partials.pagination', ['paginator' => $contents])

    <div id="json-modal" class="modal-backdrop" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="json-modal-title">
        <div class="modal-box">
            <div class="modal-header">
                <span id="json-modal-title">{{ __('admin.view_json') }}</span>
                <button type="button" class="btn btn-secondary json-modal-close" aria-label="{{ __('admin.close') }}">{{ __('admin.close') }}</button>
            </div>
            <div class="modal-body">
                <p><strong>{{ __('admin.sections') }}</strong> ({{ __('admin.view_json') }})</p>
                <pre id="json-modal-sections"></pre>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('json-modal');
    var titleEl = document.getElementById('json-modal-title');
    var sectionsEl = document.getElementById('json-modal-sections');
    function showModal(title, sections) {
        titleEl.textContent = title || '{{ __("admin.view_json") }}';
        function format(val) {
            if (!val) return '[]';
            try {
                var p = typeof val === 'string' ? JSON.parse(val) : val;
                return JSON.stringify(p, null, 2);
            } catch (e) { return typeof val === 'string' ? val : '[]'; }
        }
        sectionsEl.textContent = format(sections);
        modal.style.display = 'flex';
    }
    function hideModal() { modal.style.display = 'none'; }
    document.querySelectorAll('.view-json-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            showModal(this.dataset.title, this.dataset.sections);
        });
    });
    modal.querySelector('.json-modal-close').addEventListener('click', hideModal);
    modal.addEventListener('click', function(e) { if (e.target === modal) hideModal(); });
});
</script>
@endpush

