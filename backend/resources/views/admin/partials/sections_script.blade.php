@push('scripts')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var list = document.getElementById('sections-list');
    var tpl = document.getElementById('section-row-tpl');
    var btnAdd = document.getElementById('btn-add-section');
    if (!list || !tpl || !btnAdd) return;

    var videoLabel = '{{ __("admin.video_url") }}';
    var durationLabel = '{{ __("admin.duration") }}';
    var contentLabel = '{{ __("admin.content") }}';
    var interactiveIntroLabel = '{{ __("admin.interactive_intro") }}';
    var interactiveItemsLabel = '{{ __("admin.interactive_items") }}';
    var addItemLabel = '{{ __("admin.add_item") }}';
    var removeItemLabel = '{{ __("admin.remove_item") }}';
    var questionPlaceholder = '{{ __("admin.question_text") }}';
    var answerPlaceholder = '{{ __("admin.correct_answer") }}';
    var hintPlaceholder = '{{ __("admin.explanation") }} ({{ __("admin.optional") }})';

    function getNextIndex() {
        var rows = list.querySelectorAll('.section-row');
        var max = -1;
        rows.forEach(function(r) {
            var i = parseInt(r.getAttribute('data-index'), 10);
            if (!isNaN(i) && i > max) max = i;
        });
        return max + 1;
    }

    function reindexSections() {
        var rows = list.querySelectorAll('.section-row');
        rows.forEach(function(row, idx) {
            row.setAttribute('data-index', idx);
            row.querySelectorAll('[name^="sections["]').forEach(function(input) {
                var name = input.getAttribute('name');
                if (!name) return;
                var match = name.match(/^sections\[\d+\](.*)$/);
                if (match) input.setAttribute('name', 'sections[' + idx + ']' + match[1]);
            });
        });
    }

    function getFieldsHtml(type, idx) {
        if (type === 'video') {
            return '<div class="field"><label>' + videoLabel + '</label><input type="url" name="sections[' + idx + '][videoUrl]" placeholder="https://..."></div>' +
                '<div class="field"><label>' + durationLabel + '</label><input type="text" name="sections[' + idx + '][duration]" placeholder="10 دقيقة"></div>';
        }
        if (type === 'interactive') {
            return '<div class="field"><label>' + interactiveIntroLabel + '</label>' +
                '<input type="hidden" name="sections[' + idx + '][content]" id="section-content-' + idx + '">' +
                '<div id="quill-section-' + idx + '" class="section-rich-editor" data-input-id="section-content-' + idx + '" style="min-height:80px; background:var(--input-bg); border:1px solid var(--input-border); border-radius:0.55rem;"></div></div>' +
                '<div class="field"><label>' + interactiveItemsLabel + '</label><div class="interactive-items-list"></div>' +
                '<button type="button" class="btn-add-interactive-item btn btn-secondary" style="margin-top:0.25rem;">' + addItemLabel + '</button></div>';
        }
        if (['text','cartoon','story','example','summary','quiz'].indexOf(type) !== -1) {
            return '<div class="field"><label>' + contentLabel + '</label>' +
                '<input type="hidden" name="sections[' + idx + '][content]" id="section-content-' + idx + '">' +
                '<div id="quill-section-' + idx + '" class="section-rich-editor" data-input-id="section-content-' + idx + '" style="min-height:160px; background:var(--input-bg); border:1px solid var(--input-border); border-radius:0.55rem;"></div></div>';
        }
        return '';
    }

    function initSectionEditor(container) {
        if (!container || container.dataset.quillInited === '1') return;
        var inputId = container.getAttribute('data-input-id');
        var input = inputId ? document.getElementById(inputId) : null;
        if (!input) return;
        container.dataset.quillInited = '1';
        var quill = new Quill(container, {
            theme: 'snow',
            placeholder: contentLabel
        });
        if (input.value) quill.root.innerHTML = input.value;
        quill.on('text-change', function() {
            input.value = quill.root.innerHTML;
        });
    }

    function initAllSectionEditors() {
        document.querySelectorAll('.section-rich-editor').forEach(function(el) {
            if (el.dataset.quillInited !== '1') initSectionEditor(el);
        });
    }

    function addInteractiveItem(row) {
        var wrap = row.querySelector('.section-fields-wrap');
        var idx = row.getAttribute('data-index');
        var itemsList = row.querySelector('.interactive-items-list');
        if (!itemsList) return;
        var count = itemsList.querySelectorAll('.interactive-item-row').length;
        var div = document.createElement('div');
        div.className = 'interactive-item-row';
        div.innerHTML = '<input type="text" name="sections[' + idx + '][items][' + count + '][question]" placeholder="' + questionPlaceholder + '">' +
            '<input type="text" name="sections[' + idx + '][items][' + count + '][answer]" placeholder="' + answerPlaceholder + '">' +
            '<input type="text" name="sections[' + idx + '][items][' + count + '][hint]" placeholder="' + hintPlaceholder + '">' +
            '<button type="button" class="btn-remove-interactive-item btn btn-danger">' + removeItemLabel + '</button>';
        itemsList.appendChild(div);
        bindInteractiveItemRemove(div, row);
    }

    function reindexInteractiveItems(row) {
        var idx = row.getAttribute('data-index');
        var itemsList = row.querySelector('.interactive-items-list');
        if (!itemsList) return;
        var itemRows = itemsList.querySelectorAll('.interactive-item-row');
        itemRows.forEach(function(r, j) {
            r.querySelectorAll('input').forEach(function(inp) {
                var n = inp.getAttribute('name');
                if (!n) return;
                var m = n.match(/^(sections\[\d+\]\[items\])\[\d+\](\[[^\]]+\])$/);
                if (m) inp.setAttribute('name', 'sections[' + idx + '][items][' + j + ']' + m[2]);
            });
        });
    }

    function bindInteractiveItemRemove(itemRow, sectionRow) {
        var btn = itemRow.querySelector('.btn-remove-interactive-item');
        if (btn) btn.addEventListener('click', function() {
            itemRow.remove();
            reindexInteractiveItems(sectionRow);
        });
    }

    function bindInteractiveItems(row) {
        var addBtn = row.querySelector('.btn-add-interactive-item');
        if (addBtn) addBtn.addEventListener('click', function() { addInteractiveItem(row); });
        row.querySelectorAll('.interactive-item-row').forEach(function(r) { bindInteractiveItemRemove(r, row); });
    }

    btnAdd.addEventListener('click', function() {
        var index = getNextIndex();
        var html = tpl.innerHTML.replace(/__IDX__/g, index);
        var wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        list.appendChild(wrap.firstChild);
        reindexSections();
        bindSectionRow(list.lastElementChild);
    });

    function bindSectionRow(row) {
        if (!row) return;
        var removeBtn = row.querySelector('.btn-remove-section');
        if (removeBtn) removeBtn.addEventListener('click', function() {
            row.remove();
            reindexSections();
        });
        var typeSelect = row.querySelector('.section-type-select');
        if (typeSelect) typeSelect.addEventListener('change', function() {
            var wrap = row.querySelector('.section-fields-wrap');
            var idx = row.getAttribute('data-index');
            if (idx === null || idx === '') idx = getNextIndex() - 1;
            wrap.setAttribute('data-type', this.value);
            wrap.innerHTML = getFieldsHtml(this.value, idx);
            if (this.value === 'interactive') bindInteractiveItems(row);
            wrap.querySelectorAll('.section-rich-editor').forEach(function(el) { initSectionEditor(el); });
        });
        var wrap = row.querySelector('.section-fields-wrap');
        if (wrap && wrap.getAttribute('data-type') === 'interactive') bindInteractiveItems(row);
    }

    list.querySelectorAll('.section-row').forEach(function(row) { bindSectionRow(row); });
    initAllSectionEditors();
});
</script>
@endpush
