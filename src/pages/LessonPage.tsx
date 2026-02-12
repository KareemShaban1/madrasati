import { useParams } from "react-router-dom";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import LessonHeader from "@/components/lesson/LessonHeader";
import LessonVideo from "@/components/lesson/LessonVideo";
import LessonContent from "@/components/lesson/LessonContent";
import LessonQuiz from "@/components/lesson/LessonQuiz";
import LessonSidebar from "@/components/lesson/LessonSidebar";
import LessonNavigation from "@/components/lesson/LessonNavigation";
import AchievementsPanel from "@/components/gamification/AchievementsPanel";
import { useCurriculum } from "@/hooks/useCurriculum";
import { useLessonContent } from "@/hooks/useLessonContent";
import { Skeleton } from "@/components/ui/skeleton";

const LessonPage = () => {
  const { stageId, gradeId, subjectId, unitId, lessonId } = useParams<{
    stageId?: string;
    gradeId?: string;
    subjectId?: string;
    unitId?: string;
    lessonId?: string;
  }>();

  const { curriculumData, findStage, findGrade, findSubject, findUnit, getAllLessonsForSubject, getLessonContext, isLoading: curriculumLoading } = useCurriculum();

  const isShortUrl = !stageId && subjectId && lessonId;
  const contextFromShort = isShortUrl && subjectId && lessonId ? getLessonContext(subjectId, lessonId) : null;

  const stage = contextFromShort ? contextFromShort.stage : (findStage(stageId || "") || curriculumData[0]);
  const grade = contextFromShort ? contextFromShort.grade : (findGrade(stageId || "", gradeId || "") || stage?.grades?.[0]);
  const subject = contextFromShort ? contextFromShort.subject : (findSubject(stageId || "", gradeId || "", subjectId || "") || grade?.subjects?.[0]);
  const unit = contextFromShort ? contextFromShort.unit : (subject ? findUnit(stageId || "", gradeId || "", subjectId || "", unitId || "") || subject.units[0] : null);
  const lesson = contextFromShort ? contextFromShort.lesson : (unit ? (unit.lessons.find((l) => l.id === lessonId) || unit.lessons[0]) : null);
  const allLessons = subject ? getAllLessonsForSubject(subject) : [];
  const { lessonContent, isLoading: contentLoading } = useLessonContent(subject?.id, lesson?.id);
  const isLoading = curriculumLoading || contentLoading;

  const basePath = `/stage/${stage?.id}/grade/${grade?.id}/subject/${subject?.id}`;

  if (isLoading && !subject) {
    return (
      <div className="min-h-screen bg-background" dir="rtl">
        <Header />
        <main className="pt-16 container mx-auto px-4 py-8">
          <Skeleton className="h-24 w-full mb-8" />
          <div className="grid lg:grid-cols-3 gap-8">
            <Skeleton className="lg:col-span-2 h-96 rounded-2xl" />
            <Skeleton className="h-64 rounded-2xl" />
          </div>
        </main>
      </div>
    );
  }
  if (!subject || !unit || !lesson) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center" dir="rtl">
        <p className="text-muted-foreground">الدرس غير موجود</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background overflow-x-hidden" dir="rtl">
      <Header />
      <main className="pt-16">
        <LessonHeader 
          subject={{
            id: subject.id,
            name: subject.name,
            nameEn: subject.nameEn,
            icon: subject.icon,
            color: subject.color,
            grade: grade.name
          }} 
          lesson={lesson} 
        />
        
        <div className="container mx-auto px-4 sm:px-6 max-w-7xl py-6 sm:py-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            {/* Main Content - order so sidebar appears below on mobile */}
            <div className="lg:col-span-2 space-y-6 sm:space-y-8 min-w-0">
              {/* Video Player */}
              <LessonVideo 
                title={lesson.title}
                videoUrl={lessonContent?.sections.find(s => s.type === "video")?.videoUrl}
              />
              
              {/* Content Sections */}
              {lessonContent && (
                <LessonContent sections={lessonContent.sections.filter(s => s.type !== "video")} />
              )}
              
              {/* Quick Quiz */}
              {lessonContent && lessonContent.quickQuiz.length > 0 && (
                <LessonQuiz quiz={lessonContent.quickQuiz} />
              )}
              
              {/* Navigation */}
              <LessonNavigation 
                subjectId={subject.id}
                prevLessonId={lessonContent?.prevLessonId}
                nextLessonId={lessonContent?.nextLessonId}
                lessons={allLessons}
                basePath={basePath}
                currentUnitId={unit.id}
                lessonTitle={lesson.title}
              />
            </div>
            
            {/* Sidebar */}
            <div className="space-y-6">
              <LessonSidebar 
                keyPoints={lessonContent?.keyPoints || []}
                lesson={lesson}
                totalLessons={allLessons.length}
              />
              <AchievementsPanel />
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default LessonPage;
