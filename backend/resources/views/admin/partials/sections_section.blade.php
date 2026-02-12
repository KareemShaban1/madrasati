{{-- Structured Sections: video, text, cartoon, story, example, summary, interactive (cards), quiz. --}}
@php
    $sections = $sections ?? [];
    if (old('sections') !== null) {
        $sections = old('sections');
    }
@endphp
<div class="sections-section">
    <div class="questions-section-header">
        <h3 class="questions-section-title">{{ __('admin.sections') }}</h3>
        <button type="button" class="btn btn-secondary btn-add-section" id="btn-add-section">{{ __('admin.add_section') }}</button>
    </div>
    <div class="sections-list" id="sections-list">
        @foreach($sections as $idx => $sec)
            @php
                $sec = is_array($sec) ? $sec : [];
                $stype = $sec['type'] ?? 'video';
                $items = isset($sec['items']) && is_array($sec['items']) ? $sec['items'] : [];
            @endphp
            <div class="section-row question-row" data-index="{{ $idx }}">
                <div class="question-row-head">
                    <label class="question-type-label">{{ __('admin.section_type') }}</label>
                    <select name="sections[{{ $idx }}][type]" class="section-type-select">
                        <option value="video" @selected($stype === 'video')>{{ __('admin.video') }}</option>
                        <option value="text" @selected($stype === 'text')>{{ __('admin.text') }}</option>
                        <option value="cartoon" @selected($stype === 'cartoon')>{{ __('admin.cartoon') }}</option>
                        <option value="story" @selected($stype === 'story')>{{ __('admin.story') }}</option>
                        <option value="example" @selected($stype === 'example')>{{ __('admin.example') }}</option>
                        <option value="summary" @selected($stype === 'summary')>{{ __('admin.summary') }}</option>
                        <option value="interactive" @selected($stype === 'interactive')>{{ __('admin.interactive') }}</option>
                        <option value="quiz" @selected($stype === 'quiz')>{{ __('admin.quiz') }}</option>
                    </select>
                    <button type="button" class="btn-remove-section btn btn-danger" style="margin-left:auto;">{{ __('admin.remove_section') }}</button>
                </div>
                <div class="field">
                    <label>{{ __('admin.title') }}</label>
                    <input type="text" name="sections[{{ $idx }}][title]" value="{{ $sec['title'] ?? '' }}" placeholder="{{ __('admin.title') }}">
                </div>
                <div class="section-fields-wrap" data-type="{{ $stype }}">
                    @if($stype === 'video')
                        <div class="field"><label>{{ __('admin.video_url') }}</label><input type="url" name="sections[{{ $idx }}][videoUrl]" value="{{ $sec['videoUrl'] ?? '' }}" placeholder="https://..."></div>
                        <div class="field"><label>{{ __('admin.duration') }}</label><input type="text" name="sections[{{ $idx }}][duration]" value="{{ $sec['duration'] ?? '' }}" placeholder="10 دقيقة"></div>
                    @elseif($stype === 'interactive')
                        <div class="field"><label>{{ __('admin.interactive_intro') }}</label>
                            <input type="hidden" name="sections[{{ $idx }}][content]" id="section-content-{{ $idx }}" value="{{ e($sec['content'] ?? '') }}">
                            <div id="quill-section-{{ $idx }}" class="section-rich-editor" data-input-id="section-content-{{ $idx }}" style="min-height:80px; background:var(--input-bg); border:1px solid var(--input-border); border-radius:0.55rem;"></div>
                        </div>
                        <div class="field">
                            <label>{{ __('admin.interactive_items') }}</label>
                            <div class="interactive-items-list">
                                @foreach($items as $j => $it)
                                    @php $it = is_array($it) ? $it : []; @endphp
                                    <div class="interactive-item-row">
                                        <input type="text" name="sections[{{ $idx }}][items][{{ $j }}][question]" value="{{ $it['question'] ?? '' }}" placeholder="{{ __('admin.question_text') }}">
                                        <input type="text" name="sections[{{ $idx }}][items][{{ $j }}][answer]" value="{{ $it['answer'] ?? '' }}" placeholder="{{ __('admin.correct_answer') }}">
                                        <input type="text" name="sections[{{ $idx }}][items][{{ $j }}][hint]" value="{{ $it['hint'] ?? '' }}" placeholder="{{ __('admin.explanation') }} ({{ __('admin.optional') }})">
                                        <button type="button" class="btn-remove-interactive-item btn btn-danger">{{ __('admin.remove_item') }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn-add-interactive-item btn btn-secondary" style="margin-top:0.25rem;">{{ __('admin.add_item') }}</button>
                        </div>
                    @else
                        <div class="field"><label>{{ __('admin.content') }}</label>
                            <input type="hidden" name="sections[{{ $idx }}][content]" id="section-content-{{ $idx }}" value="{{ e($sec['content'] ?? '') }}">
                            <div id="quill-section-{{ $idx }}" class="section-rich-editor" data-input-id="section-content-{{ $idx }}" style="min-height:160px; background:var(--input-bg); border:1px solid var(--input-border); border-radius:0.55rem;"></div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
<template id="section-row-tpl">
    <div class="section-row question-row" data-index="__IDX__">
        <div class="question-row-head">
            <label class="question-type-label">{{ __('admin.section_type') }}</label>
            <select name="sections[__IDX__][type]" class="section-type-select">
                <option value="video">{{ __('admin.video') }}</option>
                <option value="text">{{ __('admin.text') }}</option>
                <option value="cartoon">{{ __('admin.cartoon') }}</option>
                <option value="story">{{ __('admin.story') }}</option>
                <option value="example">{{ __('admin.example') }}</option>
                <option value="summary">{{ __('admin.summary') }}</option>
                <option value="interactive">{{ __('admin.interactive') }}</option>
                <option value="quiz">{{ __('admin.quiz') }}</option>
            </select>
            <button type="button" class="btn-remove-section btn btn-danger" style="margin-left:auto;">{{ __('admin.remove_section') }}</button>
        </div>
        <div class="field">
            <label>{{ __('admin.title') }}</label>
            <input type="text" name="sections[__IDX__][title]" placeholder="{{ __('admin.title') }}">
        </div>
        <div class="section-fields-wrap" data-type="video">
            <div class="field"><label>{{ __('admin.video_url') }}</label><input type="url" name="sections[__IDX__][videoUrl]" placeholder="https://..."></div>
            <div class="field"><label>{{ __('admin.duration') }}</label><input type="text" name="sections[__IDX__][duration]" placeholder="10 دقيقة"></div>
        </div>
    </div>
</template>
