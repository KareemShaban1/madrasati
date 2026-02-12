import { 
  Calculator, 
  Beaker, 
  Atom,
  BookText, 
  Languages, 
  Globe2, 
  Cpu, 
  BookOpen,
  Palette,
  Music,
  Heart,
  Users,
  LucideIcon
} from "lucide-react";

export interface Lesson {
  id: string;
  title: string;
  titleEn: string;
  duration: string;
  status: "completed" | "in-progress" | "locked";
  order: number;
}

export interface Unit {
  id: string;
  title: string;
  titleEn: string;
  description: string;
  lessons: Lesson[];
  order: number;
}

export interface Exercise {
  id: string;
  title: string;
  type: "mcq" | "short-answer" | "problem-solving";
  difficulty: "easy" | "medium" | "hard";
  questionsCount: number;
  completed: boolean;
  score?: number;
}

export interface Progress {
  overallPercent: number;
  lessonsCompleted: number;
  totalLessons: number;
  exercisesCompleted: number;
  totalExercises: number;
  averageScore: number;
  streak: number;
  timeSpent: string;
}

export interface Subject {
  id: string;
  name: string;
  nameEn: string;
  icon: LucideIcon;
  color: string;
  colorClass: string;
  description: string;
  units: Unit[];
  exercises: Exercise[];
  progress: Progress;
}

export interface Grade {
  id: string;
  name: string;
  nameEn: string;
  order: number;
  subjects: Subject[];
}

export interface Stage {
  id: string;
  name: string;
  nameEn: string;
  description: string;
  ageRange: string;
  colorClass: string;
  grades: Grade[];
}

// Helper function to generate lessons for a unit
const generateLessons = (titles: { ar: string; en: string }[], startStatus: number = 0): Lesson[] => {
  return titles.map((title, index) => ({
    id: `lesson-${index + 1}`,
    title: title.ar,
    titleEn: title.en,
    duration: `${30 + Math.floor(Math.random() * 30)} دقيقة`,
    status: index < startStatus ? "completed" : index === startStatus ? "in-progress" : "locked",
    order: index + 1
  }));
};

// Helper function to generate exercises
const generateExercises = (count: number): Exercise[] => {
  const types: ("mcq" | "short-answer" | "problem-solving")[] = ["mcq", "short-answer", "problem-solving"];
  const difficulties: ("easy" | "medium" | "hard")[] = ["easy", "medium", "hard"];
  
  return Array.from({ length: count }, (_, index) => ({
    id: `exercise-${index + 1}`,
    title: `تمرين ${index + 1}`,
    type: types[index % 3],
    difficulty: difficulties[Math.floor(index / 2) % 3],
    questionsCount: 5 + Math.floor(Math.random() * 15),
    completed: index < 2,
    score: index < 2 ? 70 + Math.floor(Math.random() * 30) : undefined
  }));
};

// Helper function to generate progress
const generateProgress = (lessonsCompleted: number, totalLessons: number): Progress => ({
  overallPercent: Math.round((lessonsCompleted / totalLessons) * 100),
  lessonsCompleted,
  totalLessons,
  exercisesCompleted: Math.floor(lessonsCompleted / 2),
  totalExercises: Math.floor(totalLessons / 2),
  averageScore: 75 + Math.floor(Math.random() * 20),
  streak: Math.floor(Math.random() * 10),
  timeSpent: `${lessonsCompleted * 2} ساعة`
});

// ============================================
// PRIMARY SCHOOL CURRICULUM
// ============================================

const primaryMathUnits: Unit[] = [
  {
    id: "numbers-operations",
    title: "الأعداد والعمليات الحسابية",
    titleEn: "Numbers and Operations",
    description: "تعلم الأعداد والجمع والطرح والضرب والقسمة",
    order: 1,
    lessons: generateLessons([
      { ar: "الأعداد من 1 إلى 100", en: "Numbers 1 to 100" },
      { ar: "الجمع والطرح", en: "Addition and Subtraction" },
      { ar: "جدول الضرب", en: "Multiplication Table" },
      { ar: "القسمة البسيطة", en: "Simple Division" }
    ], 2)
  },
  {
    id: "geometry-basics",
    title: "الأشكال الهندسية",
    titleEn: "Basic Geometry",
    description: "التعرف على الأشكال الهندسية وخصائصها",
    order: 2,
    lessons: generateLessons([
      { ar: "المربع والمستطيل", en: "Square and Rectangle" },
      { ar: "الدائرة والمثلث", en: "Circle and Triangle" },
      { ar: "المحيط والمساحة", en: "Perimeter and Area" }
    ], 1)
  }
];

