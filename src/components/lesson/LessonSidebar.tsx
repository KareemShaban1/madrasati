import { Bookmark, Clock, Trophy, Target, Lightbulb } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Progress } from "@/components/ui/progress";
import { Lesson } from "@/data/curriculum";

interface LessonSidebarProps {
  keyPoints: string[];
  lesson: Lesson;
  totalLessons: number;
}

const LessonSidebar = ({ keyPoints, lesson, totalLessons }: LessonSidebarProps) => {
  const progressPercent = Math.round((lesson.order / totalLessons) * 100);

  return (
    <div className="space-y-4 sm:space-y-6 min-w-0">
      {/* Lesson Progress Card */}
      <div className="bg-card rounded-xl sm:rounded-2xl border border-border/50 shadow-card p-4 sm:p-6 ring-1 ring-border/30">
        <div className="flex items-center gap-3 mb-3 sm:mb-4">
          <div className="w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-primary/20 flex items-center justify-center shrink-0">
            <Target className="w-4 h-4 sm:w-5 sm:h-5 text-primary" />
          </div>
          <div className="min-w-0">
            <h3 className="font-bold text-foreground arabic-text text-sm sm:text-base">تقدمك في المادة</h3>
            <p className="text-xs sm:text-sm text-muted-foreground">الدرس {lesson.order} من {totalLessons}</p>
          </div>
        </div>
        
        <Progress value={progressPercent} className="h-3 mb-2" />
        <p className="text-xs sm:text-sm text-muted-foreground text-left">{progressPercent}%</p>
      </div>

      {/* Key Points Card */}
      {keyPoints.length > 0 && (
        <div className="bg-card rounded-xl sm:rounded-2xl border border-border/50 shadow-card overflow-hidden ring-1 ring-border/30">
          <div className="p-3 sm:p-4 border-b border-border bg-gradient-to-l from-secondary/10 to-transparent">
            <div className="flex items-center gap-3 min-w-0">
              <div className="w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-secondary/20 flex items-center justify-center shrink-0">
                <Lightbulb className="w-5 h-5 text-secondary" />
              </div>
              <h3 className="font-bold text-foreground arabic-text">النقاط الرئيسية</h3>
            </div>
          </div>
          
          <div className="p-4 space-y-3">
            {keyPoints.map((point, idx) => (
              <div key={idx} className="flex items-start gap-3">
                <span className="w-6 h-6 rounded-lg bg-secondary/20 flex items-center justify-center text-secondary text-xs font-bold shrink-0 mt-0.5">
                  {idx + 1}
                </span>
                <p className="text-sm text-foreground/80 arabic-text leading-relaxed">{point}</p>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Quick Stats */}
      <div className="bg-card rounded-xl sm:rounded-2xl border border-border/50 shadow-card p-4 sm:p-6 ring-1 ring-border/30">
        <h3 className="font-bold text-foreground arabic-text mb-3 sm:mb-4 text-sm sm:text-base">معلومات الدرس</h3>
        
        <div className="space-y-3 sm:space-y-4">
          <div className="flex items-center gap-3">
            <div className="w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-muted flex items-center justify-center shrink-0">
              <Clock className="w-4 h-4 sm:w-5 sm:h-5 text-muted-foreground" />
            </div>
            <div className="min-w-0">
              <p className="text-xs sm:text-sm text-muted-foreground">المدة</p>
              <p className="font-semibold text-foreground">{lesson.duration}</p>
            </div>
          </div>

          <div className="flex items-center gap-3">
            <div className="w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-muted flex items-center justify-center shrink-0">
              <Trophy className="w-4 h-4 sm:w-5 sm:h-5 text-muted-foreground" />
            </div>
            <div className="min-w-0">
              <p className="text-xs sm:text-sm text-muted-foreground">الحالة</p>
              <p className="font-semibold text-foreground">
                {lesson.status === "completed" ? "مكتمل" : 
                 lesson.status === "in-progress" ? "قيد الدراسة" : "مقفل"}
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Bookmark Button */}
      <Button variant="outline" className="w-full gap-2 min-h-[44px]">
        <Bookmark className="w-4 h-4 shrink-0" />
        حفظ للمراجعة
      </Button>
    </div>
  );
};

export default LessonSidebar;
