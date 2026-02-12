import { useState, useEffect } from "react";
import { CheckCircle2, XCircle, HelpCircle, ArrowLeft, RotateCcw, Sparkles } from "lucide-react";
import { Button } from "@/components/ui/button";
import { QuickQuiz } from "@/data/lessonContent";
import { useGamification } from "@/contexts/GamificationContext";
import confetti from "canvas-confetti";

interface LessonQuizProps {
  quiz: QuickQuiz[];
}

const LessonQuiz = ({ quiz }: LessonQuizProps) => {
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [selectedAnswer, setSelectedAnswer] = useState<number | null>(null);
  const [showResult, setShowResult] = useState(false);
  const [score, setScore] = useState(0);
  const [answered, setAnswered] = useState<boolean[]>(new Array(quiz.length).fill(false));
  const [hasSubmittedQuiz, setHasSubmittedQuiz] = useState(false);
  
  const { completeQuiz } = useGamification();

  const current = quiz[currentQuestion];
  const isCorrect = selectedAnswer === current.correctIndex;
  const isLastQuestion = currentQuestion === quiz.length - 1;

  const handleSelect = (index: number) => {
    if (showResult) return;
    setSelectedAnswer(index);
  };

  const handleCheck = () => {
    if (selectedAnswer === null) return;
    setShowResult(true);
    if (isCorrect && !answered[currentQuestion]) {
      setScore(prev => prev + 1);
    }
    setAnswered(prev => {
      const newAnswered = [...prev];
      newAnswered[currentQuestion] = true;
      return newAnswered;
    });
  };

  const handleNext = () => {
    if (isLastQuestion) {
      // Quiz complete - submit score for gamification
      if (!hasSubmittedQuiz) {
        completeQuiz(score + (isCorrect ? 1 : 0), quiz.length);
        setHasSubmittedQuiz(true);
        
        // Trigger confetti for perfect score
        if (score + (isCorrect ? 1 : 0) === quiz.length) {
          confetti({
            particleCount: 150,
            spread: 100,
            origin: { y: 0.6 },
            colors: ['#f59e0b', '#14b8a6', '#f97316', '#8b5cf6'],
          });
        }
      }
      return;
    }
    setCurrentQuestion(prev => prev + 1);
    setSelectedAnswer(null);
    setShowResult(false);
  };

  const handleReset = () => {
    setCurrentQuestion(0);
    setSelectedAnswer(null);
    setShowResult(false);
    setScore(0);
    setAnswered(new Array(quiz.length).fill(false));
    setHasSubmittedQuiz(false);
  };

  const isComplete = answered.every(a => a) && isLastQuestion && showResult;

  return (
    <div className="bg-card rounded-xl sm:rounded-2xl border border-border/50 shadow-card overflow-hidden min-w-0">
      {/* Header */}
      <div className="p-4 sm:p-6 border-b border-border bg-gradient-to-l from-primary/5 to-transparent">
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 sm:w-12 sm:h-12 rounded-xl gradient-hero flex items-center justify-center shrink-0">
              <HelpCircle className="w-5 h-5 sm:w-6 sm:h-6 text-primary-foreground" />
            </div>
            <div className="min-w-0">
              <h3 className="text-lg sm:text-xl font-bold text-foreground arabic-text">اختبار سريع</h3>
              <p className="text-xs sm:text-sm text-muted-foreground">اختبر فهمك للدرس</p>
            </div>
          </div>
          <div className="flex items-center justify-between sm:justify-end gap-4">
            <div className="text-left">
              <span className="text-2xl font-bold text-primary">{score}</span>
              <span className="text-muted-foreground">/{quiz.length}</span>
            </div>
            {/* Progress Dots */}
            <div className="flex gap-1">
              {quiz.map((_, idx) => (
                <div 
                  key={idx}
                  className={`w-2 h-2 rounded-full transition-colors ${
                    answered[idx] 
                      ? "bg-secondary" 
                      : idx === currentQuestion 
                        ? "bg-primary" 
                        : "bg-muted"
                  }`}
                />
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Question */}
      <div className="p-4 sm:p-6">
        {isComplete ? (
          /* Final Score Screen */
          <div className="text-center py-6 sm:py-8">
            <div className={`w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center ${
              score === quiz.length ? "bg-secondary/20" : score >= quiz.length / 2 ? "bg-primary/20" : "bg-destructive/20"
            }`}>
              {score === quiz.length ? (
                <CheckCircle2 className="w-12 h-12 text-secondary" />
              ) : (
                <span className="text-4xl font-bold" style={{ color: score >= quiz.length / 2 ? "hsl(var(--primary))" : "hsl(var(--destructive))" }}>
                  {Math.round((score / quiz.length) * 100)}%
                </span>
              )}
            </div>
            <h4 className="text-2xl font-bold text-foreground mb-2">
              {score === quiz.length ? "ممتاز! 🎉" : score >= quiz.length / 2 ? "أحسنت! 👏" : "حاول مرة أخرى 💪"}
            </h4>
            <p className="text-muted-foreground mb-4">
              لقد أجبت على {score} من {quiz.length} أسئلة بشكل صحيح
            </p>
            
            {/* XP Earned */}
            <div className="flex items-center justify-center gap-2 bg-primary/10 rounded-full px-4 py-2 mx-auto w-fit mb-6">
              <Sparkles className="w-5 h-5 text-primary" />
              <span className="text-lg font-bold text-primary">
                +{10 + (score === quiz.length ? 15 : Math.floor((score / quiz.length) * 10))} XP
              </span>
            </div>
            
            <Button variant="hero" onClick={handleReset}>
              <RotateCcw className="w-4 h-4" />
              إعادة الاختبار
            </Button>
          </div>
        ) : (
          <>
            <div className="mb-6">
              <span className="text-sm text-muted-foreground mb-2 block">
                السؤال {currentQuestion + 1} من {quiz.length}
              </span>
              <h4 className="text-xl font-bold text-foreground arabic-text">{current.question}</h4>
            </div>

            {/* Options */}
            <div className="space-y-3 mb-6">
              {current.options.map((option, idx) => (
                <button
                  key={idx}
                  onClick={() => handleSelect(idx)}
                  disabled={showResult}
                  className={`w-full p-4 rounded-xl border-2 text-right transition-all ${
                    showResult
                      ? idx === current.correctIndex
                        ? "border-secondary bg-secondary/10"
                        : selectedAnswer === idx
                          ? "border-destructive bg-destructive/10"
                          : "border-border bg-muted/30"
                      : selectedAnswer === idx
                        ? "border-primary bg-primary/10"
                        : "border-border hover:border-primary/50 hover:bg-primary/5"
                  }`}
                >
                  <div className="flex items-center gap-3">
                    <span className={`w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 ${
                      showResult
                        ? idx === current.correctIndex
                          ? "bg-secondary text-secondary-foreground"
                          : selectedAnswer === idx
                            ? "bg-destructive text-destructive-foreground"
                            : "bg-muted text-muted-foreground"
                        : selectedAnswer === idx
                          ? "bg-primary text-primary-foreground"
                          : "bg-muted text-muted-foreground"
                    }`}>
                      {String.fromCharCode(1571 + idx)}
                    </span>
                    <span className="text-foreground arabic-text">{option}</span>
                    {showResult && idx === current.correctIndex && (
                      <CheckCircle2 className="w-5 h-5 text-secondary mr-auto" />
                    )}
                    {showResult && selectedAnswer === idx && idx !== current.correctIndex && (
                      <XCircle className="w-5 h-5 text-destructive mr-auto" />
                    )}
                  </div>
                </button>
              ))}
            </div>

            {/* Explanation */}
            {showResult && (
              <div className={`p-4 rounded-xl mb-6 ${isCorrect ? "bg-secondary/10 border border-secondary/30" : "bg-accent/10 border border-accent/30"}`}>
                <p className="text-sm text-foreground/80 arabic-text">
                  <span className="font-bold">{isCorrect ? "إجابة صحيحة! " : "التوضيح: "}</span>
                  {current.explanation}
                </p>
              </div>
            )}

            {/* Actions */}
            <div className="flex gap-3">
              {!showResult ? (
                <Button 
                  variant="hero" 
                  className="flex-1"
                  onClick={handleCheck}
                  disabled={selectedAnswer === null}
                >
                  تحقق من الإجابة
                </Button>
              ) : (
                <Button 
                  variant="hero" 
                  className="flex-1"
                  onClick={handleNext}
                >
                  {isLastQuestion ? "عرض النتيجة" : "السؤال التالي"}
                  <ArrowLeft className="w-4 h-4" />
                </Button>
              )}
            </div>
          </>
        )}
      </div>
    </div>
  );
};

export default LessonQuiz;
