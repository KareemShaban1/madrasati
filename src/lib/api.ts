/**
 * API client for backend (dashboard/database).
 * Public curriculum and lesson content – no auth required.
 * Set VITE_API_URL to your backend URL when frontend and backend run on different origins (e.g. http://localhost:8000).
 */
const API_BASE = (import.meta.env.VITE_API_URL ?? "").replace(/\/$/, "");

function getApiUrl(path: string): string {
  return `${API_BASE}/api${path.startsWith("/") ? path : `/${path}`}`;
}

export async function fetchCurriculum(): Promise<CurriculumApiStage[]> {
  const res = await fetch(getApiUrl("/public/curriculum"));
  if (!res.ok) throw new Error("Failed to fetch curriculum");
  return res.json();
}

export async function fetchLessonContent(
  subjectCode: string,
  lessonCode: string
): Promise<LessonContentApi | null> {
  const params = new URLSearchParams({
    subject_code: subjectCode,
    lesson_code: lessonCode,
  });
  const res = await fetch(getApiUrl(`/public/lesson-content?${params}`));
  if (!res.ok) throw new Error("Failed to fetch lesson content");
  const data = await res.json();
  return data as LessonContentApi | null;
}

/** API response types (snake_case / backend shape) */
export interface CurriculumApiStage {
  id: string;
  name: string;
  nameEn: string;
  description: string;
  ageRange: string;
  colorClass: string;
  grades: CurriculumApiGrade[];
}

export interface CurriculumApiGrade {
  id: string;
  name: string;
  nameEn: string;
  order: number;
  subjects: CurriculumApiSubject[];
}

export interface CurriculumApiSubject {
  id: string;
  name: string;
  nameEn: string;
  icon: string;
  color: string;
  colorClass: string;
  description: string;
  units: CurriculumApiUnit[];
  exercises: unknown[];
  progress: CurriculumApiProgress;
}

export interface CurriculumApiUnit {
  id: string;
  title: string;
  titleEn: string;
  description: string;
  order: number;
  lessons: CurriculumApiLesson[];
}

export interface CurriculumApiLesson {
  id: string;
  title: string;
  titleEn: string;
  duration: string;
  status: "completed" | "in-progress" | "locked";
  order: number;
}

export interface CurriculumApiProgress {
  overallPercent: number;
  lessonsCompleted: number;
  totalLessons: number;
  exercisesCompleted: number;
  totalExercises: number;
  averageScore: number;
  streak: number;
  timeSpent: string;
}

export interface LessonContentApi {
  lessonId: string;
  subjectId: string;
  title?: string;
  title_en?: string;
  objectives?: string[];
  sections: LessonSectionApi[];
  quickQuiz: QuickQuizApi[];
  keyPoints: string[];
  prevLessonId?: string | null;
  nextLessonId?: string | null;
}

export interface LessonSectionApi {
  id?: string;
  type: string;
  title: string;
  content?: string;
  videoUrl?: string;
  steps?: { id: string; title: string; content: string; emoji?: string }[];
  items?: { id: string; question: string; answer: string; hint?: string }[];
  characterName?: string;
  characterEmoji?: string;
  visualType?: string;
  interactiveType?: string;
}

export interface QuickQuizApi {
  id: string;
  question: string;
  options: string[];
  correctIndex: number;
  explanation: string;
}