const primaryArabicUnits: Unit[] = [
  {
    id: "reading-writing",
    title: "القراءة والكتابة",
    titleEn: "Reading and Writing",
    description: "تعلم الحروف والكلمات والجمل",
    order: 1,
    lessons: generateLessons([
      { ar: "الحروف الأبجدية", en: "Arabic Alphabet" },
      { ar: "الحركات والتنوين", en: "Vowels and Tanween" },
      { ar: "تكوين الكلمات", en: "Word Formation" },
      { ar: "الجملة الاسمية", en: "Nominal Sentence" }
    ], 3)
  },
  {
    id: "grammar-basics",
    title: "أساسيات النحو",
    titleEn: "Grammar Basics",
    description: "قواعد اللغة العربية الأساسية",
    order: 2,
    lessons: generateLessons([
      { ar: "المبتدأ والخبر", en: "Subject and Predicate" },
      { ar: "الفعل والفاعل", en: "Verb and Subject" },
      { ar: "الاسم والفعل والحرف", en: "Noun, Verb, and Particle" }
    ], 0)
  }
];

const primaryScienceUnits: Unit[] = [
  {
    id: "living-things",
    title: "الكائنات الحية",
    titleEn: "Living Things",
    description: "دراسة النباتات والحيوانات",
    order: 1,
    lessons: generateLessons([
      { ar: "أجزاء النبات", en: "Parts of a Plant" },
      { ar: "دورة حياة النبات", en: "Plant Life Cycle" },
      { ar: "تصنيف الحيوانات", en: "Animal Classification" }
    ], 2)
  },
  {
    id: "our-universe",
    title: "الكون من حولنا",
    titleEn: "Our Universe",
    description: "استكشاف الأرض والفضاء",
    order: 2,
    lessons: generateLessons([
      { ar: "كوكب الأرض", en: "Planet Earth" },
      { ar: "الشمس والقمر", en: "Sun and Moon" },
      { ar: "النظام الشمسي", en: "Solar System" }
    ], 1)
  }
];

const primaryEnglishUnits: Unit[] = [
  {
    id: "alphabet-phonics",
    title: "الحروف والأصوات",
    titleEn: "Alphabet and Phonics",
    description: "تعلم الحروف الإنجليزية ونطقها",
    order: 1,
    lessons: generateLessons([
      { ar: "الحروف A-M", en: "Letters A-M" },
      { ar: "الحروف N-Z", en: "Letters N-Z" },
      { ar: "الأصوات القصيرة", en: "Short Vowels" },
      { ar: "الأصوات الطويلة", en: "Long Vowels" }
    ], 2)
  },
  {
    id: "vocabulary-basics",
    title: "المفردات الأساسية",
    titleEn: "Basic Vocabulary",
    description: "كلمات وعبارات يومية",
    order: 2,
    lessons: generateLessons([
      { ar: "الألوان والأرقام", en: "Colors and Numbers" },
      { ar: "العائلة والأصدقاء", en: "Family and Friends" },
      { ar: "الطعام والشراب", en: "Food and Drinks" }
    ], 1)
  }
];

// ============================================
// PREPARATORY SCHOOL CURRICULUM
// ============================================

