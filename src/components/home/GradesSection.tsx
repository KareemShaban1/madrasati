import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { ChevronLeft, GraduationCap, BookMarked, Award } from "lucide-react";
import { useCurriculum } from "@/hooks/useCurriculum";
import { Skeleton } from "@/components/ui/skeleton";

const iconMap: Record<string, typeof BookMarked> = {
  primary: BookMarked,
  preparatory: GraduationCap,
  secondary: Award,
};

const stageHeaderBg: Record<string, string> = {
  primary: "linear-gradient(135deg, hsl(38 92% 50%) 0%, hsl(25 90% 55%) 50%, hsl(15 85% 60%) 100%)",
  preparatory: "linear-gradient(135deg, hsl(175 45% 40%) 0%, hsl(190 50% 45%) 100%)",
  secondary: "linear-gradient(135deg, hsl(15 85% 55%) 0%, hsl(25 90% 50%) 100%)",
};

const GradesSection = () => {
  const { curriculumData, isLoading } = useCurriculum();

  if (isLoading) {
    return (
      <section id="grades" className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <Skeleton className="h-10 w-64 mx-auto mb-4" />
          <Skeleton className="h-6 w-96 mx-auto mb-14" />
          <div className="grid md:grid-cols-3 gap-6">
            {[1, 2, 3].map((i) => (
              <Skeleton key={i} className="h-64 rounded-2xl" />
            ))}
          </div>
        </div>
      </section>
    );
  }

  return (
    <section id="grades" className="py-12 sm:py-20 bg-background">
      <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
        {/* Section Header */}
        <div className="text-center mb-10 sm:mb-14">
          <h2 className="text-2xl sm:text-3xl md:text-4xl font-bold text-foreground mb-3 sm:mb-4 arabic-text">
            المراحل التعليمية
          </h2>
          <p className="text-sm sm:text-base text-muted-foreground max-w-xl mx-auto arabic-text px-2">
            نغطي جميع المراحل الدراسية في النظام التعليمي المصري
          </p>
        </div>

        {/* Grades Grid */}
        <div className="grid md:grid-cols-3 gap-6">
          {curriculumData.map((stage) => {
            const Icon = iconMap[stage.id as keyof typeof iconMap] || BookMarked;
            
            return (
              <div
                key={stage.id}
                className="group relative rounded-2xl bg-card border border-border/50 shadow-card overflow-hidden hover:shadow-hover card-lift"
              >
                {/* Header */}
                <div
                  className="p-4 sm:p-6 text-primary-foreground"
                  style={{ background: stageHeaderBg[stage.id] ?? stageHeaderBg.primary }}
                >
                  <div className="flex items-center justify-between mb-3 sm:mb-4">
                    <Icon className="w-8 h-8 sm:w-10 sm:h-10" />
                    <span className="text-xs sm:text-sm opacity-80">{stage.ageRange}</span>
                  </div>
                  <h3 className="text-lg sm:text-xl font-bold arabic-text">{stage.name}</h3>
                  <p className="text-xs sm:text-sm opacity-80">{stage.nameEn}</p>
                </div>

                {/* Content */}
                <div className="p-4 sm:p-6">
                  <p className="text-sm text-muted-foreground mb-4 arabic-text">
                    {stage.description}
                  </p>
                  
                  {/* Grades List */}
                  <div className="space-y-2 mb-6">
                    {stage.grades.map((grade) => (
                      <Link 
                        key={grade.id}
                        to={`/stage/${stage.id}/grade/${grade.id}`}
                        className="flex items-center gap-2 text-sm text-foreground hover:text-primary transition-colors arabic-text"
                      >
                        <span className="w-2 h-2 rounded-full bg-primary/50" />
                        {grade.name}
                      </Link>
                    ))}
                  </div>

                  {/* CTA */}
                  <Link to={`/stage/${stage.id}`}>
                    <Button variant="soft" className="w-full group/btn">
                      <span>استكشف المرحلة</span>
                      <ChevronLeft className="w-4 h-4 transition-transform group-hover/btn:-translate-x-1" />
                    </Button>
                  </Link>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default GradesSection;
