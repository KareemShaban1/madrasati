import { useParams, Link } from "react-router-dom";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useCurriculum } from "@/hooks/useCurriculum";
import { Button } from "@/components/ui/button";
import { ChevronLeft, BookOpen, Users } from "lucide-react";
import { Skeleton } from "@/components/ui/skeleton";

const StagePage = () => {
  const { stageId } = useParams<{ stageId: string }>();
  const { curriculumData, findStage, isLoading } = useCurriculum();
  const stage = findStage(stageId || "") || curriculumData[0];

  if (isLoading) {
    return (
      <div className="min-h-screen bg-background overflow-x-hidden" dir="rtl">
        <Header />
        <main className="pt-16 container mx-auto px-4 py-16">
          <Skeleton className="h-12 w-64 mb-4" />
          <Skeleton className="h-16 w-full mb-8" />
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {[1, 2, 3].map((i) => (
              <Skeleton key={i} className="h-48 rounded-2xl" />
            ))}
          </div>
        </main>
      </div>
    );
  }
  if (!stage) {
    return (
      <div className="min-h-screen bg-background overflow-x-hidden flex items-center justify-center" dir="rtl">
        <p className="text-muted-foreground">المرحلة غير موجودة</p>
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
              <span className="truncate font-medium">{stage.name}</span>
            </nav>
            <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4 arabic-text drop-shadow-sm">
              {stage.name}
            </h1>
            <p className="text-lg sm:text-xl opacity-90 mb-2">{stage.nameEn}</p>
            <p className="text-base sm:text-lg opacity-80 max-w-2xl arabic-text">
              {stage.description}
            </p>
            <div className="flex flex-wrap items-center gap-4 sm:gap-6 mt-4 sm:mt-6">
              <div className="flex items-center gap-2">
                <BookOpen className="w-5 h-5" />
                <span>{stage.grades.length} صفوف دراسية</span>
              </div>
              <div className="flex items-center gap-2">
                <Users className="w-5 h-5" />
                <span>{stage.ageRange}</span>
              </div>
            </div>
          </div>
        </section>

        {/* Grades Grid */}
        <section className="py-10 sm:py-16">
          <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
            <h2 className="text-xl sm:text-2xl font-bold text-foreground mb-6 sm:mb-8 arabic-text">
              اختر الصف الدراسي
            </h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
              {stage.grades.map((grade, idx) => (
                <Link
                  key={grade.id}
                  to={`/stage/${stage.id}/grade/${grade.id}`}
                  className="group block animate-fade-in-up opacity-0"
                  style={{ animationDelay: `${idx * 0.06}s`, animationFillMode: "forwards" }}
                >
                  <div className="rounded-2xl bg-card border border-border/50 shadow-card overflow-hidden hover:shadow-hover hover:border-primary/30 card-lift min-w-0">
                    <div className={`${stage.colorClass} p-4 sm:p-6 text-primary-foreground`}>
                      <h3 className="text-lg sm:text-xl font-bold arabic-text">{grade.name}</h3>
                      <p className="text-sm opacity-80">{grade.nameEn}</p>
                    </div>
                    <div className="p-6">
                      <div className="flex items-center justify-between mb-4">
                        <span className="text-muted-foreground">
                          {grade.subjects.length} مادة دراسية
                        </span>
                      </div>
                      <div className="flex flex-wrap gap-2 mb-4">
                        {grade.subjects.slice(0, 4).map((subject) => (
                          <span
                            key={subject.id}
                            className="px-3 py-1 bg-muted rounded-full text-xs text-muted-foreground"
                          >
                            {subject.name}
                          </span>
                        ))}
                        {grade.subjects.length > 4 && (
                          <span className="px-3 py-1 bg-muted rounded-full text-xs text-muted-foreground">
                            +{grade.subjects.length - 4}
                          </span>
                        )}
                      </div>
                      <Button variant="soft" className="w-full group/btn">
                        <span>استكشف الصف</span>
                        <ChevronLeft className="w-4 h-4 transition-transform group-hover/btn:-translate-x-1" />
                      </Button>
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default StagePage;
