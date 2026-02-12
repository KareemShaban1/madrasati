import { Button } from "@/components/ui/button";
import { Exercise } from "@/data/curriculum";
import { 
  CheckCircle2, 
  Circle, 
  PenTool, 
  FileQuestion, 
  Calculator,
  Trophy,
  ArrowLeft
} from "lucide-react";

interface ExercisesSectionProps {
  exercises: Exercise[];
}

const ExercisesSection = ({ exercises }: ExercisesSectionProps) => {
  const getTypeIcon = (type: Exercise["type"]) => {
    switch (type) {
      case "mcq":
        return <FileQuestion className="w-5 h-5" />;
      case "short-answer":
        return <PenTool className="w-5 h-5" />;
      case "problem-solving":
        return <Calculator className="w-5 h-5" />;
    }
  };

  const getTypeLabel = (type: Exercise["type"]) => {
    switch (type) {
      case "mcq":
        return "اختيار من متعدد";
      case "short-answer":
        return "إجابات قصيرة";
      case "problem-solving":
        return "حل مسائل";
    }
  };

  const getDifficultyStyles = (difficulty: Exercise["difficulty"]) => {
    switch (difficulty) {
      case "easy":
        return "bg-secondary/10 text-secondary border-secondary/30";
      case "medium":
        return "bg-primary/10 text-primary border-primary/30";
      case "hard":
        return "bg-accent/10 text-accent border-accent/30";
    }
  };

  const getDifficultyLabel = (difficulty: Exercise["difficulty"]) => {
    switch (difficulty) {
      case "easy":
        return "سهل";
      case "medium":
        return "متوسط";
      case "hard":
        return "صعب";
    }
  };

  return (
    <div className="bg-card rounded-2xl border border-border/50 shadow-card overflow-hidden">
      {/* Header */}
      <div className="p-6 border-b border-border">
        <div className="flex items-center justify-between">
          <h2 className="text-xl font-bold text-foreground arabic-text">التمارين والاختبارات</h2>
          <span className="text-sm text-muted-foreground">
            {exercises.filter(e => e.completed).length} / {exercises.length} مكتمل
          </span>
        </div>
      </div>

      {/* Exercises Grid */}
      <div className="p-6 grid sm:grid-cols-2 gap-4">
        {exercises.map((exercise) => (
          <div
            key={exercise.id}
            className={`
              relative p-5 rounded-xl border-2 transition-all duration-300
              ${exercise.completed 
                ? "bg-secondary/5 border-secondary/30" 
                : "bg-card border-border hover:border-primary/30 hover:shadow-soft"
              }
            `}
          >
            {/* Completed Badge */}
            {exercise.completed && (
              <div className="absolute top-3 left-3">
                <CheckCircle2 className="w-5 h-5 text-secondary" />
              </div>
            )}

            {/* Type Icon */}
            <div className={`
              w-12 h-12 rounded-xl flex items-center justify-center mb-4
              ${exercise.completed ? "bg-secondary/20 text-secondary" : "bg-muted text-muted-foreground"}
            `}>
              {getTypeIcon(exercise.type)}
            </div>

            {/* Content */}
            <h3 className="font-semibold text-foreground mb-2 arabic-text">
              {exercise.title}
            </h3>

            {/* Meta */}
            <div className="flex flex-wrap items-center gap-2 mb-4">
              <span className={`px-2 py-1 rounded-md text-xs font-medium border ${getDifficultyStyles(exercise.difficulty)}`}>
                {getDifficultyLabel(exercise.difficulty)}
              </span>
              <span className="text-xs text-muted-foreground">
                {exercise.questionsCount} سؤال
              </span>
              <span className="text-xs text-muted-foreground">
                • {getTypeLabel(exercise.type)}
              </span>
            </div>

            {/* Score or Action */}
            {exercise.completed && exercise.score !== undefined ? (
              <div className="flex items-center gap-2 p-3 rounded-lg bg-secondary/10">
                <Trophy className="w-4 h-4 text-secondary" />
                <span className="text-sm font-semibold text-secondary">
                  درجتك: {exercise.score}%
                </span>
              </div>
            ) : (
              <Button 
                variant={exercise.completed ? "soft" : "hero"} 
                size="sm" 
                className="w-full group"
              >
                <span>{exercise.completed ? "إعادة المحاولة" : "ابدأ التمرين"}</span>
                <ArrowLeft className="w-4 h-4 transition-transform group-hover:-translate-x-1" />
              </Button>
            )}
          </div>
        ))}
      </div>
    </div>
  );
};

export default ExercisesSection;
