import { useState, useRef, useEffect } from "react";
import { BookOpen, Lightbulb, CheckCircle2, PenTool, MessageCircle, Sparkles, Layers, Eye, ListOrdered, ChevronDown, ChevronUp } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { LessonSection, StepItem } from "@/data/lessonContent";

/** Detect if string looks like HTML (from admin editor) */
function isHtml(content: string): boolean {
  if (!content || typeof content !== "string") return false;
  const trimmed = content.trim();
  return trimmed.startsWith("<") && trimmed.includes(">");
}

/** Render section content: HTML as rich text, plain text with newlines. Long content is scrollable and expandable. */
const SECTION_CONTENT_MAX_HEIGHT = "20rem"; // 320px

const SectionContentBlock = ({ content, className = "" }: { content: string; className?: string }) => {
  const [expanded, setExpanded] = useState(false);
  const [hasOverflow, setHasOverflow] = useState(false);
  const containerRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const el = containerRef.current;
    if (!el) return;
    const check = () => setHasOverflow(el.scrollHeight > el.clientHeight);
    check();
    const ro = new ResizeObserver(check);
    ro.observe(el);
    return () => ro.disconnect();
  }, [content, expanded]);

  if (!content) return null;

  const contentIsHtml = isHtml(content);

  const inner = contentIsHtml ? (
    <div
      className="prose prose-lg max-w-none text-foreground/90 arabic-text prose-p:mb-3 prose-headings:text-foreground prose-strong:text-foreground prose-ul:my-3 prose-ol:my-3"
      dangerouslySetInnerHTML={{ __html: content }}
    />
  ) : (
    <div className="prose prose-lg max-w-none text-foreground/90">
      {content.split("\n").map((paragraph, idx) => (
        <p key={idx} className="mb-3 leading-relaxed arabic-text whitespace-pre-wrap">
          {paragraph}
        </p>
      ))}
    </div>
  );

  return (
    <div className={className}>
      <div
        ref={containerRef}
        className={`overflow-y-auto transition-all duration-300 ${expanded ? "max-h-none" : ""}`}
        style={expanded ? undefined : { maxHeight: SECTION_CONTENT_MAX_HEIGHT }}
      >
        {inner}
      </div>
      {hasOverflow && (
        <Button
          variant="ghost"
          size="sm"
          className="mt-2 text-muted-foreground hover:text-foreground"
          onClick={() => setExpanded((e) => !e)}
        >
          {expanded ? (
            <>
              <ChevronUp className="w-4 h-4 ml-1" />
              إظهار أقل
            </>
          ) : (
            <>
              <ChevronDown className="w-4 h-4 ml-1" />
              إظهار المزيد
            </>
          )}
        </Button>
      )}
    </div>
  );
};

interface LessonContentProps {
  sections: LessonSection[];
}

const LessonContent = ({ sections }: LessonContentProps) => {
  return (
    <div className="space-y-4 sm:space-y-6 min-w-0">
      {sections.map((section) => (
        <ContentSection key={section.id} section={section} />
      ))}
    </div>
  );
};

