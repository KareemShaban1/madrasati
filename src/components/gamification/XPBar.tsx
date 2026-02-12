import { useGamification } from "@/contexts/GamificationContext";
import { Progress } from "@/components/ui/progress";
import { Sparkles, Flame, Trophy } from "lucide-react";

const XPBar = () => {
  const { xp, level, streak, getLevelProgress, getXPForNextLevel } = useGamification();
  const progress = getLevelProgress();
  const xpNeeded = getXPForNextLevel();

  return (
    <div className="flex items-center gap-4">
      {/* Streak */}
      {streak > 0 && (
        <div className="flex items-center gap-1 bg-accent/20 text-accent px-2 py-1 rounded-full text-sm font-bold">
          <Flame className="w-4 h-4" />
          <span>{streak}</span>
        </div>
      )}
      
      {/* Level & XP */}
      <div className="flex items-center gap-2">
        <div className="flex items-center gap-1 bg-primary/20 text-primary px-2 py-1 rounded-full text-sm font-bold">
          <Trophy className="w-4 h-4" />
          <span>Lv.{level}</span>
        </div>
        
        <div className="hidden sm:flex items-center gap-2">
          <div className="w-24 relative">
            <Progress value={progress} className="h-2" />
          </div>
          <div className="flex items-center gap-1 text-xs text-muted-foreground">
            <Sparkles className="w-3 h-3 text-primary" />
            <span>{xp} XP</span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default XPBar;