const prepMathUnits: Unit[] = [
  {
    id: "algebra",
    title: "الجبر",
    titleEn: "Algebra",
    description: "المعادلات والمتباينات والدوال",
    order: 1,
    lessons: generateLessons([
      { ar: "المتغيرات والتعبيرات الجبرية", en: "Variables and Expressions" },
      { ar: "حل المعادلات الخطية", en: "Solving Linear Equations" },
      { ar: "المتباينات", en: "Inequalities" },
      { ar: "نظام المعادلات", en: "Systems of Equations" }
    ], 2)
  },
  {
    id: "geometry",
    title: "الهندسة",
    titleEn: "Geometry",
    description: "الأشكال والمساحات والحجوم",
    order: 2,
    lessons: generateLessons([
      { ar: "المثلثات وخصائصها", en: "Triangles and Properties" },
      { ar: "الدائرة ومحيطها", en: "Circle and Circumference" },
      { ar: "المجسمات", en: "3D Shapes" },
      { ar: "حساب الحجوم", en: "Volume Calculation" }
    ], 1)
  },
  {
    id: "statistics",
    title: "الإحصاء",
    titleEn: "Statistics",
    description: "جمع البيانات وتحليلها",
    order: 3,
    lessons: generateLessons([
      { ar: "جمع البيانات", en: "Data Collection" },
      { ar: "المتوسط والوسيط", en: "Mean and Median" },
      { ar: "التمثيل البياني", en: "Graphical Representation" }
    ], 0)
  }
];

const prepScienceUnits: Unit[] = [
  {
    id: "physics-intro",
    title: "مقدمة في الفيزياء",
    titleEn: "Introduction to Physics",
    description: "الحركة والقوى والطاقة",
    order: 1,
    lessons: generateLessons([
      { ar: "الحركة والسرعة", en: "Motion and Speed" },
      { ar: "القوة والكتلة", en: "Force and Mass" },
      { ar: "الطاقة وأشكالها", en: "Energy Forms" },
      { ar: "الشغل والقدرة", en: "Work and Power" }
    ], 2)
  },
  {
    id: "chemistry-intro",
    title: "مقدمة في الكيمياء",
    titleEn: "Introduction to Chemistry",
    description: "المادة وتركيبها",
    order: 2,
    lessons: generateLessons([
      { ar: "حالات المادة", en: "States of Matter" },
      { ar: "الذرة والعناصر", en: "Atoms and Elements" },
      { ar: "التفاعلات الكيميائية", en: "Chemical Reactions" }
    ], 1)
  },
  {
    id: "biology-intro",
    title: "مقدمة في الأحياء",
    titleEn: "Introduction to Biology",
    description: "الخلية والكائنات الحية",
    order: 3,
    lessons: generateLessons([
      { ar: "تركيب الخلية", en: "Cell Structure" },
      { ar: "الجهاز الهضمي", en: "Digestive System" },
      { ar: "الجهاز التنفسي", en: "Respiratory System" },
      { ar: "الجهاز الدوري", en: "Circulatory System" }
    ], 0)
  }
];

const prepArabicUnits: Unit[] = [
  {
    id: "grammar-advanced",
    title: "النحو المتقدم",
    titleEn: "Advanced Grammar",
    description: "قواعد النحو العربي",
    order: 1,
    lessons: generateLessons([
      { ar: "الإعراب والبناء", en: "Parsing and Structure" },
      { ar: "المنصوبات", en: "Accusative Cases" },
      { ar: "المجرورات", en: "Genitive Cases" },
      { ar: "التوابع", en: "Appositives" }
    ], 2)
  },
  {
    id: "literature",
    title: "الأدب والنصوص",
    titleEn: "Literature",
    description: "قراءة وتحليل النصوص الأدبية",
    order: 2,
    lessons: generateLessons([
      { ar: "الشعر العربي", en: "Arabic Poetry" },
      { ar: "القصة القصيرة", en: "Short Story" },
      { ar: "المقال", en: "Essay Writing" }
    ], 1)
  }
];

const prepEnglishUnits: Unit[] = [
  {
    id: "grammar-intermediate",
    title: "القواعد المتوسطة",
    titleEn: "Intermediate Grammar",
    description: "قواعد اللغة الإنجليزية",
    order: 1,
    lessons: generateLessons([
      { ar: "الأزمنة المختلفة", en: "Verb Tenses" },
      { ar: "الجمل الشرطية", en: "Conditional Sentences" },
      { ar: "المبني للمجهول", en: "Passive Voice" },
      { ar: "الكلام المنقول", en: "Reported Speech" }
    ], 2)
  },
  {
    id: "reading-comprehension",
    title: "فهم المقروء",
    titleEn: "Reading Comprehension",
    description: "قراءة وفهم النصوص الإنجليزية",
    order: 2,
    lessons: generateLessons([
      { ar: "استراتيجيات القراءة", en: "Reading Strategies" },
      { ar: "تحليل النصوص", en: "Text Analysis" },
      { ar: "الأفكار الرئيسية", en: "Main Ideas" }
    ], 1)
  }
];