const ContentSection = ({ section }: { section: LessonSection }) => {
  const getIcon = () => {
    switch (section.type) {
      case "text": return <BookOpen className="w-5 h-5" />;
      case "example": return <Lightbulb className="w-5 h-5" />;
      case "summary": return <CheckCircle2 className="w-5 h-5" />;
      case "interactive": return <PenTool className="w-5 h-5" />;
      case "cartoon": return <Sparkles className="w-5 h-5" />;
      case "story": return <BookOpen className="w-5 h-5" />;
      case "visualization": return <Eye className="w-5 h-5" />;
      case "character-dialog": return <MessageCircle className="w-5 h-5" />;
      case "step-by-step": return <ListOrdered className="w-5 h-5" />;
      default: return <BookOpen className="w-5 h-5" />;
    }
  };

  const getStyles = () => {
    switch (section.type) {
      case "text": 
        return "bg-card border-border/50";
      case "example": 
        return "bg-primary/5 border-primary/20";
      case "summary": 
        return "bg-secondary/10 border-secondary/30";
      case "interactive": 
        return "bg-accent/10 border-accent/30";
      case "cartoon":
        return "bg-gradient-to-br from-pink-50 to-purple-50 dark:from-pink-950/20 dark:to-purple-950/20 border-pink-200 dark:border-pink-800/30";
      case "story":
        return "bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-950/20 dark:to-orange-950/20 border-amber-200 dark:border-amber-800/30";
      case "visualization":
        return "bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-950/20 dark:to-cyan-950/20 border-blue-200 dark:border-blue-800/30";
      case "character-dialog":
        return "bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 border-green-200 dark:border-green-800/30";
      case "step-by-step":
        return "bg-gradient-to-br from-violet-50 to-indigo-50 dark:from-violet-950/20 dark:to-indigo-950/20 border-violet-200 dark:border-violet-800/30";
      default: 
        return "bg-card border-border/50";
    }
  };

  const getIconBg = () => {
    switch (section.type) {
      case "text": return "bg-muted text-foreground";
      case "example": return "bg-primary/20 text-primary";
      case "summary": return "bg-secondary/20 text-secondary";
      case "interactive": return "bg-accent/20 text-accent";
      case "cartoon": return "bg-pink-200 dark:bg-pink-800 text-pink-700 dark:text-pink-200";
      case "story": return "bg-amber-200 dark:bg-amber-800 text-amber-700 dark:text-amber-200";
      case "visualization": return "bg-blue-200 dark:bg-blue-800 text-blue-700 dark:text-blue-200";
      case "character-dialog": return "bg-green-200 dark:bg-green-800 text-green-700 dark:text-green-200";
      case "step-by-step": return "bg-violet-200 dark:bg-violet-800 text-violet-700 dark:text-violet-200";
      default: return "bg-muted text-foreground";
    }
  };

  return (
    <div className={`rounded-xl sm:rounded-2xl border shadow-soft overflow-hidden min-w-0 ${getStyles()} animate-fade-in`}>
      {/* Section Header */}
      <div className="p-3 sm:p-4 border-b border-border/50 flex items-center gap-3 min-w-0">
        <div className={`w-9 h-9 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0 ${getIconBg()}`}>
          {getIcon()}
        </div>
        <h3 className="font-bold text-base sm:text-lg text-foreground arabic-text truncate">{section.title}</h3>
      </div>

      {/* Section Content */}
      <div className="p-4 sm:p-6">
        {section.type === "interactive" && section.items ? (
          <InteractiveContent section={section} />
        ) : section.type === "character-dialog" ? (
          <CharacterDialog section={section} />
        ) : section.type === "step-by-step" && section.steps ? (
          <StepByStepContent steps={section.steps} />
        ) : section.type === "cartoon" || section.type === "story" ? (
          <StoryContent content={section.content} />
        ) : section.type === "visualization" ? (
          <VisualizationContent content={section.content} />
        ) : (
          <SectionContentBlock content={section.content ?? ""} />
        )}
      </div>
    </div>
  );
};

const CharacterDialog = ({ section }: { section: LessonSection }) => {
  const content = section.content ?? "";
  const contentIsHtml = isHtml(content);
  return (
    <div className="flex gap-4">
      {/* Character Avatar */}
      <div className="shrink-0">
        <div className="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-3xl shadow-lg animate-bounce-slow">
          {section.characterEmoji || "👨‍🏫"}
        </div>
        <p className="text-center text-sm font-bold mt-2 text-foreground/80">{section.characterName}</p>
      </div>
      
      {/* Speech Bubble */}
      <div className="flex-1 relative min-w-0">
        <div className="absolute right-0 top-4 w-0 h-0 border-t-8 border-t-transparent border-l-8 border-l-white dark:border-l-gray-800 border-b-8 border-b-transparent -mr-2"></div>
        <div className="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-md border border-border/30 max-h-[20rem] overflow-y-auto">
          {contentIsHtml ? (
            <div className="prose prose-sm max-w-none text-foreground/90 arabic-text prose-p:mb-2" dangerouslySetInnerHTML={{ __html: content }} />
          ) : (
            content.split("\n").map((line, idx) => (
              <p key={idx} className="mb-2 leading-relaxed arabic-text text-foreground/90 whitespace-pre-wrap">
                {line}
              </p>
            ))
          )}
        </div>
      </div>
    </div>
  );
};

