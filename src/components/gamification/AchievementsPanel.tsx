import { useGamification } from "@/contexts/GamificationContext";
import { Progress } from "@/components/ui/progress";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Trophy, Sparkles } from "lucide-react";

const AchievementsPanel = () => {
  const { achievements, xp, level, lessonsCompleted, streak, badges } = useGamification();
  const earnedBadges = badges.filter(b => b.earned);

  return (
    <Card className="border-primary/20 shadow-soft">
      <CardHeader className="pb-3">
        <CardTitle className="flex items-center gap-2 text-lg">
          <Trophy className="w-5 h-5 text-primary" />
          الإنجازات
        </CardTitle>
      </CardHeader>
      <CardContent className="space-y-4">
        {/* Stats Overview */}
        <div className="grid grid-cols-2 gap-3 text-center">
          <div className="bg-primary/10 rounded-xl p-3">
            <div className="text-2xl font-bold text-primary">{xp}</div>
            <div className="text-xs text-muted-foreground">نقطة خبرة</div>
          </div>
          <div className="bg-secondary/10 rounded-xl p-3">
            <div className="text-2xl font-bold text-secondary">{level}</div>
            <div className="text-xs text-muted-foreground">المستوى</div>
          </div>
          <div className="bg-accent/10 rounded-xl p-3">
            <div className="text-2xl font-bold text-accent">{lessonsCompleted}</div>
            <div className="text-xs text-muted-foreground">درس مكتمل</div>
          </div>
          <div className="bg-primary/10 rounded-xl p-3">
            <div className="text-2xl font-bold text-primary">{streak}</div>
            <div className="text-xs text-muted-foreground">يوم متتالي</div>
          </div>
        </div>

        {/* Achievements Progress */}
        <div className="space-y-3">
          <h4 className="text-sm font-semibold text-foreground">التقدم في الإنجازات</h4>
          {achievements.slice(0, 4).map(achievement => (
            <div key={achievement.id} className="space-y-1">
              <div className="flex items-center justify-between text-xs">
                <span className="flex items-center gap-2">
                  <span>{achievement.icon}</span>
                  <span className={achievement.unlocked ? "text-primary font-bold" : "text-muted-foreground"}>
                    {achievement.title}
                  </span>
                </span>
                <span className="text-muted-foreground">
                  {Math.min(achievement.progress, achievement.target)}/{achievement.target}
                </span>
              </div>
              <Progress 
                value={(achievement.progress / achievement.target) * 100} 
                className="h-1.5"
              />
            </div>
          ))}
        </div>

        {/* Recent Badges */}
        {earnedBadges.length > 0 && (
          <div className="space-y-2">
            <h4 className="text-sm font-semibold text-foreground">آخر الشارات</h4>
            <div className="flex gap-2 flex-wrap">
              {earnedBadges.slice(-4).map(badge => (
                <div
                  key={badge.id}
                  className="flex items-center gap-1 bg-gradient-to-r from-primary/10 to-secondary/10 px-2 py-1 rounded-full text-xs"
                  title={badge.description}
                >
                  <span>{badge.icon}</span>
                  <span className="font-medium">{badge.name}</span>
                </div>
              ))}
            </div>
          </div>
        )}
      </CardContent>
    </Card>
  );
};

export default AchievementsPanel;
