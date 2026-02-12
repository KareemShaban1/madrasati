<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonContent;
use Illuminate\Http\Request;

class LessonContentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = LessonContent::with('lesson.unit.subject.grade');

        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        if ($request->filled('unit_id')) {
            $query->whereHas('lesson', fn ($q) => $q->where('unit_id', $request->unit_id));
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%")
                    ->orWhere('title_en', 'like', "%{$q}%")
                    ->orWhereHas('lesson', fn ($l) => $l->where('title', 'like', "%{$q}%")->orWhere('title_en', 'like', "%{$q}%"));
            });
        }

        $contents = $query
            ->orderBy('lesson_id')
            ->paginate(15)
            ->withQueryString();

        $lessons = Lesson::with('unit.subject.grade')->orderBy('unit_id')->orderBy('id')->get();
        $units = \App\Models\Unit::with('subject.grade')->orderBy('id')->get();

        return view('admin.lesson_contents.index', compact('contents', 'lessons', 'units'));
    }

    public function create()
    {
        $lessons = Lesson::with('unit.subject.grade')->orderBy('id')->get();

        return view('admin.lesson_contents.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => ['required', 'string', 'exists:lessons,id', 'unique:lesson_contents,lesson_id'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'objectives_text' => ['nullable', 'string'],
            'key_points_text' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*.type' => ['nullable', 'string', 'in:video,text,cartoon,story,example,summary,interactive,quiz'],
            'sections.*.title' => ['nullable', 'string', 'max:500'],
            'sections.*.videoUrl' => ['nullable', 'string', 'max:1000'],
            'sections.*.duration' => ['nullable', 'string', 'max:100'],
            'sections.*.content' => ['nullable', 'string'],
            'sections.*.items' => ['nullable', 'array'],
            'sections.*.items.*.question' => ['nullable', 'string', 'max:1000'],
            'sections.*.items.*.answer' => ['nullable', 'string', 'max:500'],
            'sections.*.items.*.hint' => ['nullable', 'string', 'max:500'],
            'questions' => ['nullable', 'array'],
            'questions.*.type' => ['nullable', 'string', 'in:multiple_choice,true_false'],
            'questions.*.question' => ['nullable', 'string'],
            'questions.*.options' => ['nullable', 'array'],
            'questions.*.options.*' => ['nullable', 'string'],
            'questions.*.correctAnswer' => ['nullable', 'integer', 'min:0'],
            'questions.*.correctIndex' => ['nullable', 'integer', 'min:0'],
            'questions.*.explanation' => ['nullable', 'string'],
            'prev_lesson_id' => ['nullable', 'string', 'max:100'],
            'next_lesson_id' => ['nullable', 'string', 'max:100'],
        ]);

        $quickQuiz = $this->buildQuickQuizFromQuestions($data['questions'] ?? []);
        $sections = $this->buildSectionsFromRequest($data['sections'] ?? []);

        LessonContent::create([
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'title_en' => $data['title_en'],
            'objectives' => $this->splitLines($data['objectives_text'] ?? ''),
            'key_points' => $this->splitLines($data['key_points_text'] ?? ''),
            'sections' => $sections,
            'quick_quiz' => $quickQuiz,
            'prev_lesson_id' => $data['prev_lesson_id'] ?? null,
            'next_lesson_id' => $data['next_lesson_id'] ?? null,
        ]);

        return redirect()->route('admin.lesson-contents.index')->with('status', 'Lesson content created.');
    }

    public function edit(LessonContent $lesson_content)
    {
        $lessons = Lesson::with('unit.subject.grade')->orderBy('id')->get();

        $objectivesText = $lesson_content->objectives ? implode(PHP_EOL, $lesson_content->objectives) : '';
        $keyPointsText = $lesson_content->key_points ? implode(PHP_EOL, $lesson_content->key_points) : '';
        $sections = $this->normalizeSectionsForEdit($lesson_content->sections);
        $questions = $this->normalizeQuickQuizToQuestions($lesson_content->quick_quiz);

        return view('admin.lesson_contents.edit', [
            'lessons' => $lessons,
            'content' => $lesson_content,
            'objectivesText' => $objectivesText,
            'keyPointsText' => $keyPointsText,
            'sections' => $sections,
            'questions' => $questions,
        ]);
    }

    public function update(Request $request, LessonContent $lesson_content)
    {
        $data = $request->validate([
            'lesson_id' => ['required', 'string', 'exists:lessons,id', 'unique:lesson_contents,lesson_id,'.$lesson_content->id],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'objectives_text' => ['nullable', 'string'],
            'key_points_text' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*.type' => ['nullable', 'string', 'in:video,text,cartoon,story,example,summary,interactive,quiz'],
            'sections.*.title' => ['nullable', 'string', 'max:500'],
            'sections.*.videoUrl' => ['nullable', 'string', 'max:1000'],
            'sections.*.duration' => ['nullable', 'string', 'max:100'],
            'sections.*.content' => ['nullable', 'string'],
            'sections.*.items' => ['nullable', 'array'],
            'sections.*.items.*.question' => ['nullable', 'string', 'max:1000'],
            'sections.*.items.*.answer' => ['nullable', 'string', 'max:500'],
            'sections.*.items.*.hint' => ['nullable', 'string', 'max:500'],
            'questions' => ['nullable', 'array'],
            'questions.*.type' => ['nullable', 'string', 'in:multiple_choice,true_false'],
            'questions.*.question' => ['nullable', 'string'],
            'questions.*.options' => ['nullable', 'array'],
            'questions.*.options.*' => ['nullable', 'string'],
            'questions.*.correctAnswer' => ['nullable', 'integer', 'min:0'],
            'questions.*.correctIndex' => ['nullable', 'integer', 'min:0'],
            'questions.*.explanation' => ['nullable', 'string'],
            'prev_lesson_id' => ['nullable', 'string', 'max:100'],
            'next_lesson_id' => ['nullable', 'string', 'max:100'],
        ]);

        $quickQuiz = $this->buildQuickQuizFromQuestions($data['questions'] ?? []);
        $sections = $this->buildSectionsFromRequest($data['sections'] ?? []);

        $lesson_content->update([
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'title_en' => $data['title_en'],
            'objectives' => $this->splitLines($data['objectives_text'] ?? ''),
            'key_points' => $this->splitLines($data['key_points_text'] ?? ''),
            'sections' => $sections,
            'quick_quiz' => $quickQuiz,
            'prev_lesson_id' => $data['prev_lesson_id'] ?? null,
            'next_lesson_id' => $data['next_lesson_id'] ?? null,
        ]);

        return redirect()->route('admin.lesson-contents.index')->with('status', 'Lesson content updated.');
    }

    public function destroy(LessonContent $lesson_content)
    {
        $lesson_content->delete();

        return redirect()->route('admin.lesson-contents.index')->with('status', 'Lesson content deleted.');
    }

    private function splitLines(string $value): ?array
    {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));

        return $lines ?: null;
    }

    private function decodeJsonOrNull(string $value): ?array
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        $decoded = json_decode($trimmed, true);

        return is_array($decoded) ? $decoded : null;
    }

    /** Build quick_quiz JSON array from form questions (multiple_choice / true_false). */
    private function buildQuickQuizFromQuestions(array $questions): ?array
    {
        $out = [];
        $index = 0;
        foreach ($questions as $q) {
            $question = trim($q['question'] ?? '');
            if ($question === '') {
                continue;
            }
            $type = $q['type'] ?? 'multiple_choice';
            $options = $q['options'] ?? [];
            if (! is_array($options)) {
                $options = [];
            }
            $options = array_values(array_filter(array_map('trim', $options)));
            $correctAnswer = (int) ($q['correctAnswer'] ?? $q['correctIndex'] ?? 0);
            if ($type === 'true_false') {
                $options = ['True', 'False'];
                $correctAnswer = min(1, max(0, $correctAnswer));
            } else {
                if (count($options) < 2) {
                    $options = ['', ''];
                }
                $correctAnswer = min(max(0, $correctAnswer), count($options) - 1);
            }
            $index++;
            $out[] = [
                'id' => 'q'.$index,
                'question' => $question,
                'options' => $options,
                'correctAnswer' => $correctAnswer,
                'explanation' => trim($q['explanation'] ?? '') ?: null,
            ];
        }

        return $out ?: null;
    }

    /** Normalize quick_quiz (API shape) to form shape for edit view. */
    private function normalizeQuickQuizToQuestions(?array $quickQuiz): array
    {
        if (! $quickQuiz || ! is_array($quickQuiz)) {
            return [];
        }
        $questions = [];
        foreach ($quickQuiz as $item) {
            if (! is_array($item)) {
                continue;
            }
            $options = $item['options'] ?? [];
            $isTrueFalse = is_array($options) && count($options) === 2
                && in_array('True', $options, true) && in_array('False', $options, true);
            $questions[] = [
                'type' => $isTrueFalse ? 'true_false' : 'multiple_choice',
                'question' => $item['question'] ?? '',
                'options' => is_array($options) ? $options : [],
                'correctAnswer' => (int) ($item['correctAnswer'] ?? 0),
                'explanation' => $item['explanation'] ?? '',
            ];
        }

        return $questions;
    }

    /** Build sections JSON array from form sections (video / text / cartoon / story / interactive / etc). */
    private function buildSectionsFromRequest(array $sections): ?array
    {
        $out = [];
        $sectionIndex = 0;
        foreach ($sections as $sec) {
            if (! is_array($sec)) {
                continue;
            }
            $type = $sec['type'] ?? 'video';
            $title = trim($sec['title'] ?? '');
            if ($title === '') {
                continue;
            }
            $sectionIndex++;
            $item = ['id' => 's'.$sectionIndex, 'type' => $type, 'title' => $title];
            if ($type === 'video') {
                $item['videoUrl'] = trim($sec['videoUrl'] ?? '') ?: null;
                $item['duration'] = trim($sec['duration'] ?? '') ?: null;
            } elseif ($type === 'interactive') {
                $content = trim($sec['content'] ?? '');
                if ($content !== '') {
                    $item['content'] = $content;
                }
                $rawItems = $sec['items'] ?? [];
                $items = [];
                $itemIndex = 0;
                foreach (is_array($rawItems) ? $rawItems : [] as $it) {
                    if (! is_array($it)) {
                        continue;
                    }
                    $q = trim($it['question'] ?? '');
                    if ($q === '') {
                        continue;
                    }
                    $itemIndex++;
                    $items[] = [
                        'id' => 'i'.$sectionIndex.'-'.$itemIndex,
                        'question' => $q,
                        'answer' => trim($it['answer'] ?? ''),
                        'hint' => trim($it['hint'] ?? '') ?: null,
                    ];
                }
                if (count($items) > 0) {
                    $item['items'] = $items;
                }
            } elseif (in_array($type, ['text', 'cartoon', 'story', 'example', 'summary', 'quiz'], true)) {
                $content = trim($sec['content'] ?? '');
                if ($content !== '') {
                    $item['content'] = $content;
                }
            }
            $out[] = $item;
        }

        return $out ?: null;
    }

    /** Normalize sections (API shape) to form shape for edit view. */
    private function normalizeSectionsForEdit(?array $sections): array
    {
        if (! $sections || ! is_array($sections)) {
            return [];
        }
        $list = [];
        foreach ($sections as $item) {
            if (! is_array($item)) {
                continue;
            }
            $row = [
                'type' => $item['type'] ?? 'video',
                'title' => $item['title'] ?? '',
                'videoUrl' => $item['videoUrl'] ?? '',
                'duration' => $item['duration'] ?? '',
                'content' => $item['content'] ?? '',
            ];
            if (isset($item['items']) && is_array($item['items'])) {
                $row['items'] = array_map(function ($it) {
                    return [
                        'question' => $it['question'] ?? '',
                        'answer' => $it['answer'] ?? '',
                        'hint' => $it['hint'] ?? '',
                    ];
                }, $item['items']);
            }
            $list[] = $row;
        }

        return $list;
    }
}