const StepByStepContent = ({ steps }: { steps: StepItem[] }) => {
  const [currentStep, setCurrentStep] = useState(0);
  
  return (
    <div className="space-y-4">
      {/* Progress Bar */}
      <div className="flex gap-2 mb-6">
        {steps.map((_, idx) => (
          <div
            key={idx}
            className={`h-2 flex-1 rounded-full transition-all duration-300 cursor-pointer ${
              idx <= currentStep ? "bg-primary" : "bg-muted"
            }`}
            onClick={() => setCurrentStep(idx)}
          />
        ))}
      </div>
      
      {/* Steps */}
      <div className="space-y-3">
        {steps.map((step, idx) => (
          <div
            key={step.id}
            className={`flex items-start gap-4 p-4 rounded-xl transition-all duration-300 cursor-pointer ${
              idx === currentStep 
                ? "bg-primary/10 border-2 border-primary scale-[1.02]" 
                : idx < currentStep 
                  ? "bg-secondary/10 border border-secondary/30 opacity-80"
                  : "bg-muted/30 border border-border/30 opacity-60"
            }`}
            onClick={() => setCurrentStep(idx)}
          >
            <div className={`w-12 h-12 rounded-xl flex items-center justify-center text-2xl shrink-0 ${
              idx === currentStep ? "bg-primary text-primary-foreground" : "bg-muted"
            }`}>
              {step.emoji || (idx + 1)}
            </div>
            <div>
              <h4 className="font-bold text-foreground">{step.title}</h4>
              <p className="text-foreground/80 arabic-text">{step.content}</p>
            </div>
            {idx < currentStep && (
              <CheckCircle2 className="w-6 h-6 text-secondary shrink-0" />
            )}
          </div>
        ))}
      </div>
      
      {/* Navigation */}
      <div className="flex justify-between pt-4">
        <Button
          variant="outline"
          size="sm"
          onClick={() => setCurrentStep(prev => Math.max(0, prev - 1))}
          disabled={currentStep === 0}
        >
          السابق
        </Button>
        <Button
          variant="soft"
          size="sm"
          onClick={() => setCurrentStep(prev => Math.min(steps.length - 1, prev + 1))}
          disabled={currentStep === steps.length - 1}
        >
          التالي
        </Button>
      </div>
    </div>
  );
};

const StoryContent = ({ content }: { content: string }) => {
  if (!content) return null;
  const contentIsHtml = isHtml(content);
  return (
    <div className="relative">
      <div className="absolute -top-2 -right-2 text-4xl opacity-50">📖</div>
      <div className="absolute -bottom-2 -left-2 text-4xl opacity-50">✨</div>
      
      <div className="bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 border border-white/30 dark:border-gray-700/30 backdrop-blur-sm max-h-[20rem] overflow-y-auto">
        {contentIsHtml ? (
          <div className="prose prose-lg max-w-none text-foreground/90 arabic-text prose-p:mb-3 prose-p:leading-loose" dangerouslySetInnerHTML={{ __html: content }} />
        ) : (
          content.split("\n").map((line, idx) => (
            <p key={idx} className="mb-3 leading-loose arabic-text text-foreground/90 whitespace-pre-wrap text-lg">
              {line}
            </p>
          ))
        )}
      </div>
    </div>
  );
};

const VisualizationContent = ({ content }: { content: string }) => {
  if (!content) return null;
  const contentIsHtml = isHtml(content);
  return (
    <div className="font-mono text-sm">
      <div className="bg-white/70 dark:bg-gray-800/70 rounded-xl p-6 border border-border/30 backdrop-blur-sm max-h-[20rem] overflow-y-auto">
        {contentIsHtml ? (
          <div className="prose prose-sm max-w-none text-foreground/90 prose-pre:whitespace-pre-wrap" dangerouslySetInnerHTML={{ __html: content }} />
        ) : (
          content.split("\n").map((line, idx) => (
            <p key={idx} className="mb-2 leading-relaxed whitespace-pre-wrap text-foreground/90">
              {line}
            </p>
          ))
        )}
      </div>
    </div>
  );
};

