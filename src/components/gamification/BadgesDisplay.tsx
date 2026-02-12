import { useState } from "react";
import { useGamification, Badge } from "@/contexts/GamificationContext";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from "@/components/ui/dialog";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { ScrollArea } from "@/components/ui/scroll-area";
import { Award } from "lucide-react";

const BadgeCard = ({ badge, size = "normal" }: { badge: Badge; size?: "small" | "normal" }) => {
  const isSmall = size === "small";
  
  return (
    <div
      className={`relative rounded-xl border transition-all duration-300 ${
        badge.earned
          ? "bg-gradient-to-br from-primary/10 to-secondary/10 border-primary/30 shadow-lg"
          : "bg-muted/30 border-border/50 opacity-50 grayscale"
      } ${isSmall ? "p-2" : "p-4"}`}
    >
      <div className="flex flex-col items-center text-center gap-2">
        <div
          className={`${isSmall ? "text-2xl" : "text-4xl"} ${
            badge.earned ? "animate-bounce-slow" : ""
          }`}
        >
          {badge.icon}
        </div>
        <div>
          <h4 className={`font-bold ${isSmall ? "text-xs" : "text-sm"} text-foreground`}>
            {badge.name}
          </h4>
          {!isSmall && (
            <p className="text-xs text-muted-foreground mt-1">{badge.description}</p>
          )}
        </div>
        {badge.earned && badge.earnedAt && !isSmall && (
          <span className="text-xs text-primary">
            ✓ {new Date(badge.earnedAt).toLocaleDateString('ar-EG')}
          </span>
        )}
      </div>
      {!badge.earned && !isSmall && (
        <div className="absolute inset-0 flex items-center justify-center bg-background/50 rounded-xl">
          <span className="text-2xl">🔒</span>
        </div>
      )}
    </div>
  );
};

const BadgesDisplay = () => {
  const { badges } = useGamification();
  const [open, setOpen] = useState(false);
  
  const earnedBadges = badges.filter(b => b.earned);
  const categories = {
    learning: badges.filter(b => b.category === 'learning'),
    streak: badges.filter(b => b.category === 'streak'),
    mastery: badges.filter(b => b.category === 'mastery'),
    special: badges.filter(b => b.category === 'special'),
  };

  return (
    <Dialog open={open} onOpenChange={setOpen}>
      <DialogTrigger asChild>
        <button className="flex items-center gap-2 bg-secondary/20 hover:bg-secondary/30 text-secondary px-3 py-1.5 rounded-full text-sm font-bold transition-colors">
          <Award className="w-4 h-4" />
          <span>{earnedBadges.length}/{badges.length}</span>
        </button>
      </DialogTrigger>
      <DialogContent className="max-w-2xl max-h-[80vh]">
        <DialogHeader>
          <DialogTitle className="flex items-center gap-2 text-xl">
            <Award className="w-6 h-6 text-primary" />
            الشارات والإنجازات
          </DialogTitle>
        </DialogHeader>
        
        <Tabs defaultValue="learning" className="w-full">
          <TabsList className="grid w-full grid-cols-4">
            <TabsTrigger value="learning">📚 تعلم</TabsTrigger>
            <TabsTrigger value="streak">🔥 استمرارية</TabsTrigger>
            <TabsTrigger value="mastery">💎 إتقان</TabsTrigger>
            <TabsTrigger value="special">⭐ خاصة</TabsTrigger>
          </TabsList>
          
          <ScrollArea className="h-[400px] mt-4">
            {Object.entries(categories).map(([category, categoryBadges]) => (
              <TabsContent key={category} value={category} className="mt-0">
                <div className="grid grid-cols-2 sm:grid-cols-3 gap-4 p-2">
                  {categoryBadges.map(badge => (
                    <BadgeCard key={badge.id} badge={badge} />
                  ))}
                </div>
              </TabsContent>
            ))}
          </ScrollArea>
        </Tabs>
      </DialogContent>
    </Dialog>
  );
};

export default BadgesDisplay;
