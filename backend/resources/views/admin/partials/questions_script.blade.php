@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var list = document.getElementById('questions-list');
    var tpl = document.getElementById('question-row-tpl');
    var btnAdd = document.getElementById('btn-add-question');
    if (!list || !tpl || !btnAdd) return;

    function getNextIndex() {
        var rows = list.querySelectorAll('.question-row');
        var max = -1;
        rows.forEach(function(r) {
            var i = parseInt(r.getAttribute('data-index'), 10);
            if (!isNaN(i) && i > max) max = i;
        });
        return max + 1;
    }

    function reindexQuestions() {
        var rows = list.querySelectorAll('.question-row');
        rows.forEach(function(row, idx) {
            row.setAttribute('data-index', idx);
            row.querySelectorAll('[name^="questions["]').forEach(function(input) {
                var name = input.getAttribute('name');
                if (!name) return;
                var match = name.match(/^questions\[\d+\](.*)$/);
                if (match) input.setAttribute('name', 'questions[' + idx + ']' + match[1]);
            });
        });
    }

    btnAdd.addEventListener('click', function() {
        var index = getNextIndex();
        var html = tpl.innerHTML.replace(/__IDX__/g, index);
        var wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        list.appendChild(wrap.firstChild);
        reindexQuestions();
        bindRow(list.lastElementChild);
    });

    function bindRow(row) {
        if (!row) return;
        var removeBtn = row.querySelector('.btn-remove-question');
        if (removeBtn) removeBtn.addEventListener('click', function() {
            row.remove();
            reindexQuestions();
        });
        var typeSelect = row.querySelector('.question-type-select');
        if (typeSelect) typeSelect.addEventListener('change', function() {
            var wrap = row.querySelector('.question-options-wrap');
            var idx = row.getAttribute('data-index');
            if (idx === null || idx === '') idx = getNextIndex() - 1;
            if (this.value === 'true_false') {
                wrap.setAttribute('data-type', 'true_false');
                wrap.innerHTML = '<div class="field"><label>{{ __("admin.correct_answer") }}</label><select name="questions[' + idx + '][correctAnswer]"><option value="0">True</option><option value="1">False</option></select></div><input type="hidden" name="questions[' + idx + '][options][0]" value="True"><input type="hidden" name="questions[' + idx + '][options][1]" value="False">';
            } else {
                wrap.setAttribute('data-type', 'multiple_choice');
                wrap.innerHTML = '<div class="field"><label>{{ __("admin.option") }}</label><div class="options-list"><div class="option-item"><input type="text" name="questions[' + idx + '][options][0]" placeholder="{{ __("admin.option") }} 1"><label class="option-correct"><input type="radio" name="questions[' + idx + '][correctIndex]" value="0"> {{ __("admin.correct_answer") }}</label></div><div class="option-item"><input type="text" name="questions[' + idx + '][options][1]" placeholder="{{ __("admin.option") }} 2"><label class="option-correct"><input type="radio" name="questions[' + idx + '][correctIndex]" value="1"> {{ __("admin.correct_answer") }}</label></div></div><button type="button" class="btn-add-option btn btn-secondary" style="margin-top:0.25rem;">{{ __("admin.add_option") }}</button></div>';
                var addOptBtn = wrap.querySelector('.btn-add-option');
                if (addOptBtn) addOptBtn.addEventListener('click', function() { addOption(row); });
            }
        });
        var addOptBtn = row.querySelector('.btn-add-option');
        if (addOptBtn) addOptBtn.addEventListener('click', function() { addOption(row); });
    }

    function addOption(row) {
        var wrap = row.querySelector('.question-options-wrap');
        if (wrap.getAttribute('data-type') === 'true_false') return;
        var optionsList = row.querySelector('.options-list');
        if (!optionsList) return;
        var idx = row.getAttribute('data-index');
        var count = optionsList.querySelectorAll('.option-item').length;
        var div = document.createElement('div');
        div.className = 'option-item';
        div.innerHTML = '<input type="text" name="questions[' + idx + '][options][' + count + ']" placeholder="{{ __("admin.option") }} ' + (count + 1) + '"><label class="option-correct"><input type="radio" name="questions[' + idx + '][correctIndex]" value="' + count + '"> {{ __("admin.correct_answer") }}</label>';
        optionsList.appendChild(div);
    }

    list.querySelectorAll('.question-row').forEach(function(row) { bindRow(row); });
});
</script>
@endpush
