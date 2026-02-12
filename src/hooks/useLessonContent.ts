import { useQuery } from "@tanstack/react-query";
import { fetchLessonContent } from "@/lib/api";
import type { LessonContent as LessonContentType } from "@/data/lessonContent";

export function useLessonContent(subjectCode: string | undefined, lessonCode: string | undefined) {
  const query = useQuery({
    queryKey: ["lessonContent", subjectCode, lessonCode],
    queryFn: () =>
      subjectCode && lessonCode
        ? fetchLessonContent(subjectCode, lessonCode)
        : Promise.resolve(null),
    enabled: Boolean(subjectCode && lessonCode),
  });

  const raw = query.data;
  const lessonContent: LessonContentType | null = raw
    ? {
        lessonId: raw.lessonId,
        subjectId: raw.subjectId,
        sections: raw.sections ?? [],
        quickQuiz: (raw.quickQuiz ?? []).map((q) => ({
          id: q.id,
          question: q.question,
          options: q.options ?? [],
          correctIndex: typeof q.correctIndex === "number" ? q.correctIndex : 0,
          explanation: q.explanation ?? "",
        })),
        keyPoints: raw.keyPoints ?? [],
        prevLessonId: raw.prevLessonId ?? undefined,
        nextLessonId: raw.nextLessonId ?? undefined,
      }
    : null;

  return {
    lessonContent,
    isLoading: query.isLoading,
    isError: query.isError,
    error: query.error,
  };
}
