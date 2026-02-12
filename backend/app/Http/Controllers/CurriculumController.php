<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\LessonContent;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /** Stage display options not stored in DB (for public curriculum) */
    private const STAGE_DISPLAY = [
        'primary' => ['ageRange' => '٦ - ١٢ سنة', 'colorClass' => 'gradient-hero'],
        'preparatory' => ['ageRange' => '١٢ - ١٥ سنة', 'colorClass' => 'gradient-secondary'],
        'secondary' => ['ageRange' => '١٥ - ١٨ سنة', 'colorClass' => 'gradient-accent'],
    ];

    /**
     * Public full curriculum tree (no auth). Uses codes as ids for frontend routing.
     */
    public function publicCurriculum()
    {
        $stages = Stage::with(['grades.subjects.units.lessons'])->orderBy('id')->get();

        return $stages->map(function (Stage $stage) {
            $display = self::STAGE_DISPLAY[$stage->code] ?? ['ageRange' => '', 'colorClass' => 'gradient-hero'];
            return [
                'id' => $stage->code,
                'name' => $stage->name,
                'nameEn' => $stage->name_en,
                'description' => $stage->description,
                'ageRange' => $display['ageRange'],
                'colorClass' => $display['colorClass'],
                'grades' => $stage->grades->sortBy('id')->values()->map(function (Grade $grade) {
                    return [
                        'id' => $grade->code,
                        'name' => $grade->name,
                        'nameEn' => $grade->name_en,
                        'order' => $grade->id,
                        'subjects' => $grade->subjects->sortBy('id')->values()->map(function (Subject $subject) {
                            $units = $subject->units->sortBy('id')->values();
                            $totalLessons = $units->sum(fn ($u) => $u->lessons->count());
                            return [
                                'id' => $subject->code,
                                'name' => $subject->name,
                                'nameEn' => $subject->name_en,
                                'icon' => $subject->icon ?? 'BookOpen',
                                'color' => $subject->color ?? 'hsl(220 80% 55%)',
                                'colorClass' => 'primary',
                                'description' => $units->first()?->description ?? '',
                                'units' => $units->map(function (Unit $unit, $idx) {
                                    return [
                                        'id' => $unit->code,
                                        'title' => $unit->name,
                                        'titleEn' => $unit->name_en,
                                        'description' => $unit->description,
                                        'order' => $idx + 1,
                                        'lessons' => $unit->lessons->sortBy('id')->values()->map(function (Lesson $lesson, $lidx) {
                                            return [
                                                'id' => $lesson->code,
                                                'title' => $lesson->title,
                                                'titleEn' => $lesson->title_en,
                                                'duration' => $lesson->duration ?? '30 دقيقة',
                                                'status' => $lidx === 0 ? 'in-progress' : 'locked',
                                                'order' => $lidx + 1,
                                            ];
                                        })->values()->all(),
                                    ];
                                })->values()->all(),
                                'exercises' => [],
                                'progress' => [
                                    'overallPercent' => 0,
                                    'lessonsCompleted' => 0,
                                    'totalLessons' => $totalLessons,
                                    'exercisesCompleted' => 0,
                                    'totalExercises' => 0,
                                    'averageScore' => 0,
                                    'streak' => 0,
                                    'timeSpent' => '0 ساعة',
                                ],
                            ];
                        })->values()->all(),
                    ];
                })->values()->all(),
            ];
        })->values()->all();
    }

    /**
     * Public lesson content by subject code + lesson code (no auth).
     */
    public function publicLessonContent(Request $request)
    {
        $subjectCode = $request->query('subject_code');
        $lessonCode = $request->query('lesson_code');
        if (! $subjectCode || ! $lessonCode) {
            return response()->json(['message' => 'subject_code and lesson_code required'], 400);
        }

        $subject = Subject::where('code', $subjectCode)->first();
        if (! $subject) {
            return response()->json(null);
        }
        $unitIds = $subject->units()->pluck('id');
        $lesson = Lesson::whereIn('unit_id', $unitIds)->where('code', $lessonCode)->first();
        if (! $lesson) {
            return response()->json(null);
        }

        $content = LessonContent::where('lesson_id', $lesson->id)->first();
        if (! $content) {
            return response()->json(null);
        }

        return [
            'lessonId' => $lesson->code,
            'subjectId' => $subject->code,
            'title' => $content->title,
            'title_en' => $content->title_en,
            'objectives' => $content->objectives,
            'sections' => $content->sections,
            'quickQuiz' => $content->quick_quiz,
            'keyPoints' => $content->key_points,
            'prevLessonId' => $content->prev_lesson_id,
            'nextLessonId' => $content->next_lesson_id,
        ];
    }
    public function stages()
    {
        return Stage::all();
    }

    public function stage(string $id)
    {
        return Stage::with('grades')->findOrFail($id);
    }

    public function stageGrades(string $id)
    {
        $stage = Stage::findOrFail($id);

        return $stage->grades;
    }

    public function grade(string $id)
    {
        return Grade::with('subjects')->findOrFail($id);
    }

    public function gradeSubjects(string $id)
    {
        $grade = Grade::findOrFail($id);

        return $grade->subjects;
    }

    public function subject(string $id)
    {
        return Subject::with('units')->findOrFail($id);
    }

    public function subjectUnits(string $id)
    {
        $subject = Subject::findOrFail($id);

        return $subject->units;
    }

    public function unit(string $id)
    {
        return Unit::with('lessons')->findOrFail($id);
    }

    public function unitLessons(string $id)
    {
        $unit = Unit::findOrFail($id);

        return $unit->lessons;
    }

    public function lesson(string $id)
    {
        return Lesson::findOrFail($id);
    }

    public function lessonContent(string $id)
    {
        $lesson = Lesson::findOrFail($id);

        return LessonContent::where('lesson_id', $lesson->id)->firstOrFail();
    }
}

