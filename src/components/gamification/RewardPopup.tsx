import { useEffect, useState } from "react";
import { useGamification } from "@/contexts/GamificationContext";
import { Dialog, DialogContent } from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Sparkles, Trophy, Award } from "lucide-react";

const RewardPopup = () => {
  const { recentReward, clearRecentReward } = useGamification();
  const [open, setOpen] = useState(false);

  useEffect(() => {
    if (recentReward && (recentReward.badge || recentReward.achievement)) {
      setOpen(true);
    }
  }, [recentReward]);

  const handleClose = () => {
    setOpen(false);
    clearRecentReward();
  };

  if (!recentReward) return null;

  return (
    <Dialog open={open} onOpenChange={setOpen}>
      <DialogContent className="max-w-sm text-center border-primary/30 bg-gradient-to-br from-background to-primary/5">
        <div className="py-6 space-y-6">
          {/* Celebration Animation */}
          <div className="relative">
            <div className="absolute inset-0 flex items-center justify-center">
              <div className="w-32 h-32 rounded-full bg-gradient-to-br from-primary/20 to-secondary/20 animate-pulse-glow" />
            </div>
            <div className="relative text-7xl animate-bounce-slow">
              {recentReward.badge?.icon || recentReward.achievement?.icon || '🎉'}
            </div>
          </div>

          {/* Badge Earned */}
          {recentReward.badge && (
            <div className="space-y-2">
              <div className="flex items-center justify-center gap-2 text-primary">
                <Award className="w-5 h-5" />
                <span className="text-sm font-bold">شارة جديدة!</span>
              </div>
              <h2 className="text-2xl font-bold text-foreground">
                {recentReward.badge.name}
              </h2>
              <p className="text-muted-foreground">
                {recentReward.badge.description}
              </p>
            </div>
          )}

          {/* Achievement Unlocked */}
          {recentReward.achievement && (
            <div className="space-y-2">
              <div className="flex items-center justify-center gap-2 text-secondary">
                <Trophy className="w-5 h-5" />
                <span className="text-sm font-bold">إنجاز جديد!</span>
              </div>
              <h2 className="text-2xl font-bold text-foreground">
                {recentReward.achievement.title}
              </h2>
              <p className="text-muted-foreground">
                {recentReward.achievement.description}
              </p>
            </div>
          )}

          {/* XP Reward */}
          <div className="flex items-center justify-center gap-2 bg-primary/10 rounded-full px-4 py-2 mx-auto w-fit">
            <Sparkles className="w-5 h-5 text-primary" />
            <span className="text-lg font-bold text-primary">+{recentReward.xp} XP</span>
          </div>

          {/* Close Button */}
          <Button onClick={handleClose} className="w-full">
            رائع! 🎉
          </Button>
        </div>
      </DialogContent>
    </Dialog>
  );
};

export default RewardPopup;
