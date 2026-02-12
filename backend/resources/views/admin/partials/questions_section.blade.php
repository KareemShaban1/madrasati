{{-- Structured Questions section: add/edit questions by type (multiple_choice, true_false). Not shown in JSON view. --}}
@php
    $questions = $questions ?? [];
    if (old('questions') !== null) {
        $questions = old('questions');
    }
@endphp
<div class="questions-section">
    <div class="questions-section-header">
        <h3 class="questions-section-title">{{ __('admin.questions') }}</h3>
        <button type="button" class="btn btn-secondary btn-add-question" id="btn-add-question">{{ __('admin.add_question') }}</button>
    </div>
    <div class="questions-list" id="questions-list">
        @foreach($questions as $idx => $q)
            @php
                $type = is_array($q) ? ($q['type'] ?? 'multiple_choice') : 'multiple_choice';
                $options = is_array($q) && isset($q['options']) ? $q['options'] : (isset($q['options']) ? $q['options'] : ['', '']);
                if (!is_array($options)) $options = ['', ''];
                $correctAnswer = is_array($q) ? (int)($q['correctAnswer'] ?? 0) : 0;
            @endphp
            <div class="question-row" data-index="{{ $idx }}">
                <div class="question-row-head">
                    <label class="question-type-label">{{ __('admin.question_type') }}</label>
                    <select name="questions[{{ $idx }}][type]" class="question-type-select">
                        <option value="multiple_choice" @selected($type === 'multiple_choice')>{{ __('admin.multiple_choice') }}</option>
                        <option value="true_false" @selected($type === 'true_false')>{{ __('admin.true_false') }}</option>
                    </select>
                    <button type="button" class="btn-remove-question btn btn-danger" style="margin-left:auto;">{{ __('admin.remove_question') }}</button>
                </div>
                <div class="field">
                    <label>{{ __('admin.question_text') }}</label>
                    <input type="text" name="questions[{{ $idx }}][question]" value="{{ is_array($q) ? ($q['question'] ?? '') : '' }}" placeholder="{{ __('admin.question_text') }}">
                </div>
                <div class="question-options-wrap" data-type="{{ $type }}">
                    @if($type === 'true_false')
                        <div class="field">
                            <label>{{ __('admin.correct_answer') }}</label>
                            <select name="questions[{{ $idx }}][correctAnswer]">
                                <option value="0" @selected($correctAnswer === 0)>True</option>
                                <option value="1" @selected($correctAnswer === 1)>False</option>
                            </select>
                        </div>
                        <input type="hidden" name="questions[{{ $idx }}][options][0]" value="True">
                        <input type="hidden" name="questions[{{ $idx }}][options][1]" value="False">
                    @else
                        <div class="field">
                            <label>{{ __('admin.option') }} ({{ __('admin.correct_answer') }} = index)</label>
                            <div class="options-list">
                                @foreach($options as $oi => $opt)
                                    <div class="option-item">
                                        <input type="text" name="questions[{{ $idx }}][options][{{ $oi }}]" value="{{ $opt }}" placeholder="{{ __('admin.option') }} {{ $oi + 1 }}">
                                        <label class="option-correct"><input type="radio" name="questions[{{ $idx }}][correctIndex]" value="{{ $oi }}" @checked($correctAnswer === (int)$oi)> {{ __('admin.correct_answer') }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn-add-option btn btn-secondary" style="margin-top:0.25rem;">{{ __('admin.add_option') }}</button>
                        </div>
                    @endif
                </div>
                <div class="field">
                    <label>{{ __('admin.explanation') }} ({{ __('admin.optional') }})</label>
                    <input type="text" name="questions[{{ $idx }}][explanation]" value="{{ is_array($q) ? ($q['explanation'] ?? '') : '' }}" placeholder="{{ __('admin.explanation') }}">
                </div>
            </div>
        @endforeach
    </div>
</div>
<template id="question-row-tpl">
    <div class="question-row" data-index="__IDX__">
        <div class="question-row-head">
            <label class="question-type-label">{{ __('admin.question_type') }}</label>
            <select name="questions[__IDX__][type]" class="question-type-select">
                <option value="multiple_choice">{{ __('admin.multiple_choice') }}</option>
                <option value="true_false">{{ __('admin.true_false') }}</option>
            </select>
            <button type="button" class="btn-remove-question btn btn-danger" style="margin-left:auto;">{{ __('admin.remove_question') }}</button>
        </div>
        <div class="field">
            <label>{{ __('admin.question_text') }}</label>
            <input type="text" name="questions[__IDX__][question]" placeholder="{{ __('admin.question_text') }}">
        </div>
        <div class="question-options-wrap" data-type="multiple_choice">
            <div class="field">
                <label>{{ __('admin.option') }}</label>
                <div class="options-list">
                    <div class="option-item">
                        <input type="text" name="questions[__IDX__][options][0]" placeholder="{{ __('admin.option') }} 1">
                        <label class="option-correct"><input type="radio" name="questions[__IDX__][correctIndex]" value="0"> {{ __('admin.correct_answer') }}</label>
                    </div>
                    <div class="option-item">
                        <input type="text" name="questions[__IDX__][options][1]" placeholder="{{ __('admin.option') }} 2">
                        <label class="option-correct"><input type="radio" name="questions[__IDX__][correctIndex]" value="1"> {{ __('admin.correct_answer') }}</label>
                    </div>
                </div>
                <button type="button" class="btn-add-option btn btn-secondary" style="margin-top:0.25rem;">{{ __('admin.add_option') }}</button>
            </div>
        </div>
        <div class="field">
            <label>{{ __('admin.explanation') }}</label>
            <input type="text" name="questions[__IDX__][explanation]" placeholder="{{ __('admin.explanation') }}">
        </div>
    </div>
</template>