const prepSocialUnits: Unit[] = [
  {
    id: "egypt-history",
    title: "تاريخ مصر",
    titleEn: "Egyptian History",
    description: "تاريخ مصر عبر العصور",
    order: 1,
    lessons: generateLessons([
      { ar: "مصر الفرعونية", en: "Ancient Egypt" },
      { ar: "مصر الإسلامية", en: "Islamic Egypt" },
      { ar: "مصر الحديثة", en: "Modern Egypt" }
    ], 2)
  },
  {
    id: "geography",
    title: "الجغرافيا",
    titleEn: "Geography",
    description: "جغرافية مصر والعالم",
    order: 2,
    lessons: generateLessons([
      { ar: "موقع مصر", en: "Egypt's Location" },
      { ar: "المناخ والتضاريس", en: "Climate and Terrain" },
      { ar: "الموارد الطبيعية", en: "Natural Resources" }
    ], 1)
  }
];

// ============================================
// SECONDARY SCHOOL CURRICULUM
// ============================================

const secMathUnits: Unit[] = [
  {
    id: "calculus",
    title: "التفاضل والتكامل",
    titleEn: "Calculus",
    description: "حساب التفاضل والتكامل",
    order: 1,
    lessons: generateLessons([
      { ar: "مقدمة في التفاضل", en: "Introduction to Differentiation" },
      { ar: "قواعد الاشتقاق", en: "Differentiation Rules" },
      { ar: "اشتقاق الدوال المركبة", en: "Chain Rule" },
      { ar: "تطبيقات التفاضل", en: "Applications of Derivatives" },
      { ar: "النهايات العظمى والصغرى", en: "Maxima and Minima" },
      { ar: "مقدمة في التكامل", en: "Introduction to Integration" }
    ], 3)
  },
  {
    id: "trigonometry",
    title: "حساب المثلثات",
    titleEn: "Trigonometry",
    description: "الدوال المثلثية وتطبيقاتها",
    order: 2,
    lessons: generateLessons([
      { ar: "النسب المثلثية", en: "Trigonometric Ratios" },
      { ar: "الدوال المثلثية", en: "Trigonometric Functions" },
      { ar: "المعادلات المثلثية", en: "Trigonometric Equations" },
      { ar: "قانونا الجيب والتجيب", en: "Sine and Cosine Rules" }
    ], 2)
  },
  {
    id: "algebra-advanced",
    title: "الجبر المتقدم",
    titleEn: "Advanced Algebra",
    description: "المصفوفات والمحددات والمتجهات",
    order: 3,
    lessons: generateLessons([
      { ar: "المصفوفات", en: "Matrices" },
      { ar: "المحددات", en: "Determinants" },
      { ar: "المتجهات", en: "Vectors" },
      { ar: "الأعداد المركبة", en: "Complex Numbers" }
    ], 1)
  }
];

const secPhysicsUnits: Unit[] = [
  {
    id: "mechanics",
    title: "الميكانيكا",
    titleEn: "Mechanics",
    description: "قوانين الحركة والديناميكا",
    order: 1,
    lessons: generateLessons([
      { ar: "قوانين نيوتن للحركة", en: "Newton's Laws of Motion" },
      { ar: "الشغل والطاقة", en: "Work and Energy" },
      { ar: "كمية الحركة والتصادم", en: "Momentum and Collision" },
      { ar: "الحركة الدائرية", en: "Circular Motion" },
      { ar: "الجاذبية الكونية", en: "Universal Gravitation" }
    ], 2)
  },
  {
    id: "electricity",
    title: "الكهربية",
    titleEn: "Electricity",
    description: "التيار الكهربي والدوائر",
    order: 2,
    lessons: generateLessons([
      { ar: "الشحنة الكهربية", en: "Electric Charge" },
      { ar: "قانون أوم", en: "Ohm's Law" },
      { ar: "الدوائر الكهربية", en: "Electric Circuits" },
      { ar: "المقاومة والتوصيل", en: "Resistance and Conductance" }
    ], 1)
  },
  {
    id: "modern-physics",
    title: "الفيزياء الحديثة",
    titleEn: "Modern Physics",
    description: "الفيزياء الذرية والنووية",
    order: 3,
    lessons: generateLessons([
      { ar: "الذرة والطيف", en: "Atom and Spectrum" },
      { ar: "الفيزياء النووية", en: "Nuclear Physics" },
      { ar: "النشاط الإشعاعي", en: "Radioactivity" }
    ], 0)
  }
];

