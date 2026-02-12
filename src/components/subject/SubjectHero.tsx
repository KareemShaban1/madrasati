import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { ChevronRight, Play, BookOpen } from "lucide-react";
import { Subject } from "@/data/curriculum";

interface SubjectHeroProps {
  subject: Subject;
}

const SubjectHero = ({ subject }: SubjectHeroProps) => {
  const Icon = subject.icon;
  
  return (
    <section className="relative bg-muted pt-8 pb-16 overflow-hidden">
      {/* Background Pattern */}
      <div className="absolute inset-0 bg-hero-pattern opacity-30" />
      
      <div className="container mx-auto px-4 relative z-10">
        {/* Breadcrumb */}
        <nav className="flex items-center gap-2 text-sm text-muted-foreground mb-6">
          <Link to="/" className="hover:text-foreground transition-colors">الرئيسية</Link>
          <ChevronRight className="w-4 h-4 rotate-180" />
          <Link to="/#subjects" className="hover:text-foreground transition-colors">المواد الدراسية</Link>
          <ChevronRight className="w-4 h-4 rotate-180" />
          <span className="text-foreground font-medium">{subject.name}</span>
        </nav>

        <div className="flex flex-col md:flex-row items-start gap-8">
          {/* Icon */}
          <div 
            className="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center shadow-lg animate-float"
            style={{ background: subject.color }}
          >
            <Icon className="w-10 h-10 md:w-12 md:h-12 text-primary-foreground" />
          </div>

          {/* Content */}
          <div className="flex-1">
            <div className="flex items-center gap-3 mb-2">
              <h1 className="text-3xl md:text-4xl font-bold text-foreground arabic-text">
                {subject.name}
              </h1>
            </div>
            
            <p className="text-lg text-muted-foreground mb-6 arabic-text">
              {subject.description}
            </p>

            <div className="flex flex-wrap items-center gap-4">
              <Button variant="hero" size="lg" className="group">
                <Play className="w-5 h-5" />
                <span>استمر في التعلم</span>
              </Button>
              <Button variant="outline" size="lg">
                <BookOpen className="w-5 h-5" />
                <span>تصفح كل الدروس</span>
              </Button>
            </div>
          </div>

          {/* Quick Stats */}
          <div className="hidden lg:flex flex-col gap-3 bg-card rounded-2xl p-6 shadow-card border border-border/50 min-w-[200px]">
            <div className="text-center pb-3 border-b border-border">
              <div className="text-3xl font-bold text-gradient">{subject.progress.overallPercent}%</div>
              <div className="text-sm text-muted-foreground">نسبة الإنجاز</div>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">الدروس</span>
              <span className="font-semibold">{subject.progress.lessonsCompleted}/{subject.progress.totalLessons}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">التمارين</span>
              <span className="font-semibold">{subject.progress.exercisesCompleted}/{subject.progress.totalExercises}</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default SubjectHero;
