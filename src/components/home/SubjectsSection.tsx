import { Link } from "react-router-dom";
import { BookOpen } from "lucide-react";
import { useCurriculum } from "@/hooks/useCurriculum";
import { Skeleton } from "@/components/ui/skeleton";
import type { Stage } from "@/data/curriculum";

function getUniqueSubjects(curriculumData: Stage[]) {
  const subjectMap = new Map<string, Stage["grades"][0]["subjects"][0] & { stageId: string; gradeId: string; lessonsCount: number }>();
  curriculumData.forEach((stage) => {
    stage.grades.forEach((grade) => {
      grade.subjects.forEach((subject) => {
        const baseId = subject.name;
        if (!subjectMap.has(baseId)) {
          subjectMap.set(baseId, {
            ...subject,
            stageId: stage.id,
            gradeId: grade.id,
            lessonsCount: subject.units.reduce((sum, u) => sum + u.lessons.length, 0),
          });
        }
      });
    });
  });
  return Array.from(subjectMap.values()).slice(0, 8);
}

const SubjectsSection = () => {
  const { curriculumData, isLoading } = useCurriculum();
  const subjects = getUniqueSubjects(curriculumData);

  if (isLoading) {
    return (
      <section id="subjects" className="py-20 bg-muted">
        <div className="container mx-auto px-4">
          <Skeleton className="h-10 w-64 mx-auto mb-4" />
          <Skeleton className="h-6 w-96 mx-auto mb-12" />
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[1, 2, 3, 4, 5, 6, 7, 8].map((i) => (
              <Skeleton key={i} className="h-40 rounded-2xl" />
            ))}
          </div>
        </div>
      </section>
    );
  }

  return (
    <section id="subjects" className="py-12 sm:py-20 bg-muted">
      <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
        {/* Section Header */}
        <div className="text-center mb-10 sm:mb-14">
          <h2 className="text-2xl sm:text-3xl md:text-4xl font-bold text-foreground mb-3 sm:mb-4 arabic-text">
            المواد الدراسية
          </h2>
          <p className="text-sm sm:text-base text-muted-foreground max-w-xl mx-auto arabic-text px-2">
            جميع المواد متوافقة مع المناهج المصرية الرسمية من وزارة التربية والتعليم
          </p>
        </div>

        {/* Subjects Grid */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
          {subjects.map((subject, index) => {
            const Icon = subject.icon;
            
            return (
              <Link
                to={`/stage/${subject.stageId}/grade/${subject.gradeId}/subject/${subject.id}`}
                key={subject.id}
                className="group relative p-4 sm:p-6 rounded-xl sm:rounded-2xl bg-card border border-border/50 shadow-soft hover:shadow-card card-lift cursor-pointer min-w-0 min-h-[44px]"
                style={{ animationDelay: `${index * 0.1}s` }}
              >
                {/* Icon */}
                <div 
                  className="w-10 h-10 sm:w-14 sm:h-14 rounded-lg sm:rounded-xl border flex items-center justify-center mb-3 sm:mb-4 transition-transform group-hover:scale-110 shrink-0"
                  style={{ 
                    backgroundColor: `${subject.color}15`,
                    borderColor: `${subject.color}30`,
                    color: subject.color
                  }}
                >
                  <Icon className="w-5 h-5 sm:w-7 sm:h-7" />
                </div>

                {/* Content */}
                <h3 className="font-bold text-foreground mb-1 arabic-text text-sm sm:text-base truncate">{subject.name}</h3>
                <p className="text-xs text-muted-foreground mb-3">{subject.nameEn}</p>
                
                {/* Lessons Count */}
                <div className="flex items-center gap-1 text-xs text-muted-foreground">
                  <BookOpen className="w-3 h-3" />
                  <span>{subject.lessonsCount} درس</span>
                </div>

                {/* Hover Overlay */}
                <div className="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" />
              </Link>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default SubjectsSection;
