import { Progress as ProgressType } from "@/data/curriculum";
import { Trophy, Flame, Clock, Target, TrendingUp, Star } from "lucide-react";

interface ProgressOverviewProps {
  progress: ProgressType;
}

const ProgressOverview = ({ progress }: ProgressOverviewProps) => {
  return (
    <div className="bg-card rounded-2xl border border-border/50 shadow-card overflow-hidden">
      {/* Header */}
      <div className="gradient-hero p-6 text-primary-foreground">
        <div className="flex items-center gap-3 mb-4">
          <Trophy className="w-6 h-6" />
          <h3 className="font-bold text-lg">تتبع التقدم</h3>
        </div>
        
        {/* Progress Circle */}
        <div className="relative w-32 h-32 mx-auto">
          <svg className="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
            <circle
              cx="50"
              cy="50"
              r="42"
              fill="none"
              stroke="currentColor"
              strokeWidth="8"
              className="opacity-30"
            />
            <circle
              cx="50"
              cy="50"
              r="42"
              fill="none"
              stroke="currentColor"
              strokeWidth="8"
              strokeLinecap="round"
              strokeDasharray={`${progress.overallPercent * 2.64} 264`}
              className="transition-all duration-1000"
            />
          </svg>
          <div className="absolute inset-0 flex items-center justify-center flex-col">
            <span className="text-3xl font-bold">{progress.overallPercent}%</span>
            <span className="text-xs opacity-80">مكتمل</span>
          </div>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="p-6 space-y-4">
        {/* Streak */}
        <div className="flex items-center gap-4 p-4 rounded-xl bg-accent/10 border border-accent/20">
          <div className="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center">
            <Flame className="w-6 h-6 text-accent" />
          </div>
          <div>
            <div className="text-2xl font-bold text-foreground">{progress.streak} أيام</div>
            <div className="text-sm text-muted-foreground">سلسلة التعلم المتواصل</div>
          </div>
        </div>

        {/* Average Score */}
        <div className="flex items-center gap-4 p-4 rounded-xl bg-secondary/10 border border-secondary/20">
          <div className="w-12 h-12 rounded-xl bg-secondary/20 flex items-center justify-center">
            <Star className="w-6 h-6 text-secondary" />
          </div>
          <div>
            <div className="text-2xl font-bold text-foreground">{progress.averageScore}%</div>
            <div className="text-sm text-muted-foreground">متوسط الدرجات</div>
          </div>
        </div>

        {/* Time Spent */}
        <div className="flex items-center gap-4 p-4 rounded-xl bg-primary/10 border border-primary/20">
          <div className="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center">
            <Clock className="w-6 h-6 text-primary" />
          </div>
          <div>
            <div className="text-2xl font-bold text-foreground">{progress.timeSpent}</div>
            <div className="text-sm text-muted-foreground">وقت التعلم</div>
          </div>
        </div>

        {/* Detailed Stats */}
        <div className="pt-4 border-t border-border space-y-3">
          <div className="flex items-center justify-between">
            <span className="text-sm text-muted-foreground flex items-center gap-2">
              <Target className="w-4 h-4" />
              الدروس المكتملة
            </span>
            <span className="font-semibold">{progress.lessonsCompleted} / {progress.totalLessons}</span>
          </div>
          <div className="w-full h-2 rounded-full bg-muted overflow-hidden">
            <div 
              className="h-full gradient-hero rounded-full transition-all duration-500"
              style={{ width: `${(progress.lessonsCompleted / progress.totalLessons) * 100}%` }}
            />
          </div>

          <div className="flex items-center justify-between mt-4">
            <span className="text-sm text-muted-foreground flex items-center gap-2">
              <TrendingUp className="w-4 h-4" />
              التمارين المكتملة
            </span>
            <span className="font-semibold">{progress.exercisesCompleted} / {progress.totalExercises}</span>
          </div>
          <div className="w-full h-2 rounded-full bg-muted overflow-hidden">
            <div 
              className="h-full gradient-nile rounded-full transition-all duration-500"
              style={{ width: `${(progress.exercisesCompleted / progress.totalExercises) * 100}%` }}
            />
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProgressOverview;