const secChemistryUnits: Unit[] = [
  {
    id: "organic",
    title: "الكيمياء العضوية",
    titleEn: "Organic Chemistry",
    description: "المركبات العضوية وتفاعلاتها",
    order: 1,
    lessons: generateLessons([
      { ar: "الهيدروكربونات", en: "Hydrocarbons" },
      { ar: "الكحولات والفينولات", en: "Alcohols and Phenols" },
      { ar: "الأحماض الكربوكسيلية", en: "Carboxylic Acids" },
      { ar: "الإسترات", en: "Esters" }
    ], 2)
  },
  {
    id: "inorganic",
    title: "الكيمياء غير العضوية",
    titleEn: "Inorganic Chemistry",
    description: "العناصر والمركبات غير العضوية",
    order: 2,
    lessons: generateLessons([
      { ar: "الجدول الدوري", en: "Periodic Table" },
      { ar: "الروابط الكيميائية", en: "Chemical Bonds" },
      { ar: "عناصر المجموعات الرئيسية", en: "Main Group Elements" }
    ], 1)
  },
  {
    id: "electrochemistry",
    title: "الكيمياء الكهربية",
    titleEn: "Electrochemistry",
    description: "التفاعلات الكهروكيميائية",
    order: 3,
    lessons: generateLessons([
      { ar: "الخلايا الجلفانية", en: "Galvanic Cells" },
      { ar: "التحليل الكهربي", en: "Electrolysis" },
      { ar: "البطاريات", en: "Batteries" }
    ], 0)
  }
];

const secBiologyUnits: Unit[] = [
  {
    id: "genetics",
    title: "الوراثة",
    titleEn: "Genetics",
    description: "الوراثة والحمض النووي",
    order: 1,
    lessons: generateLessons([
      { ar: "الحمض النووي DNA", en: "DNA" },
      { ar: "الانقسام الخلوي", en: "Cell Division" },
      { ar: "قوانين مندل", en: "Mendel's Laws" },
      { ar: "الهندسة الوراثية", en: "Genetic Engineering" }
    ], 2)
  },
  {
    id: "human-biology",
    title: "أحياء الإنسان",
    titleEn: "Human Biology",
    description: "أجهزة الجسم البشري",
    order: 2,
    lessons: generateLessons([
      { ar: "الجهاز العصبي", en: "Nervous System" },
      { ar: "الجهاز الهرموني", en: "Endocrine System" },
      { ar: "الجهاز المناعي", en: "Immune System" }
    ], 1)
  }
];

const secArabicUnits: Unit[] = [
  {
    id: "nahw-advanced",
    title: "النحو المتقدم",
    titleEn: "Advanced Grammar",
    description: "قواعد النحو للثانوية",
    order: 1,
    lessons: generateLessons([
      { ar: "أسماء الأفعال", en: "Verbal Nouns" },
      { ar: "التمييز والحال", en: "Distinction and State" },
      { ar: "الممنوع من الصرف", en: "Diptotes" },
      { ar: "الاستثناء", en: "Exception" }
    ], 2)
  },
  {
    id: "balagha",
    title: "البلاغة",
    titleEn: "Rhetoric",
    description: "علوم البلاغة العربية",
    order: 2,
    lessons: generateLessons([
      { ar: "علم البيان", en: "Science of Expression" },
      { ar: "علم المعاني", en: "Science of Meanings" },
      { ar: "علم البديع", en: "Science of Embellishment" }
    ], 1)
  }
];

