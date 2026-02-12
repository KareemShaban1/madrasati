import { useParams, Link } from "react-router-dom";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useCurriculum } from "@/hooks/useCurriculum";
import { Button } from "@/components/ui/button";
import { ChevronLeft, BookOpen, Clock, TrendingUp } from "lucide-react";
import { Progress } from "@/components/ui/progress";
import { Skeleton } from "@/components/ui/skeleton";

const GradePage = () => {
  const { stageId, gradeId } = useParams<{ stageId: string; gradeId: string }>();
  const { curriculumData, findStage, findGrade, isLoading } = useCurriculum();
  const stage = findStage(stageId || "") || curriculumData[0];
  const grade = findGrade(stageId || "", gradeId || "") || (stage?.grades?.[0]);

  if (isLoading) {
    return (
      <div className="min-h-screen bg-background" dir="rtl">
        <Header />
        <main className="pt-16 container mx-auto px-4 py-16">
          <Skeleton className="h-12 w-64 mb-4" />
          <Skeleton className="h-16 w-full mb-8" />
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {[1, 2, 3, 4].map((i) => (
              <Skeleton key={i} className="h-40 rounded-2xl" />
            ))}
          </div>
        </main>
      </div>
    );
  }
  if (!stage || !grade) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center" dir="rtl">
        <p className="text-muted-foreground">{!stage ? "المرحلة غير موجودة" : "الصف غير موجود"}</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background overflow-x-hidden" dir="rtl">
      <Header />
      <main className="pt-16">
        {/* Hero Section */}
        <section className={`${stage.colorClass} py-12 sm:py-20 text-primary-foreground relative overflow-hidden`}>
          <div className="absolute inset-0 opacity-10">
            <div className="absolute top-0 left-0 w-64 h-64 rounded-full blur-3xl bg-white" />
            <div className="absolute bottom-0 right-0 w-48 h-48 rounded-full blur-3xl bg-white" />
          </div>
          <div className="container mx-auto px-4 sm:px-6 max-w-7xl relative z-10">
            <nav className="flex flex-wrap items-center gap-2 text-xs sm:text-sm opacity-90 mb-5">
              <Link to="/" className="hover:opacity-100 transition-opacity">الرئيسية</Link>
              <ChevronLeft className="w-4 h-4 shrink-0 rtl:rotate-180" />
              <Link to={`/stage/${stage.id}`} className="hover:opacity-100 transition-opacity">{stage.name}</Link>
              <ChevronLeft className="w-4 h-4 shrink-0 rtl:rotate-180" />
              <span className="truncate font-medium">{grade.name}</span>
            </nav>
            <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4 arabic-text">
              {grade.name}
            </h1>
            <p className="text-lg sm:text-xl opacity-90">{grade.nameEn}</p>
            <div className="flex flex-wrap items-center gap-4 sm:gap-6 mt-4 sm:mt-6">
              <div className="flex items-center gap-2">
                <BookOpen className="w-5 h-5 shrink-0" />
                <span>{grade.subjects.length} مادة دراسية</span>
              </div>
            </div>
          </div>
        </section>

        {/* Subjects Grid */}
        <section className="py-10 sm:py-16">
          <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
            <h2 className="text-xl sm:text-2xl font-bold text-foreground mb-6 sm:mb-8 arabic-text">
              المواد الدراسية
            </h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
              {grade.subjects.map((subject, idx) => {
                const Icon = subject.icon;
                const totalLessons = subject.units.reduce(
                  (sum, unit) => sum + unit.lessons.length,
                  0
                );

                return (
                  <Link
                    key={subject.id}
                    to={`/stage/${stage.id}/grade/${grade.id}/subject/${subject.id}`}
                    className="group block animate-fade-in-up opacity-0 h-full"
                    style={{ animationDelay: `${idx * 0.06}s`, animationFillMode: "forwards" }}
                  >
                    <div className="rounded-2xl bg-card border border-border/50 shadow-card overflow-hidden hover:shadow-hover hover:border-primary/30 card-lift h-full">
                      <div
                        className="p-6"
                        style={{ backgroundColor: subject.color }}
                      >
                        <div className="flex items-center justify-between text-white">
                          <Icon className="w-10 h-10" />
                          <span className="text-sm opacity-80">
                            {subject.units.length} وحدات
                          </span>
                        </div>
                        <h3 className="text-xl font-bold text-white mt-4 arabic-text">
                          {subject.name}
                        </h3>
                        <p className="text-sm text-white/80">{subject.nameEn}</p>
                      </div>
                      <div className="p-6">
                        <p className="text-sm text-muted-foreground mb-4 arabic-text">
                          {subject.description}
                        </p>

                        {/* Stats */}
                        <div className="grid grid-cols-2 gap-4 mb-4">
                          <div className="flex items-center gap-2 text-sm text-muted-foreground">
                            <BookOpen className="w-4 h-4" />
                            <span>{totalLessons} درس</span>
                          </div>
                          <div className="flex items-center gap-2 text-sm text-muted-foreground">
                            <Clock className="w-4 h-4" />
                            <span>{subject.progress.timeSpent}</span>
                          </div>
                        </div>

                        {/* Progress */}
                        <div className="mb-4">
                          <div className="flex items-center justify-between text-sm mb-2">
                            <span className="text-muted-foreground">التقدم</span>
                            <span className="font-medium text-foreground">
                              {subject.progress.overallPercent}%
                            </span>
                          </div>
                          <Progress
                            value={subject.progress.overallPercent}
                            className="h-2"
                          />
                        </div>

                        <Button variant="soft" className="w-full group/btn">
                          <span>ابدأ التعلم</span>
                          <ChevronLeft className="w-4 h-4 transition-transform group-hover/btn:-translate-x-1" />
                        </Button>
                      </div>
                    </div>
                  </Link>
                );
              })}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default GradePage;