const InteractiveContent = ({ section }: { section: LessonSection }) => {
  const [answers, setAnswers] = useState<Record<string, string>>({});
  const [checked, setChecked] = useState<Record<string, boolean>>({});
  const [showHint, setShowHint] = useState<Record<string, boolean>>({});

  const handleCheck = (itemId: string, correctAnswer: string) => {
    setChecked(prev => ({
      ...prev,
      [itemId]: answers[itemId]?.trim() === correctAnswer.trim()
    }));
  };

  const introContent = section.content ?? "";
  const introIsHtml = isHtml(introContent);
  return (
    <div className="space-y-6">
      <div className="text-muted-foreground mb-4 max-h-[12rem] overflow-y-auto">
        {introIsHtml ? (
          <div className="prose prose-sm max-w-none" dangerouslySetInnerHTML={{ __html: introContent }} />
        ) : (
          <p>{introContent}</p>
        )}
      </div>
      
      {section.items?.map((item, idx) => (
        <div key={item.id} className="bg-background/50 rounded-xl p-4 border border-border transition-all duration-300 hover:shadow-md">
          <div className="flex items-start gap-3 mb-3">
            <span className="w-8 h-8 rounded-lg gradient-hero flex items-center justify-center text-primary-foreground text-sm font-bold shrink-0">
              {idx + 1}
            </span>
            <p className="text-foreground arabic-text flex-1">{item.question}</p>
          </div>
          
          <div className="flex gap-3 items-center mr-11">
            <Input
              value={answers[item.id] || ""}
              onChange={(e) => setAnswers(prev => ({ ...prev, [item.id]: e.target.value }))}
              placeholder="أدخل إجابتك..."
              className={`flex-1 transition-all duration-300 ${
                checked[item.id] !== undefined 
                  ? checked[item.id] 
                    ? "border-secondary bg-secondary/10 ring-2 ring-secondary/30" 
                    : "border-destructive bg-destructive/10 ring-2 ring-destructive/30"
                  : ""
              }`}
              dir="ltr"
            />
            <Button 
              variant="soft"
              size="sm"
              onClick={() => handleCheck(item.id, item.answer)}
              className="shrink-0"
            >
              تحقق ✓
            </Button>
          </div>
          
          {/* Hint Button */}
          {item.hint && !checked[item.id] && (
            <div className="mr-11 mt-2">
              <Button
                variant="ghost"
                size="sm"
                onClick={() => setShowHint(prev => ({ ...prev, [item.id]: !prev[item.id] }))}
                className="text-amber-600 dark:text-amber-400 hover:text-amber-700 text-sm"
              >
                💡 {showHint[item.id] ? "إخفاء التلميح" : "أحتاج تلميح"}
              </Button>
              {showHint[item.id] && (
                <p className="text-amber-600 dark:text-amber-400 text-sm mt-1 animate-fade-in">
                  🔍 {item.hint}
                </p>
              )}
            </div>
          )}
          
          {checked[item.id] !== undefined && (
            <div className={`mt-3 mr-11 text-sm animate-fade-in ${checked[item.id] ? "text-secondary" : "text-destructive"}`}>
              {checked[item.id] ? (
                <span className="flex items-center gap-2">
                  <CheckCircle2 className="w-5 h-5" />
                  <span>🎉 إجابة صحيحة! أحسنت</span>
                </span>
              ) : (
                <div>
                  <span className="block">❌ حاول مرة أخرى!</span>
                  <span className="block mt-1 text-muted-foreground">الإجابة الصحيحة: <strong className="text-foreground">{item.answer}</strong></span>
                </div>
              )}
            </div>
          )}
        </div>
      ))}
    </div>
  );
};

export default LessonContent;