const secEnglishUnits: Unit[] = [
  {
    id: "grammar-advanced",
    title: "القواعد المتقدمة",
    titleEn: "Advanced Grammar",
    description: "قواعد متقدمة للغة الإنجليزية",
    order: 1,
    lessons: generateLessons([
      { ar: "الجمل المعقدة", en: "Complex Sentences" },
      { ar: "أزمنة الكمال", en: "Perfect Tenses" },
      { ar: "أشباه الجمل", en: "Clauses and Phrases" },
      { ar: "المودالز", en: "Modal Verbs" }
    ], 2)
  },
  {
    id: "writing-skills",
    title: "مهارات الكتابة",
    titleEn: "Writing Skills",
    description: "كتابة المقالات والتقارير",
    order: 2,
    lessons: generateLessons([
      { ar: "كتابة المقال", en: "Essay Writing" },
      { ar: "الرسائل الرسمية", en: "Formal Letters" },
      { ar: "التقارير", en: "Report Writing" }
    ], 1)
  }
];

// Create subject with units
const createSubject = (
  id: string,
  name: string,
  nameEn: string,
  icon: LucideIcon,
  color: string,
  colorClass: string,
  description: string,
  units: Unit[]
): Subject => {
  const totalLessons = units.reduce((sum, unit) => sum + unit.lessons.length, 0);
  const completedLessons = units.reduce(
    (sum, unit) => sum + unit.lessons.filter(l => l.status === "completed").length,
    0
  );

  return {
    id,
    name,
    nameEn,
    icon,
    color,
    colorClass,
    description,
    units,
    exercises: generateExercises(Math.floor(totalLessons / 2)),
    progress: generateProgress(completedLessons, totalLessons)
  };
};

// ============================================
// FULL CURRICULUM DATA
// ============================================

