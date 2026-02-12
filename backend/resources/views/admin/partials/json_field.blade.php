{{-- JSON input field with format button and client-side validation --}}
@props(['name', 'id' => $name, 'label', 'rows' => 10, 'placeholder' => '', 'value' => '', 'hint' => ''])
<div class="field json-field-wrap">
    <label for="{{ $id }}">{{ $label }}</label>
    @if($hint)
        <div class="json-hint">{{ $hint }}</div>
    @endif
    <div class="json-actions">
        <button type="button" class="btn-json-format" data-target="{{ $id }}" aria-label="Format JSON">{{ __('admin.format_json') }}</button>
        <span class="json-status" id="{{ $id }}_status" aria-live="polite"></span>
    </div>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="json-input"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        spellcheck="false"
        data-json-validate
    >{{ old($name, $value) }}</textarea>
    <div class="json-error" id="{{ $id }}_error" role="alert"></div>
</div>
