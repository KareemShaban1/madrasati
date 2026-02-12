import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Lesson } from "@/data/curriculum";
import { Play, CheckCircle2, Lock, Clock, ChevronLeft } from "lucide-react";

interface LessonsListProps {
  lessons: Lesson[];
  subjectColor: string;
  subjectId: string;
}

const LessonsList = ({ lessons, subjectColor, subjectId }: LessonsListProps) => {
  const getStatusIcon = (status: Lesson["status"]) => {
    switch (status) {
      case "completed":
        return <CheckCircle2 className="w-5 h-5 text-secondary" />;
      case "in-progress":
        return <Play className="w-5 h-5 text-primary" />;
      case "locked":
        return <Lock className="w-5 h-5 text-muted-foreground" />;
    }
  };

  const getStatusStyles = (status: Lesson["status"]) => {
    switch (status) {
      case "completed":
        return "bg-secondary/10 border-secondary/30 hover:border-secondary/50";
      case "in-progress":
        return "bg-primary/5 border-primary/30 hover:border-primary/50 shadow-soft";
      case "locked":
        return "bg-muted/50 border-border opacity-60 cursor-not-allowed";
    }
  };

  return (
    <div className="bg-card rounded-2xl border border-border/50 shadow-card overflow-hidden">
      {/* Header */}
      <div className="p-6 border-b border-border">
        <div className="flex items-center justify-between">
          <h2 className="text-xl font-bold text-foreground arabic-text">الدروس</h2>
          <span className="text-sm text-muted-foreground">
            {lessons.filter(l => l.status === "completed").length} / {lessons.length} مكتمل
          </span>
        </div>
      </div>

      {/* Lessons List */}
      <div className="divide-y divide-border">
        {lessons.map((lesson) => {
          const content = (
            <>
              {/* Order Number */}
              <div className={`
                w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0
                ${lesson.status === "completed" ? "bg-secondary/20 text-secondary" : 
                  lesson.status === "in-progress" ? "gradient-hero text-primary-foreground" : 
                  "bg-muted text-muted-foreground"}
              `}>
                {lesson.status === "completed" ? (
                  <CheckCircle2 className="w-5 h-5" />
                ) : (
                  lesson.order
                )}
              </div>

              {/* Content */}
              <div className="flex-1 min-w-0">
                <h3 className="font-semibold text-foreground arabic-text truncate">
                  {lesson.title}
                </h3>
                <p className="text-sm text-muted-foreground truncate">
                  {lesson.titleEn}
                </p>
              </div>

              {/* Duration */}
              <div className="hidden sm:flex items-center gap-1 text-sm text-muted-foreground">
                <Clock className="w-4 h-4" />
                <span>{lesson.duration}</span>
              </div>

              {/* Action Button */}
              {lesson.status !== "locked" && (
                <span 
                  className={`shrink-0 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl text-sm font-medium h-9 px-4 ${
                    lesson.status === "in-progress" 
                      ? "gradient-hero text-primary-foreground shadow-glow" 
                      : "bg-primary/10 text-primary hover:bg-primary/20"
                  }`}
                >
                  {lesson.status === "in-progress" ? (
                    <>
                      <Play className="w-4 h-4" />
                      <span className="hidden sm:inline">استمر</span>
                    </>
                  ) : (
                    <>
                      <span className="hidden sm:inline">مراجعة</span>
                      <ChevronLeft className="w-4 h-4" />
                    </>
                  )}
                </span>
              )}

              {lesson.status === "locked" && (
                <Lock className="w-5 h-5 text-muted-foreground shrink-0" />
              )}
            </>
          );

          const className = `p-4 md:p-6 flex items-center gap-4 transition-all duration-300 border-r-4 ${getStatusStyles(lesson.status)}`;
          const style = { borderRightColor: lesson.status === "in-progress" ? subjectColor : "transparent" };

          return lesson.status !== "locked" ? (
            <Link
              key={lesson.id}
              to={`/lesson/${subjectId}/${lesson.id}`}
              className={className}
              style={style}
            >
              {content}
            </Link>
          ) : (
            <div
              key={lesson.id}
              className={className}
              style={style}
            >
              {content}
            </div>
          );
        })}
      </div>
    </div>
  );
};

export default LessonsList;