export const curriculumData: Stage[] = [
  {
    id: "primary",
    name: "المرحلة الابتدائية",
    nameEn: "Primary School",
    description: "تأسيس قوي للمهارات الأساسية في القراءة والكتابة والحساب",
    ageRange: "٦ - ١٢ سنة",
    colorClass: "gradient-hero",
    grades: [
      {
        id: "primary-1",
        name: "الصف الأول الابتدائي",
        nameEn: "Grade 1",
        order: 1,
        subjects: [
          createSubject("p1-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الأعداد والحساب الأساسي", primaryMathUnits),
          createSubject("p1-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "تعلم القراءة والكتابة", primaryArabicUnits),
          createSubject("p1-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "الحروف والكلمات الأساسية", primaryEnglishUnits),
          createSubject("p1-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "استكشاف العالم من حولنا", primaryScienceUnits),
        ]
      },
      {
        id: "primary-2",
        name: "الصف الثاني الابتدائي",
        nameEn: "Grade 2",
        order: 2,
        subjects: [
          createSubject("p2-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الجمع والطرح والضرب", primaryMathUnits),
          createSubject("p2-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "القراءة والفهم", primaryArabicUnits),
          createSubject("p2-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "بناء المفردات", primaryEnglishUnits),
          createSubject("p2-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "النباتات والحيوانات", primaryScienceUnits),
        ]
      },
      {
        id: "primary-3",
        name: "الصف الثالث الابتدائي",
        nameEn: "Grade 3",
        order: 3,
        subjects: [
          createSubject("p3-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الضرب والقسمة", primaryMathUnits),
          createSubject("p3-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "النحو الأساسي", primaryArabicUnits),
          createSubject("p3-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "الجمل والمحادثة", primaryEnglishUnits),
          createSubject("p3-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "المادة والطاقة", primaryScienceUnits),
        ]
      },
      {
        id: "primary-4",
        name: "الصف الرابع الابتدائي",
        nameEn: "Grade 4",
        order: 4,
        subjects: [
          createSubject("p4-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الكسور والأعداد العشرية", primaryMathUnits),
          createSubject("p4-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "الإعراب والتعبير", primaryArabicUnits),
          createSubject("p4-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "القراءة والكتابة", primaryEnglishUnits),
          createSubject("p4-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "الصوت والضوء", primaryScienceUnits),
        ]
      },
      {
        id: "primary-5",
        name: "الصف الخامس الابتدائي",
        nameEn: "Grade 5",
        order: 5,
        subjects: [
          createSubject("p5-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الهندسة والقياس", primaryMathUnits),
          createSubject("p5-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "القواعد النحوية", primaryArabicUnits),
          createSubject("p5-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "القواعد الأساسية", primaryEnglishUnits),
          createSubject("p5-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "الجهاز الهضمي", primaryScienceUnits),
        ]
      },
      {
        id: "primary-6",
        name: "الصف السادس الابتدائي",
        nameEn: "Grade 6",
        order: 6,
        subjects: [
          createSubject("p6-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "النسبة والتناسب", primaryMathUnits),
          createSubject("p6-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "الأدب والنصوص", primaryArabicUnits),
          createSubject("p6-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "المحادثة والاستماع", primaryEnglishUnits),
          createSubject("p6-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "الكهرباء والمغناطيسية", primaryScienceUnits),
        ]
      }
    ]
  },
  {
    id: "preparatory",
    name: "المرحلة الإعدادية",
    nameEn: "Preparatory School",
    description: "تطوير مهارات التفكير النقدي والعلمي",
    ageRange: "١٢ - ١٥ سنة",
    colorClass: "gradient-nile",
    grades: [
      {
        id: "prep-1",
        name: "الصف الأول الإعدادي",
        nameEn: "Grade 7",
        order: 1,
        subjects: [
          createSubject("pr1-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الجبر والهندسة", prepMathUnits),
          createSubject("pr1-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "النحو والصرف", prepArabicUnits),
          createSubject("pr1-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "القواعد المتوسطة", prepEnglishUnits),
          createSubject("pr1-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "الفيزياء والكيمياء والأحياء", prepScienceUnits),
          createSubject("pr1-social", "الدراسات الاجتماعية", "Social Studies", Globe2, "hsl(280 60% 50%)", "primary", "التاريخ والجغرافيا", prepSocialUnits),
        ]
      },
      {
        id: "prep-2",
        name: "الصف الثاني الإعدادي",
        nameEn: "Grade 8",
        order: 2,
        subjects: [
          createSubject("pr2-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "المعادلات والمتباينات", prepMathUnits),
          createSubject("pr2-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "البلاغة والأدب", prepArabicUnits),
          createSubject("pr2-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "فهم المقروء", prepEnglishUnits),
          createSubject("pr2-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "القوى والحركة", prepScienceUnits),
          createSubject("pr2-social", "الدراسات الاجتماعية", "Social Studies", Globe2, "hsl(280 60% 50%)", "primary", "الحضارة الإسلامية", prepSocialUnits),
        ]
      },
      {
        id: "prep-3",
        name: "الصف الثالث الإعدادي",
        nameEn: "Grade 9",
        order: 3,
        subjects: [
          createSubject("pr3-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الإحصاء والاحتمالات", prepMathUnits),
          createSubject("pr3-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "النقد والتذوق", prepArabicUnits),
          createSubject("pr3-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "الكتابة الإبداعية", prepEnglishUnits),
          createSubject("pr3-science", "العلوم", "Science", Beaker, "hsl(15 85% 60%)", "accent", "الطاقة والبيئة", prepScienceUnits),
          createSubject("pr3-social", "الدراسات الاجتماعية", "Social Studies", Globe2, "hsl(280 60% 50%)", "primary", "مصر الحديثة", prepSocialUnits),
        ]
      }
    ]
  },
  {
    id: "secondary",
    name: "المرحلة الثانوية",
    nameEn: "Secondary School",
    description: "التحضير المكثف للثانوية العامة والتفوق الأكاديمي",
    ageRange: "١٥ - ١٨ سنة",
    colorClass: "bg-accent",
    grades: [
      {
        id: "sec-1",
        name: "الصف الأول الثانوي",
        nameEn: "Grade 10",
        order: 1,
        subjects: [
          createSubject("s1-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "التفاضل والتكامل", secMathUnits),
          createSubject("s1-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "النحو والبلاغة", secArabicUnits),
          createSubject("s1-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "القواعد المتقدمة", secEnglishUnits),
          createSubject("s1-physics", "الفيزياء", "Physics", Atom, "hsl(15 85% 60%)", "accent", "الميكانيكا الكلاسيكية", secPhysicsUnits),
          createSubject("s1-chemistry", "الكيمياء", "Chemistry", Beaker, "hsl(175 45% 40%)", "secondary", "الكيمياء العضوية", secChemistryUnits),
          createSubject("s1-biology", "الأحياء", "Biology", Heart, "hsl(0 70% 50%)", "accent", "الوراثة والتطور", secBiologyUnits),
        ]
      },
      {
        id: "sec-2",
        name: "الصف الثاني الثانوي",
        nameEn: "Grade 11",
        order: 2,
        subjects: [
          createSubject("s2-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "حساب المثلثات", secMathUnits),
          createSubject("s2-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "الأدب العربي", secArabicUnits),
          createSubject("s2-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "مهارات الكتابة", secEnglishUnits),
          createSubject("s2-physics", "الفيزياء", "Physics", Atom, "hsl(15 85% 60%)", "accent", "الكهربية والمغناطيسية", secPhysicsUnits),
          createSubject("s2-chemistry", "الكيمياء", "Chemistry", Beaker, "hsl(175 45% 40%)", "secondary", "الكيمياء الكهربية", secChemistryUnits),
          createSubject("s2-biology", "الأحياء", "Biology", Heart, "hsl(0 70% 50%)", "accent", "أحياء الإنسان", secBiologyUnits),
        ]
      },
      {
        id: "sec-3",
        name: "الصف الثالث الثانوي",
        nameEn: "Grade 12 (Thanaweya Amma)",
        order: 3,
        subjects: [
          createSubject("s3-math", "الرياضيات", "Mathematics", Calculator, "hsl(38 92% 50%)", "primary", "الجبر والتكامل المتقدم", secMathUnits),
          createSubject("s3-arabic", "اللغة العربية", "Arabic Language", BookText, "hsl(175 45% 40%)", "secondary", "النقد والبلاغة المتقدمة", secArabicUnits),
          createSubject("s3-english", "اللغة الإنجليزية", "English Language", Languages, "hsl(220 80% 55%)", "primary", "الأدب والترجمة", secEnglishUnits),
          createSubject("s3-physics", "الفيزياء", "Physics", Atom, "hsl(15 85% 60%)", "accent", "الفيزياء الحديثة", secPhysicsUnits),
          createSubject("s3-chemistry", "الكيمياء", "Chemistry", Beaker, "hsl(175 45% 40%)", "secondary", "الكيمياء العضوية المتقدمة", secChemistryUnits),
          createSubject("s3-biology", "الأحياء", "Biology", Heart, "hsl(0 70% 50%)", "accent", "البيولوجيا الجزيئية", secBiologyUnits),
        ]
      }
    ]
  }
];

// Helper functions to find data
export const findStage = (stageId: string) => curriculumData.find(s => s.id === stageId);

export const findGrade = (stageId: string, gradeId: string) => {
  const stage = findStage(stageId);
  return stage?.grades.find(g => g.id === gradeId);
};

export const findSubject = (stageId: string, gradeId: string, subjectId: string) => {
  const grade = findGrade(stageId, gradeId);
  return grade?.subjects.find(s => s.id === subjectId);
};

export const findUnit = (stageId: string, gradeId: string, subjectId: string, unitId: string) => {
  const subject = findSubject(stageId, gradeId, subjectId);
  return subject?.units.find(u => u.id === unitId);
};

export const findLesson = (stageId: string, gradeId: string, subjectId: string, unitId: string, lessonId: string) => {
  const unit = findUnit(stageId, gradeId, subjectId, unitId);
  return unit?.lessons.find(l => l.id === lessonId);
};

// Get all lessons for a subject (flattened)
export const getAllLessonsForSubject = (subject: Subject) => {
  return subject.units.flatMap(unit => 
    unit.lessons.map(lesson => ({
      ...lesson,
      unitId: unit.id,
      unitTitle: unit.title
    }))
  );
};
