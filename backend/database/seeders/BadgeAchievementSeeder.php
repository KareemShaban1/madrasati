<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeAchievementSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBadges();
        $this->seedAchievements();
    }

    protected function seedBadges(): void
    {
        $badges = [
            ['id' => 'first-lesson', 'name' => 'المتعلم الأول', 'name_en' => 'First Learner', 'category' => 'learning', 'type' => 'lessons_completed', 'value' => 1],
            ['id' => 'five-lessons', 'name' => 'المستكشف', 'name_en' => 'Explorer', 'category' => 'learning', 'type' => 'lessons_completed', 'value' => 5],
            ['id' => 'ten-lessons', 'name' => 'الباحث', 'name_en' => 'Researcher', 'category' => 'learning', 'type' => 'lessons_completed', 'value' => 10],
            ['id' => 'twenty-lessons', 'name' => 'العالم الصغير', 'name_en' => 'Young Scientist', 'category' => 'learning', 'type' => 'lessons_completed', 'value' => 20],
            ['id' => 'streak-3', 'name' => 'نجم الاستمرارية', 'name_en' => 'Streak Star', 'category' => 'streak', 'type' => 'streak_days', 'value' => 3],
            ['id' => 'streak-7', 'name' => 'بطل الأسبوع', 'name_en' => 'Weekly Hero', 'category' => 'streak', 'type' => 'streak_days', 'value' => 7],
            ['id' => 'streak-30', 'name' => 'الملتزم', 'name_en' => 'Committed', 'category' => 'streak', 'type' => 'streak_days', 'value' => 30],
            ['id' => 'first-quiz', 'name' => 'المختبر الأول', 'name_en' => 'First Quizzer', 'category' => 'mastery', 'type' => 'quizzes_passed', 'value' => 1],
            ['id' => 'perfect-quiz', 'name' => 'الإتقان', 'name_en' => 'Perfectionist', 'category' => 'mastery', 'type' => 'perfect_quizzes', 'value' => 1],
            ['id' => 'five-perfect', 'name' => 'الخبير', 'name_en' => 'Expert', 'category' => 'mastery', 'type' => 'perfect_quizzes', 'value' => 5],
            ['id' => 'math-master', 'name' => 'عبقري الرياضيات', 'name_en' => 'Math Genius', 'category' => 'special', 'type' => 'subject_mastery', 'value' => 10, 'subject_id' => 'p6-math'],
            ['id' => 'science-master', 'name' => 'عالم المستقبل', 'name_en' => 'Future Scientist', 'category' => 'special', 'type' => 'subject_mastery', 'value' => 10, 'subject_id' => 'p6-science'],
            ['id' => 'arabic-master', 'name' => 'فارس اللغة', 'name_en' => 'Language Knight', 'category' => 'special', 'type' => 'subject_mastery', 'value' => 10, 'subject_id' => 'p6-arabic'],
            ['id' => 'english-master', 'name' => 'متحدث عالمي', 'name_en' => 'Global Speaker', 'category' => 'special', 'type' => 'subject_mastery', 'value' => 10, 'subject_id' => 'p6-english'],
            ['id' => 'social-master', 'name' => 'مؤرخ صغير', 'name_en' => 'Young Historian', 'category' => 'special', 'type' => 'subject_mastery', 'value' => 10, 'subject_id' => 'p6-social'],
        ];

        foreach ($badges as $b) {
            Badge::updateOrCreate(
                ['id' => $b['id']],
                [
                    'name' => $b['name'],
                    'name_en' => $b['name_en'],
                    'description' => $b['name_en'],
                    'icon' => 'Award',
                    'category' => $b['category'],
                    'requirement_type' => $b['type'],
                    'requirement_value' => $b['value'],
                    'subject_id' => $b['subject_id'] ?? null,
                ]
            );
        }
    }

    protected function seedAchievements(): void
    {
        $achievements = [
            [
                'id' => 'starter-journey',
                'name' => 'بداية الرحلة',
                'description' => 'إكمال 5 دروس في أي مادة.',
                'icon' => 'Flag',
                'max_progress' => 5,
                'xp_reward' => 50,
            ],
            [
                'id' => 'consistent-learner',
                'name' => 'متعلم مستمر',
                'description' => 'تحقيق سلسلة حضور لمدة 7 أيام.',
                'icon' => 'Flame',
                'max_progress' => 7,
                'xp_reward' => 75,
            ],
            [
                'id' => 'quiz-champion',
                'name' => 'بطل الاختبارات',
                'description' => 'إكمال 10 اختبارات بنجاح.',
                'icon' => 'Trophy',
                'max_progress' => 10,
                'xp_reward' => 100,
            ],
        ];

        foreach ($achievements as $a) {
            Achievement::updateOrCreate(
                ['id' => $a['id']],
                [
                    'name' => $a['name'],
                    'description' => $a['description'],
                    'icon' => $a['icon'],
                    'max_progress' => $a['max_progress'],
                    'xp_reward' => $a['xp_reward'],
                ]
            );
        }
    }
}

