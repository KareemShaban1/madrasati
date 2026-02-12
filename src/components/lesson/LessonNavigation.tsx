import { useState } from "react";
import { Link } from "react-router-dom";
import { ArrowRight, ArrowLeft, CheckCircle2, Sparkles } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Lesson } from "@/data/curriculum";
import { useGamification } from "@/contexts/GamificationContext";
import LessonCompleteCard from "@/components/gamification/LessonCompleteCard";
import confetti from "canvas-confetti";

interface ExtendedLesson extends Lesson {
  unitId?: string;
  unitTitle?: string;
}

interface LessonNavigationProps {
  subjectId: string;
  prevLessonId?: string;
  nextLessonId?: string;
  lessons: ExtendedLesson[];
  basePath?: string;
  currentUnitId?: string;
  lessonTitle?: string;
}

const LessonNavigation = ({ 
  subjectId, 
  prevLessonId, 
  nextLessonId, 
  lessons,
  basePath,
  currentUnitId,
  lessonTitle = "الدرس"
}: LessonNavigationProps) => {
  const [isCompleted, setIsCompleted] = useState(false);
  const { completeLesson } = useGamification();
  
  const prevLesson = lessons.find(l => l.id === prevLessonId);
  const nextLesson = lessons.find(l => l.id === nextLessonId);

  const getLessonPath = (lesson: ExtendedLesson | undefined, lessonId?: string) => {
    if (!lesson || !lessonId) return "#";
    return `/lesson/${subjectId}/${lessonId}`;
  };

  const handleComplete = () => {
    completeLesson(`${subjectId}-${currentUnitId}`);
    setIsCompleted(true);
    
    // Trigger confetti
    confetti({
      particleCount: 100,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#f59e0b', '#14b8a6', '#f97316'],
    });
  };

  const nextLessonPath = nextLesson ? getLessonPath(nextLesson, nextLessonId) : undefined;
  const subjectPath = basePath ?? `/stage/primary/grade/primary-1/subject/${subjectId}`;

  if (isCompleted) {
    return (
      <LessonCompleteCard
        lessonTitle={lessonTitle}
        nextLessonPath={nextLessonPath}
        subjectPath={subjectPath}
      />
    );
  }

  return (
    <div className="bg-card rounded-xl sm:rounded-2xl border border-border/50 shadow-card p-4 sm:p-6">
      <div className="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4">
        {/* Previous Lesson */}
        {prevLesson ? (
          <Link 
            to={getLessonPath(prevLesson, prevLessonId)}
            className="flex-1 min-w-0 order-2 sm:order-1"
          >
            <Button variant="outline" className="w-full gap-2 justify-start min-h-[44px]">
              <ArrowRight className="w-4 h-4 shrink-0" />
              <div className="text-right min-w-0">
                <span className="text-xs text-muted-foreground block">الدرس السابق</span>
                <span className="text-sm truncate block">{prevLesson.title}</span>
              </div>
            </Button>
          </Link>
        ) : (
          <div className="flex-1 hidden sm:block" />
        )}

        {/* Complete Button */}
        <Button 
          variant="hero" 
          size="lg" 
          className="gap-2 shrink-0 order-1 sm:order-2 min-h-[44px]"
          onClick={handleComplete}
        >
          <CheckCircle2 className="w-5 h-5" />
          إكمال الدرس
          <Sparkles className="w-4 h-4" />
        </Button>

        {/* Next Lesson */}
        {nextLesson ? (
          <Link 
            to={getLessonPath(nextLesson, nextLessonId)}
            className="flex-1 min-w-0 order-3"
          >
            <Button variant="outline" className="w-full gap-2 justify-end min-h-[44px]">
              <div className="text-left min-w-0">
                <span className="text-xs text-muted-foreground block">الدرس التالي</span>
                <span className="text-sm truncate block">{nextLesson.title}</span>
              </div>
              <ArrowLeft className="w-4 h-4 shrink-0" />
            </Button>
          </Link>
        ) : (
          <div className="flex-1 hidden sm:block" />
        )}
      </div>
    </div>
  );
};

export default LessonNavigation;
