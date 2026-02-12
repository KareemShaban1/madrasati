import { useGamification } from "@/contexts/GamificationContext";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Sparkles, Trophy, Flame, ChevronLeft } from "lucide-react";
import { Link } from "react-router-dom";
import confetti from "canvas-confetti";
import { useEffect } from "react";

interface LessonCompleteCardProps {
  lessonTitle: string;
  nextLessonPath?: string;
  subjectPath: string;
  onComplete?: () => void;
}

const LessonCompleteCard = ({
  lessonTitle,
  nextLessonPath,
  subjectPath,
  onComplete,
}: LessonCompleteCardProps) => {
  const { xp, level, streak, lessonsCompleted } = useGamification();

  useEffect(() => {
    // Trigger confetti on mount
    confetti({
      particleCount: 100,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#f59e0b', '#14b8a6', '#f97316'],
    });
  }, []);

  return (
    <Card className="border-2 border-primary/30 bg-gradient-to-br from-primary/5 via-background to-secondary/5 shadow-lg overflow-hidden">
      <CardContent className="p-8 text-center space-y-6">
        {/* Celebration Header */}
        <div className="space-y-2">
          <div className="text-6xl animate-bounce-slow">🎉</div>
          <h2 className="text-2xl font-bold text-foreground">أحسنت! درس مكتمل</h2>
          <p className="text-muted-foreground">{lessonTitle}</p>
        </div>

        {/* Stats Row */}
        <div className="flex justify-center gap-4 flex-wrap">
          <div className="flex items-center gap-2 bg-primary/10 px-4 py-2 rounded-full">
            <Sparkles className="w-5 h-5 text-primary" />
            <span className="font-bold text-primary">{xp} XP</span>
          </div>
          <div className="flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full">
            <Trophy className="w-5 h-5 text-secondary" />
            <span className="font-bold text-secondary">المستوى {level}</span>
          </div>
          {streak > 0 && (
            <div className="flex items-center gap-2 bg-accent/10 px-4 py-2 rounded-full">
              <Flame className="w-5 h-5 text-accent" />
              <span className="font-bold text-accent">{streak} يوم</span>
            </div>
          )}
        </div>

        {/* Progress Message */}
        <p className="text-sm text-muted-foreground">
          أكملت <span className="font-bold text-primary">{lessonsCompleted}</span> درس حتى الآن!
        </p>

        {/* Action Buttons */}
        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          {nextLessonPath && (
            <Link to={nextLessonPath}>
              <Button className="w-full sm:w-auto gap-2">
                الدرس التالي
                <ChevronLeft className="w-4 h-4" />
              </Button>
            </Link>
          )}
          <Link to={subjectPath}>
            <Button variant="outline" className="w-full sm:w-auto">
              العودة للمادة
            </Button>
          </Link>
        </div>
      </CardContent>
    </Card>
  );
};

export default LessonCompleteCard;
