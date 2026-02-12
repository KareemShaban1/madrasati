import { useParams, Link } from "react-router-dom";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { useCurriculum } from "@/hooks/useCurriculum";
import { Button } from "@/components/ui/button";
import { ChevronLeft, ChevronDown, BookOpen, Clock, Trophy, Flame, Play, Lock, CheckCircle2 } from "lucide-react";
import { Progress } from "@/components/ui/progress";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import { Badge } from "@/components/ui/badge";
import { Skeleton } from "@/components/ui/skeleton";

const SubjectDetailPage = () => {
  const { stageId, gradeId, subjectId } = useParams<{
    stageId: string;
    gradeId: string;
    subjectId: string;
  }>();

  const { curriculumData, findStage, findGrade, findSubject, isLoading } = useCurriculum();
  const stage = findStage(stageId || "") || curriculumData[0];
  const grade = findGrade(stageId || "", gradeId || "") || stage?.grades?.[0];
  const subject = findSubject(stageId || "", gradeId || "", subjectId || "") || grade?.subjects?.[0];
  const Icon = subject?.icon ?? BookOpen;

  if (isLoading) {
    return (
      <div className="min-h-screen bg-background" dir="rtl">
        <Header />
        <main className="pt-16 container mx-auto px-4 py-16">
          <Skeleton className="h-12 w-96 mb-4" />
          <Skeleton className="h-16 w-full mb-8" />
          <Skeleton className="h-64 w-full rounded-2xl" />
        </main>
      </div>
    );
  }
  if (!stage || !grade || !subject) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center" dir="rtl">
        <p className="text-muted-foreground">
          {!stage ? "المرحلة غير موجودة" : !grade ? "الصف غير موجود" : "المادة غير موجودة"}
        </p>
      </div>
    );
  }

  const getStatusIcon = (status: string) => {
    switch (status) {
      case "completed":
        return <CheckCircle2 className="w-5 h-5 text-green-500" />;
      case "in-progress":
        return <Play className="w-5 h-5 text-primary" />;
      default:
        return <Lock className="w-5 h-5 text-muted-foreground" />;
    }
  };

  const getStatusBadge = (status: string) => {
    switch (status) {
      case "completed":
        return <Badge variant="outline" className="bg-green-500/10 text-green-600 border-green-500/30">مكتمل</Badge>;
      case "in-progress":
        return <Badge variant="outline" className="bg-primary/10 text-primary border-primary/30">جاري</Badge>;
      default:
        return <Badge variant="outline" className="bg-muted text-muted-foreground">مقفل</Badge>;
    }
  };

  return (
    <div className="min-h-screen bg-background overflow-x-hidden" dir="rtl">
      <Header />
      <main className="pt-16">
        {/* Hero Section */}
        <section
          className="py-12 sm:py-20 text-white relative overflow-hidden"
          style={{ backgroundColor: subject.color }}
        >
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
              <Link to={`/stage/${stage.id}/grade/${grade.id}`} className="hover:opacity-100 transition-opacity">{grade.name}</Link>
              <ChevronLeft className="w-4 h-4 shrink-0 rtl:rotate-180" />
              <span className="truncate font-medium">{subject.name}</span>
            </nav>
            
            <div className="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
              <div className="p-3 sm:p-4 bg-white/20 rounded-2xl backdrop-blur-sm shrink-0">
                <Icon className="w-10 h-10 sm:w-12 sm:h-12" />
              </div>
              <div className="flex-1 min-w-0">
                <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold mb-2 arabic-text">
                  {subject.name}
                </h1>
                <p className="text-lg sm:text-xl opacity-90 mb-2">{subject.nameEn}</p>
                <p className="text-base sm:text-lg opacity-80 max-w-2xl arabic-text">
                  {subject.description}
                </p>
              </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mt-6 sm:mt-8">
              <div className="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div className="flex items-center gap-2 mb-2">
                  <BookOpen className="w-5 h-5" />
                  <span className="text-sm opacity-80">الوحدات</span>
                </div>
                <p className="text-2xl font-bold">{subject.units.length}</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div className="flex items-center gap-2 mb-2">
                  <Clock className="w-5 h-5" />
                  <span className="text-sm opacity-80">الوقت المستغرق</span>
                </div>
                <p className="text-2xl font-bold">{subject.progress.timeSpent}</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div className="flex items-center gap-2 mb-2">
                  <Trophy className="w-5 h-5" />
                  <span className="text-sm opacity-80">متوسط الدرجات</span>
                </div>
                <p className="text-2xl font-bold">{subject.progress.averageScore}%</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                <div className="flex items-center gap-2 mb-2">
                  <Flame className="w-5 h-5" />
                  <span className="text-sm opacity-80">أيام متتالية</span>
                </div>
                <p className="text-2xl font-bold">{subject.progress.streak}</p>
              </div>
            </div>
          </div>
        </section>

        {/* Content */}
        <section className="py-8 sm:py-12">
          <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
              {/* Main Content - Units & Lessons */}
              <div className="lg:col-span-2 min-w-0">
                <h2 className="text-xl sm:text-2xl font-bold text-foreground mb-4 sm:mb-6 arabic-text">
                  الوحدات والدروس
                </h2>
                
                <Accordion type="multiple" className="space-y-4" defaultValue={[subject.units[0]?.id]}>
                  {subject.units.map((unit) => {
                    const completedLessons = unit.lessons.filter(l => l.status === "completed").length;
                    const unitProgress = Math.round((completedLessons / unit.lessons.length) * 100);

                    return (
                      <AccordionItem
                        key={unit.id}
                        value={unit.id}
                        className="bg-card border border-border/50 rounded-xl overflow-hidden shadow-card"
                      >
                        <AccordionTrigger className="px-4 sm:px-6 py-3 sm:py-4 hover:no-underline hover:bg-muted/50">
                          <div className="flex items-center gap-3 sm:gap-4 w-full text-right min-w-0">
                            <div
                              className="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center text-white font-bold shrink-0"
                              style={{ backgroundColor: subject.color }}
                            >
                              {unit.order}
                            </div>
                            <div className="flex-1 min-w-0">
                              <h3 className="text-base sm:text-lg font-semibold text-foreground arabic-text truncate sm:whitespace-normal">
                                {unit.title}
                              </h3>
                              <p className="text-xs sm:text-sm text-muted-foreground">
                                {unit.lessons.length} دروس • {completedLessons} مكتمل
                              </p>
                            </div>
                            <div className="w-20 sm:w-24 hidden sm:block shrink-0">
                              <Progress value={unitProgress} className="h-2" />
                            </div>
                          </div>
                        </AccordionTrigger>
                        <AccordionContent className="px-4 sm:px-6 pb-4">
                          <p className="text-sm sm:text-base text-muted-foreground mb-4 arabic-text">
                            {unit.description}
                          </p>
                          <div className="space-y-2">
                            {unit.lessons.map((lesson) => (
                              <Link
                                key={lesson.id}
                                to={`/lesson/${subject.id}/${lesson.id}`}
                                className={`flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 rounded-lg transition-all min-h-[44px] sm:min-h-0 ${
                                  lesson.status === "locked"
                                    ? "bg-muted/30 cursor-not-allowed opacity-60"
                                    : "bg-muted/50 hover:bg-muted"
                                }`}
                                onClick={(e) => lesson.status === "locked" && e.preventDefault()}
                              >
                                {getStatusIcon(lesson.status)}
                                <div className="flex-1">
                                  <h4 className="font-medium text-foreground arabic-text">
                                    {lesson.title}
                                  </h4>
                                  <p className="text-sm text-muted-foreground">
                                    {lesson.titleEn}
                                  </p>
                                </div>
                                <div className="flex items-center gap-2 sm:gap-3 flex-wrap">
                                  <span className="text-xs sm:text-sm text-muted-foreground">
                                    {lesson.duration}
                                  </span>
                                  {getStatusBadge(lesson.status)}
                                </div>
                              </Link>
                            ))}
                          </div>
                        </AccordionContent>
                      </AccordionItem>
                    );
                  })}
                </Accordion>
              </div>

              {/* Sidebar - Progress */}
              <div className="min-w-0">
                <div className="bg-card border border-border/50 rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-card lg:sticky lg:top-24 ring-1 ring-border/30">
                  <h3 className="text-base sm:text-lg font-bold text-foreground mb-4 sm:mb-6 arabic-text">
                    تقدمك في المادة
                  </h3>

                  {/* Circular Progress */}
                  <div className="flex justify-center mb-6">
                    <div className="relative w-32 h-32">
                      <svg className="w-full h-full transform -rotate-90">
                        <circle
                          cx="64"
                          cy="64"
                          r="56"
                          fill="none"
                          stroke="hsl(var(--muted))"
                          strokeWidth="12"
                        />
                        <circle
                          cx="64"
                          cy="64"
                          r="56"
                          fill="none"
                          stroke={subject.color}
                          strokeWidth="12"
                          strokeLinecap="round"
                          strokeDasharray={`${2 * Math.PI * 56}`}
                          strokeDashoffset={`${2 * Math.PI * 56 * (1 - subject.progress.overallPercent / 100)}`}
                          className="transition-all duration-500"
                        />
                      </svg>
                      <div className="absolute inset-0 flex items-center justify-center">
                        <span className="text-3xl font-bold text-foreground">
                          {subject.progress.overallPercent}%
                        </span>
                      </div>
                    </div>
                  </div>

                  {/* Stats */}
                  <div className="space-y-4">
                    <div className="flex justify-between items-center">
                      <span className="text-muted-foreground">الدروس المكتملة</span>
                      <span className="font-semibold text-foreground">
                        {subject.progress.lessonsCompleted} / {subject.progress.totalLessons}
                      </span>
                    </div>
                    <div className="flex justify-between items-center">
                      <span className="text-muted-foreground">التمارين المكتملة</span>
                      <span className="font-semibold text-foreground">
                        {subject.progress.exercisesCompleted} / {subject.progress.totalExercises}
                      </span>
                    </div>
                    <div className="flex justify-between items-center">
                      <span className="text-muted-foreground">متوسط الدرجات</span>
                      <span className="font-semibold text-foreground">
                        {subject.progress.averageScore}%
                      </span>
                    </div>
                  </div>

                  <Button className="w-full mt-6" variant="hero">
                    <Play className="w-4 h-4 ml-2" />
                    استمر في التعلم
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Exercises Section */}
        <section className="py-14 sm:py-16 bg-muted/30">
          <div className="container mx-auto px-4">
            <h2 className="text-2xl font-bold text-foreground mb-6 arabic-text">
              التمارين والاختبارات
            </h2>
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
              {subject.exercises.map((exercise, idx) => (
                <div
                  key={exercise.id}
                  className="bg-card border border-border/50 rounded-xl p-5 shadow-card hover:shadow-hover hover:border-primary/20 transition-all duration-300 card-lift"
                  style={{ animationDelay: `${idx * 0.05}s` }}
                >
                  <div className="flex items-center justify-between mb-3">
                    <Badge
                      variant="outline"
                      className={
                        exercise.difficulty === "easy"
                          ? "bg-green-500/10 text-green-600 border-green-500/30"
                          : exercise.difficulty === "medium"
                          ? "bg-yellow-500/10 text-yellow-600 border-yellow-500/30"
                          : "bg-red-500/10 text-red-600 border-red-500/30"
                      }
                    >
                      {exercise.difficulty === "easy"
                        ? "سهل"
                        : exercise.difficulty === "medium"
                        ? "متوسط"
                        : "صعب"}
                    </Badge>
                    {exercise.completed && exercise.score && (
                      <span className="text-sm font-medium text-green-600">
                        {exercise.score}%
                      </span>
                    )}
                  </div>
                  <h4 className="font-semibold text-foreground mb-2 arabic-text">
                    {exercise.title}
                  </h4>
                  <p className="text-sm text-muted-foreground mb-4">
                    {exercise.questionsCount} سؤال •{" "}
                    {exercise.type === "mcq"
                      ? "اختيار من متعدد"
                      : exercise.type === "short-answer"
                      ? "إجابة قصيرة"
                      : "حل مسائل"}
                  </p>
                  <Button
                    variant={exercise.completed ? "soft" : "outline"}
                    className="w-full"
                    size="sm"
                  >
                    {exercise.completed ? "إعادة المحاولة" : "ابدأ التمرين"}
                  </Button>
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </div>
  );
};

export default SubjectDetailPage;
