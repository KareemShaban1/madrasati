<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPrimary();
        $this->seedPreparatory();
        $this->seedSecondary();
    }

    protected function seedPrimary(): void
    {
        $stage = Stage::updateOrCreate(
            ['code' => 'primary'],
            [
                'code' => 'primary',
                'name' => 'المرحلة الابتدائية',
                'name_en' => 'Primary School',
                'description' => 'تأسيس قوي للمهارات الأساسية في القراءة والكتابة والحساب',
            ]
        );

        $grades = [
            ['id' => 'primary-1', 'name' => 'الصف الأول الابتدائي', 'name_en' => 'Grade 1'],
            ['id' => 'primary-2', 'name' => 'الصف الثاني الابتدائي', 'name_en' => 'Grade 2'],
            ['id' => 'primary-3', 'name' => 'الصف الثالث الابتدائي', 'name_en' => 'Grade 3'],
            ['id' => 'primary-4', 'name' => 'الصف الرابع الابتدائي', 'name_en' => 'Grade 4'],
            ['id' => 'primary-5', 'name' => 'الصف الخامس الابتدائي', 'name_en' => 'Grade 5'],
            ['id' => 'primary-6', 'name' => 'الصف السادس الابتدائي', 'name_en' => 'Grade 6'],
        ];

        $primaryMathUnits = [
            [
                'id' => 'numbers-operations',
                'name' => 'الأعداد والعمليات الحسابية',
                'name_en' => 'Numbers and Operations',
                'description' => 'تعلم الأعداد والجمع والطرح والضرب والقسمة',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الأعداد من 1 إلى 100', 'title_en' => 'Numbers 1 to 100'],
                    ['id' => 'lesson-2', 'title' => 'الجمع والطرح', 'title_en' => 'Addition and Subtraction'],
                    ['id' => 'lesson-3', 'title' => 'جدول الضرب', 'title_en' => 'Multiplication Table'],
                    ['id' => 'lesson-4', 'title' => 'القسمة البسيطة', 'title_en' => 'Simple Division'],
                ],
            ],
            [
                'id' => 'geometry-basics',
                'name' => 'الأشكال الهندسية',
                'name_en' => 'Basic Geometry',
                'description' => 'التعرف على الأشكال الهندسية وخصائصها',
                'lessons' => [
                    ['id' => 'lesson-5', 'title' => 'المربع والمستطيل', 'title_en' => 'Square and Rectangle'],
                    ['id' => 'lesson-6', 'title' => 'الدائرة والمثلث', 'title_en' => 'Circle and Triangle'],
                    ['id' => 'lesson-7', 'title' => 'المحيط والمساحة', 'title_en' => 'Perimeter and Area'],
                ],
            ],
        ];

        $primaryArabicUnits = [
            [
                'id' => 'reading-writing',
                'name' => 'القراءة والكتابة',
                'name_en' => 'Reading and Writing',
                'description' => 'تعلم الحروف والكلمات والجمل',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الحروف الأبجدية', 'title_en' => 'Arabic Alphabet'],
                    ['id' => 'lesson-2', 'title' => 'الحركات والتنوين', 'title_en' => 'Vowels and Tanween'],
                    ['id' => 'lesson-3', 'title' => 'تكوين الكلمات', 'title_en' => 'Word Formation'],
                    ['id' => 'lesson-4', 'title' => 'الجملة الاسمية', 'title_en' => 'Nominal Sentence'],
                ],
            ],
            [
                'id' => 'grammar-basics',
                'name' => 'أساسيات النحو',
                'name_en' => 'Grammar Basics',
                'description' => 'قواعد اللغة العربية الأساسية',
                'lessons' => [
                    ['id' => 'lesson-5', 'title' => 'المبتدأ والخبر', 'title_en' => 'Subject and Predicate'],
                    ['id' => 'lesson-6', 'title' => 'الفعل والفاعل', 'title_en' => 'Verb and Subject'],
                    ['id' => 'lesson-7', 'title' => 'الاسم والفعل والحرف', 'title_en' => 'Noun, Verb, and Particle'],
                ],
            ],
        ];

        $primaryScienceUnits = [
            [
                'id' => 'living-things',
                'name' => 'الكائنات الحية',
                'name_en' => 'Living Things',
                'description' => 'دراسة النباتات والحيوانات',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'أجزاء النبات', 'title_en' => 'Parts of a Plant'],
                    ['id' => 'lesson-2', 'title' => 'دورة حياة النبات', 'title_en' => 'Plant Life Cycle'],
                    ['id' => 'lesson-3', 'title' => 'تصنيف الحيوانات', 'title_en' => 'Animal Classification'],
                ],
            ],
            [
                'id' => 'our-universe',
                'name' => 'الكون من حولنا',
                'name_en' => 'Our Universe',
                'description' => 'استكشاف الأرض والفضاء',
                'lessons' => [
                    ['id' => 'lesson-4', 'title' => 'كوكب الأرض', 'title_en' => 'Planet Earth'],
                    ['id' => 'lesson-5', 'title' => 'الشمس والقمر', 'title_en' => 'Sun and Moon'],
                    ['id' => 'lesson-6', 'title' => 'النظام الشمسي', 'title_en' => 'Solar System'],
                ],
            ],
        ];

        $primaryEnglishUnits = [
            [
                'id' => 'alphabet-phonics',
                'name' => 'الحروف والأصوات',
                'name_en' => 'Alphabet and Phonics',
                'description' => 'تعلم الحروف الإنجليزية ونطقها',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الحروف A-M', 'title_en' => 'Letters A-M'],
                    ['id' => 'lesson-2', 'title' => 'الحروف N-Z', 'title_en' => 'Letters N-Z'],
                    ['id' => 'lesson-3', 'title' => 'الأصوات القصيرة', 'title_en' => 'Short Vowels'],
                    ['id' => 'lesson-4', 'title' => 'الأصوات الطويلة', 'title_en' => 'Long Vowels'],
                ],
            ],
            [
                'id' => 'vocabulary-basics',
                'name' => 'المفردات الأساسية',
                'name_en' => 'Basic Vocabulary',
                'description' => 'كلمات وعبارات يومية',
                'lessons' => [
                    ['id' => 'lesson-5', 'title' => 'الألوان والأرقام', 'title_en' => 'Colors and Numbers'],
                    ['id' => 'lesson-6', 'title' => 'العائلة والأصدقاء', 'title_en' => 'Family and Friends'],
                    ['id' => 'lesson-7', 'title' => 'الطعام والشراب', 'title_en' => 'Food and Drinks'],
                ],
            ],
        ];

        foreach ($grades as $gradeData) {
            $grade = Grade::updateOrCreate(
                ['code' => $gradeData['id']],
                [
                    'stage_id' => $stage->id,
                    'code' => $gradeData['id'],
                    'name' => $gradeData['name'],
                    'name_en' => $gradeData['name_en'],
                ]
            );

            $subjects = [
                [
                    'code' => str_replace('primary-', 'p', $grade->code).'-math',
                    'name' => 'الرياضيات',
                    'name_en' => 'Mathematics',
                    'icon' => 'Calculator',
                    'color' => 'hsl(38 92% 50%)',
                    'units' => $primaryMathUnits,
                ],
                [
                    'code' => str_replace('primary-', 'p', $grade->code).'-arabic',
                    'name' => 'اللغة العربية',
                    'name_en' => 'Arabic Language',
                    'icon' => 'BookText',
                    'color' => 'hsl(175 45% 40%)',
                    'units' => $primaryArabicUnits,
                ],
                [
                    'code' => str_replace('primary-', 'p', $grade->code).'-english',
                    'name' => 'اللغة الإنجليزية',
                    'name_en' => 'English Language',
                    'icon' => 'Languages',
                    'color' => 'hsl(220 80% 55%)',
                    'units' => $primaryEnglishUnits,
                ],
                [
                    'code' => str_replace('primary-', 'p', $grade->code).'-science',
                    'name' => 'العلوم',
                    'name_en' => 'Science',
                    'icon' => 'Beaker',
                    'color' => 'hsl(15 85% 60%)',
                    'units' => $primaryScienceUnits,
                ],
            ];

            foreach ($subjects as $subjectData) {
                $subject = Subject::updateOrCreate(
                    ['code' => $subjectData['code']],
                    [
                        'grade_id' => $grade->id,
                        'code' => $subjectData['code'],
                        'name' => $subjectData['name'],
                        'name_en' => $subjectData['name_en'],
                        'icon' => $subjectData['icon'],
                        'color' => $subjectData['color'],
                    ]
                );

                foreach ($subjectData['units'] as $unitData) {
                    $unit = Unit::updateOrCreate(
                        ['code' => $unitData['id'], 'subject_id' => $subject->id],
                        [
                            'code' => $unitData['id'],
                            'name' => $unitData['name'],
                            'name_en' => $unitData['name_en'],
                            'description' => $unitData['description'],
                        ]
                    );

                    foreach ($unitData['lessons'] as $lessonData) {
                        Lesson::updateOrCreate(
                            ['code' => $lessonData['id'], 'unit_id' => $unit->id],
                            [
                                'code' => $lessonData['id'],
                                'title' => $lessonData['title'],
                                'title_en' => $lessonData['title_en'],
                                'duration' => '30 دقيقة',
                                'type' => 'video',
                            ]
                        );
                    }
                }
            }
        }
    }

    protected function seedPreparatory(): void
    {
        $stage = Stage::updateOrCreate(
            ['code' => 'preparatory'],
            [
                'code' => 'preparatory',
                'name' => 'المرحلة الإعدادية',
                'name_en' => 'Preparatory School',
                'description' => 'تطوير مهارات التفكير النقدي والعلمي',
            ]
        );

        $grades = [
            ['id' => 'prep-1', 'name' => 'الصف الأول الإعدادي', 'name_en' => 'Grade 7'],
            ['id' => 'prep-2', 'name' => 'الصف الثاني الإعدادي', 'name_en' => 'Grade 8'],
            ['id' => 'prep-3', 'name' => 'الصف الثالث الإعدادي', 'name_en' => 'Grade 9'],
        ];

        $prepMathUnits = [
            [
                'id' => 'algebra',
                'name' => 'الجبر',
                'name_en' => 'Algebra',
                'description' => 'المعادلات والمتباينات والدوال',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'المتغيرات والتعبيرات الجبرية', 'title_en' => 'Variables and Expressions'],
                    ['id' => 'lesson-2', 'title' => 'حل المعادلات الخطية', 'title_en' => 'Solving Linear Equations'],
                    ['id' => 'lesson-3', 'title' => 'المتباينات', 'title_en' => 'Inequalities'],
                    ['id' => 'lesson-4', 'title' => 'نظام المعادلات', 'title_en' => 'Systems of Equations'],
                ],
            ],
            [
                'id' => 'geometry',
                'name' => 'الهندسة',
                'name_en' => 'Geometry',
                'description' => 'الأشكال والمساحات والحجوم',
                'lessons' => [
                    ['id' => 'lesson-5', 'title' => 'المثلثات وخصائصها', 'title_en' => 'Triangles and Properties'],
                    ['id' => 'lesson-6', 'title' => 'الدائرة ومحيطها', 'title_en' => 'Circle and Circumference'],
                    ['id' => 'lesson-7', 'title' => 'المجسمات', 'title_en' => '3D Shapes'],
                    ['id' => 'lesson-8', 'title' => 'حساب الحجوم', 'title_en' => 'Volume Calculation'],
                ],
            ],
        ];

        $prepScienceUnits = [
            [
                'id' => 'physics-intro',
                'name' => 'مقدمة في الفيزياء',
                'name_en' => 'Introduction to Physics',
                'description' => 'الحركة والقوى والطاقة',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الحركة والسرعة', 'title_en' => 'Motion and Speed'],
                    ['id' => 'lesson-2', 'title' => 'القوة والكتلة', 'title_en' => 'Force and Mass'],
                    ['id' => 'lesson-3', 'title' => 'الطاقة وأشكالها', 'title_en' => 'Energy Forms'],
                    ['id' => 'lesson-4', 'title' => 'الشغل والقدرة', 'title_en' => 'Work and Power'],
                ],
            ],
        ];

        $prepArabicUnits = [
            [
                'id' => 'grammar-advanced',
                'name' => 'النحو المتقدم',
                'name_en' => 'Advanced Grammar',
                'description' => 'قواعد النحو العربي',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الإعراب والبناء', 'title_en' => 'Parsing and Structure'],
                    ['id' => 'lesson-2', 'title' => 'المنصوبات', 'title_en' => 'Accusative Cases'],
                    ['id' => 'lesson-3', 'title' => 'المجرورات', 'title_en' => 'Genitive Cases'],
                ],
            ],
        ];

        $prepEnglishUnits = [
            [
                'id' => 'grammar-intermediate',
                'name' => 'القواعد المتوسطة',
                'name_en' => 'Intermediate Grammar',
                'description' => 'قواعد اللغة الإنجليزية',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الأزمنة المختلفة', 'title_en' => 'Verb Tenses'],
                    ['id' => 'lesson-2', 'title' => 'الجمل الشرطية', 'title_en' => 'Conditional Sentences'],
                    ['id' => 'lesson-3', 'title' => 'المبني للمجهول', 'title_en' => 'Passive Voice'],
                ],
            ],
        ];

        $prepSocialUnits = [
            [
                'id' => 'egypt-history',
                'name' => 'تاريخ مصر',
                'name_en' => 'Egyptian History',
                'description' => 'تاريخ مصر عبر العصور',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'مصر الفرعونية', 'title_en' => 'Ancient Egypt'],
                    ['id' => 'lesson-2', 'title' => 'مصر الإسلامية', 'title_en' => 'Islamic Egypt'],
                    ['id' => 'lesson-3', 'title' => 'مصر الحديثة', 'title_en' => 'Modern Egypt'],
                ],
            ],
        ];

        foreach ($grades as $gradeData) {
            $grade = Grade::updateOrCreate(
                ['code' => $gradeData['id']],
                [
                    'stage_id' => $stage->id,
                    'code' => $gradeData['id'],
                    'name' => $gradeData['name'],
                    'name_en' => $gradeData['name_en'],
                ]
            );

            $subjects = [
                [
                    'code' => str_replace('prep-', 'pr', $grade->code).'-math',
                    'name' => 'الرياضيات',
                    'name_en' => 'Mathematics',
                    'icon' => 'Calculator',
                    'color' => 'hsl(38 92% 50%)',
                    'units' => $prepMathUnits,
                ],
                [
                    'code' => str_replace('prep-', 'pr', $grade->code).'-arabic',
                    'name' => 'اللغة العربية',
                    'name_en' => 'Arabic Language',
                    'icon' => 'BookText',
                    'color' => 'hsl(175 45% 40%)',
                    'units' => $prepArabicUnits,
                ],
                [
                    'code' => str_replace('prep-', 'pr', $grade->code).'-english',
                    'name' => 'اللغة الإنجليزية',
                    'name_en' => 'English Language',
                    'icon' => 'Languages',
                    'color' => 'hsl(220 80% 55%)',
                    'units' => $prepEnglishUnits,
                ],
                [
                    'code' => str_replace('prep-', 'pr', $grade->code).'-science',
                    'name' => 'العلوم',
                    'name_en' => 'Science',
                    'icon' => 'Beaker',
                    'color' => 'hsl(15 85% 60%)',
                    'units' => $prepScienceUnits,
                ],
                [
                    'code' => str_replace('prep-', 'pr', $grade->code).'-social',
                    'name' => 'الدراسات الاجتماعية',
                    'name_en' => 'Social Studies',
                    'icon' => 'Globe2',
                    'color' => 'hsl(280 60% 50%)',
                    'units' => $prepSocialUnits,
                ],
            ];

            foreach ($subjects as $subjectData) {
                $subject = Subject::updateOrCreate(
                    ['code' => $subjectData['code']],
                    [
                        'grade_id' => $grade->id,
                        'code' => $subjectData['code'],
                        'name' => $subjectData['name'],
                        'name_en' => $subjectData['name_en'],
                        'icon' => $subjectData['icon'],
                        'color' => $subjectData['color'],
                    ]
                );

                foreach ($subjectData['units'] as $unitData) {
                    $unit = Unit::updateOrCreate(
                        ['code' => $unitData['id'], 'subject_id' => $subject->id],
                        [
                            'code' => $unitData['id'],
                            'name' => $unitData['name'],
                            'name_en' => $unitData['name_en'],
                            'description' => $unitData['description'],
                        ]
                    );

                    foreach ($unitData['lessons'] as $lessonData) {
                        Lesson::updateOrCreate(
                            ['code' => $lessonData['id'], 'unit_id' => $unit->id],
                            [
                                'code' => $lessonData['id'],
                                'title' => $lessonData['title'],
                                'title_en' => $lessonData['title_en'],
                                'duration' => '30 دقيقة',
                                'type' => 'video',
                            ]
                        );
                    }
                }
            }
        }
    }

    protected function seedSecondary(): void
    {
        $stage = Stage::updateOrCreate(
            ['code' => 'secondary'],
            [
                'code' => 'secondary',
                'name' => 'المرحلة الثانوية',
                'name_en' => 'Secondary School',
                'description' => 'التحضير المكثف للثانوية العامة والتفوق الأكاديمي',
            ]
        );

        $grades = [
            ['id' => 'sec-1', 'name' => 'الصف الأول الثانوي', 'name_en' => 'Grade 10'],
            ['id' => 'sec-2', 'name' => 'الصف الثاني الثانوي', 'name_en' => 'Grade 11'],
            ['id' => 'sec-3', 'name' => 'الصف الثالث الثانوي', 'name_en' => 'Grade 12 (Thanaweya Amma)'],
        ];

        $secMathUnits = [
            [
                'id' => 'calculus',
                'name' => 'التفاضل والتكامل',
                'name_en' => 'Calculus',
                'description' => 'حساب التفاضل والتكامل',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'مقدمة في التفاضل', 'title_en' => 'Introduction to Differentiation'],
                    ['id' => 'lesson-2', 'title' => 'قواعد الاشتقاق', 'title_en' => 'Differentiation Rules'],
                    ['id' => 'lesson-3', 'title' => 'اشتقاق الدوال المركبة', 'title_en' => 'Chain Rule'],
                    ['id' => 'lesson-4', 'title' => 'تطبيقات التفاضل', 'title_en' => 'Applications of Derivatives'],
                ],
            ],
        ];

        $secPhysicsUnits = [
            [
                'id' => 'mechanics',
                'name' => 'الميكانيكا',
                'name_en' => 'Mechanics',
                'description' => 'قوانين الحركة والديناميكا',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'قوانين نيوتن للحركة', 'title_en' => "Newton's Laws of Motion"],
                    ['id' => 'lesson-2', 'title' => 'الشغل والطاقة', 'title_en' => 'Work and Energy'],
                    ['id' => 'lesson-3', 'title' => 'كمية الحركة والتصادم', 'title_en' => 'Momentum and Collision'],
                ],
            ],
        ];

        $secChemistryUnits = [
            [
                'id' => 'organic',
                'name' => 'الكيمياء العضوية',
                'name_en' => 'Organic Chemistry',
                'description' => 'المركبات العضوية وتفاعلاتها',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الهيدروكربونات', 'title_en' => 'Hydrocarbons'],
                    ['id' => 'lesson-2', 'title' => 'الكحولات والفينولات', 'title_en' => 'Alcohols and Phenols'],
                ],
            ],
        ];

        $secBiologyUnits = [
            [
                'id' => 'genetics',
                'name' => 'الوراثة',
                'name_en' => 'Genetics',
                'description' => 'الوراثة والحمض النووي',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الحمض النووي DNA', 'title_en' => 'DNA'],
                    ['id' => 'lesson-2', 'title' => 'الانقسام الخلوي', 'title_en' => 'Cell Division'],
                ],
            ],
        ];

        $secArabicUnits = [
            [
                'id' => 'nahw-advanced',
                'name' => 'النحو المتقدم',
                'name_en' => 'Advanced Grammar',
                'description' => 'قواعد النحو للثانوية',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'أسماء الأفعال', 'title_en' => 'Verbal Nouns'],
                    ['id' => 'lesson-2', 'title' => 'التمييز والحال', 'title_en' => 'Distinction and State'],
                ],
            ],
        ];

        $secEnglishUnits = [
            [
                'id' => 'grammar-advanced',
                'name' => 'القواعد المتقدمة',
                'name_en' => 'Advanced Grammar',
                'description' => 'قواعد متقدمة للغة الإنجليزية',
                'lessons' => [
                    ['id' => 'lesson-1', 'title' => 'الجمل المعقدة', 'title_en' => 'Complex Sentences'],
                    ['id' => 'lesson-2', 'title' => 'أزمنة الكمال', 'title_en' => 'Perfect Tenses'],
                ],
            ],
        ];

        foreach ($grades as $gradeData) {
            $grade = Grade::updateOrCreate(
                ['code' => $gradeData['id']],
                [
                    'stage_id' => $stage->id,
                    'code' => $gradeData['id'],
                    'name' => $gradeData['name'],
                    'name_en' => $gradeData['name_en'],
                ]
            );

            $prefix = str_replace('sec-', 's', $grade->code);

            $subjects = [
                [
                    'code' => $prefix.'-math',
                    'name' => 'الرياضيات',
                    'name_en' => 'Mathematics',
                    'icon' => 'Calculator',
                    'color' => 'hsl(38 92% 50%)',
                    'units' => $secMathUnits,
                ],
                [
                    'code' => $prefix.'-arabic',
                    'name' => 'اللغة العربية',
                    'name_en' => 'Arabic Language',
                    'icon' => 'BookText',
                    'color' => 'hsl(175 45% 40%)',
                    'units' => $secArabicUnits,
                ],
                [
                    'code' => $prefix.'-english',
                    'name' => 'اللغة الإنجليزية',
                    'name_en' => 'English Language',
                    'icon' => 'Languages',
                    'color' => 'hsl(220 80% 55%)',
                    'units' => $secEnglishUnits,
                ],
                [
                    'code' => $prefix.'-physics',
                    'name' => 'الفيزياء',
                    'name_en' => 'Physics',
                    'icon' => 'Atom',
                    'color' => 'hsl(15 85% 60%)',
                    'units' => $secPhysicsUnits,
                ],
                [
                    'code' => $prefix.'-chemistry',
                    'name' => 'الكيمياء',
                    'name_en' => 'Chemistry',
                    'icon' => 'Beaker',
                    'color' => 'hsl(175 45% 40%)',
                    'units' => $secChemistryUnits,
                ],
                [
                    'code' => $prefix.'-biology',
                    'name' => 'الأحياء',
                    'name_en' => 'Biology',
                    'icon' => 'Heart',
                    'color' => 'hsl(0 70% 50%)',
                    'units' => $secBiologyUnits,
                ],
            ];

            foreach ($subjects as $subjectData) {
                $subject = Subject::updateOrCreate(
                    ['code' => $subjectData['code']],
                    [
                        'grade_id' => $grade->id,
                        'code' => $subjectData['code'],
                        'name' => $subjectData['name'],
                        'name_en' => $subjectData['name_en'],
                        'icon' => $subjectData['icon'],
                        'color' => $subjectData['color'],
                    ]
                );

                foreach ($subjectData['units'] as $unitData) {
                    $unit = Unit::updateOrCreate(
                        ['code' => $unitData['id'], 'subject_id' => $subject->id],
                        [
                            'code' => $unitData['id'],
                            'name' => $unitData['name'],
                            'name_en' => $unitData['name_en'],
                            'description' => $unitData['description'],
                        ]
                    );

                    foreach ($unitData['lessons'] as $lessonData) {
                        Lesson::updateOrCreate(
                            ['code' => $lessonData['id'], 'unit_id' => $unit->id],
                            [
                                'code' => $lessonData['id'],
                                'title' => $lessonData['title'],
                                'title_en' => $lessonData['title_en'],
                                'duration' => '45 دقيقة',
                                'type' => 'video',
                            ]
                        );
                    }
                }
            }
        }
    }
}