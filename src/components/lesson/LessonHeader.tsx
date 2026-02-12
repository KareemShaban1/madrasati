import { Link } from "react-router-dom";
import { ChevronLeft, Home } from "lucide-react";
import { LucideIcon } from "lucide-react";

interface LessonHeaderSubject {
  id: string;
  name: string;
  nameEn: string;
  icon: LucideIcon;
  color: string;
  grade?: string;
}

interface LessonHeaderLesson {
  id: string;
  title: string;
  titleEn: string;
  duration: string;
  order: number;
}

interface LessonHeaderProps {
  subject: LessonHeaderSubject;
  lesson: LessonHeaderLesson;
}

const LessonHeader = ({ subject, lesson }: LessonHeaderProps) => {
  const Icon = subject.icon;

  return (
    <div 
      className="relative py-10 sm:py-12 overflow-hidden"
      style={{ 
        background: `linear-gradient(135deg, ${subject.color}18 0%, ${subject.color}06 100%)` 
      }}
    >
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-5">
        <div className="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl"
          style={{ backgroundColor: subject.color }} 
        />
      </div>

      <div className="container mx-auto px-4 sm:px-6 max-w-7xl relative z-10">
        {/* Breadcrumb */}
        <nav className="flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-muted-foreground mb-3 sm:mb-4 min-w-0">
          <Link to="/" className="hover:text-foreground transition-colors flex items-center gap-1 shrink-0">
            <Home className="w-4 h-4" />
            <span>الرئيسية</span>
          </Link>
          <ChevronLeft className="w-4 h-4 shrink-0" />
          <span className="flex items-center gap-2 min-w-0 truncate max-w-[120px] sm:max-w-none">
            <Icon className="w-4 h-4 shrink-0" style={{ color: subject.color }} />
            <span className="truncate">{subject.name}</span>
          </span>
          <ChevronLeft className="w-4 h-4 shrink-0" />
          <span className="text-foreground font-medium truncate max-w-[140px] sm:max-w-none">{lesson.title}</span>
        </nav>

        {/* Lesson Info */}
        <div className="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
          <div 
            className="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shrink-0"
            style={{ backgroundColor: `${subject.color}20` }}
          >
            <span className="text-xl sm:text-2xl font-bold" style={{ color: subject.color }}>
              {lesson.order}
            </span>
          </div>
          
          <div className="min-w-0 flex-1">
            <h1 className="text-xl sm:text-2xl md:text-3xl font-bold text-foreground arabic-text mb-2 break-words">
              {lesson.title}
            </h1>
            <p className="text-muted-foreground">{lesson.titleEn}</p>
            <div className="flex items-center gap-4 mt-3 text-sm text-muted-foreground">
              <span className="flex items-center gap-1">
                <span className="w-2 h-2 rounded-full bg-secondary"></span>
                {lesson.duration}
              </span>
              {subject.grade && (
                <span className="flex items-center gap-1">
                  <span className="w-2 h-2 rounded-full" style={{ backgroundColor: subject.color }}></span>
                  {subject.grade}
                </span>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LessonHeader;
