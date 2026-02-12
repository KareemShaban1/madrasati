import { useQuery } from "@tanstack/react-query";
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
  type LucideIcon,
} from "lucide-react";
import {
  fetchCurriculum,
  type CurriculumApiStage,
  type CurriculumApiSubject,
} from "@/lib/api";
import type { Stage, Grade, Subject, Unit, Lesson } from "@/data/curriculum";

const ICON_MAP: Record<string, LucideIcon> = {
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
  BookText: BookText,
};

function mapApiToStage(api: CurriculumApiStage): Stage {
  return {
    id: api.id,
    name: api.name,
    nameEn: api.nameEn,
    description: api.description ?? "",
    ageRange: api.ageRange ?? "",
    colorClass: api.colorClass ?? "gradient-hero",
    grades: api.grades.map((g) => ({
      id: g.id,
      name: g.name,
      nameEn: g.nameEn,
      order: g.order,
      subjects: g.subjects.map((s) => mapApiToSubject(s)),
    })),
  };
}

function mapApiToSubject(api: CurriculumApiSubject): Subject {
  const Icon = ICON_MAP[api.icon] ?? BookOpen;
  return {
    id: api.id,
    name: api.name,
    nameEn: api.nameEn,
    icon: Icon,
    color: api.color ?? "hsl(220 80% 55%)",
    colorClass: api.colorClass ?? "primary",
    description: api.description ?? "",
    units: api.units.map((u) => ({
      id: u.id,
      title: u.title,
      titleEn: u.titleEn,
      description: u.description ?? "",
      order: u.order,
      lessons: u.lessons.map((l) => ({
        id: l.id,
        title: l.title,
        titleEn: l.titleEn,
        duration: l.duration ?? "30 دقيقة",
        status: l.status ?? "locked",
        order: l.order,
      })),
    })),
    exercises: api.exercises ?? [],
    progress: api.progress ?? {
      overallPercent: 0,
      lessonsCompleted: 0,
      totalLessons: 0,
      exercisesCompleted: 0,
      totalExercises: 0,
      averageScore: 0,
      streak: 0,
      timeSpent: "0 ساعة",
    },
  };
}

export function useCurriculum() {
  const query = useQuery({
    queryKey: ["curriculum"],
    queryFn: fetchCurriculum,
    select: (data): Stage[] => data.map(mapApiToStage),
  });

  const curriculumData = query.data ?? [];
  const findStage = (stageId: string) =>
    curriculumData.find((s) => s.id === stageId);
  const findGrade = (stageId: string, gradeId: string) => {
    const stage = findStage(stageId);
    return stage?.grades.find((g) => g.id === gradeId);
  };
  const findSubject = (
    stageId: string,
    gradeId: string,
    subjectId: string
  ) => {
    const grade = findGrade(stageId, gradeId);
    return grade?.subjects.find((s) => s.id === subjectId);
  };
  const findUnit = (
    stageId: string,
    gradeId: string,
    subjectId: string,
    unitId: string
  ) => {
    const subject = findSubject(stageId, gradeId, subjectId);
    return subject?.units.find((u) => u.id === unitId);
  };
  const findLesson = (
    stageId: string,
    gradeId: string,
    subjectId: string,
    unitId: string,
    lessonId: string
  ) => {
    const unit = findUnit(stageId, gradeId, subjectId, unitId);
    return unit?.lessons.find((l) => l.id === lessonId);
  };
  const getAllLessonsForSubject = (subject: Subject) =>
    subject.units.flatMap((unit) =>
      unit.lessons.map((lesson) => ({
        ...lesson,
        unitId: unit.id,
        unitTitle: unit.title,
      }))
    );

  /** Resolve stage, grade, subject, unit, lesson by subject code + lesson code (for short URL /lesson/:subjectId/:lessonId) */
  const getLessonContext = (
    subjectCode: string,
    lessonCode: string
  ): {
    stage: Stage;
    grade: Stage["grades"][0];
    subject: Subject;
    unit: Subject["units"][0];
    lesson: Lesson;
  } | null => {
    for (const stage of curriculumData) {
      for (const grade of stage.grades) {
        const subject = grade.subjects.find((s) => s.id === subjectCode);
        if (!subject) continue;
        for (const unit of subject.units) {
          const lesson = unit.lessons.find((l) => l.id === lessonCode);
          if (lesson) return { stage, grade, subject, unit, lesson };
        }
      }
    }
    return null;
  };

  return {
    curriculumData,
    findStage,
    findGrade,
    findSubject,
    findUnit,
    findLesson,
    getAllLessonsForSubject,
    getLessonContext,
    isLoading: query.isLoading,
    isError: query.isError,
    error: query.error,
  };
}
