import { Button } from "@/components/ui/button";
import { Sparkles, BookOpen, Play, ArrowLeft } from "lucide-react";

const HeroSection = () => {
  return (
    <section className="relative min-h-screen flex items-center justify-center pt-16 overflow-hidden bg-hero-pattern">
      {/* Decorative Elements */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <div className="absolute top-20 left-10 w-20 h-20 rounded-full bg-primary/10 animate-float" />
        <div className="absolute top-40 right-20 w-32 h-32 rounded-full bg-secondary/10 animate-float-delayed" />
        <div className="absolute bottom-40 left-1/4 w-16 h-16 rounded-full bg-accent/10 animate-float" />
        <div className="absolute bottom-20 right-1/3 w-24 h-24 rounded-full bg-primary/5 animate-float-delayed" />
      </div>

      <div className="container mx-auto px-4 sm:px-6 py-12 sm:py-20 relative z-10">
        <div className="max-w-4xl mx-auto text-center min-w-0">
          {/* Badge */}
          <div className="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-primary/10 border border-primary/20 mb-6 sm:mb-8 animate-slide-up">
            <Sparkles className="w-4 h-4 text-primary shrink-0" />
            <span className="text-xs sm:text-sm font-medium text-primary arabic-text">
              منصة تعليمية ذكية بالذكاء الاصطناعي
            </span>
          </div>

          {/* Main Heading */}
          <h1 className="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold mb-4 sm:mb-6 animate-slide-up arabic-text" style={{ animationDelay: "0.1s" }}>
            <span className="text-foreground">تعلّم بطريقة</span>
            <br />
            <span className="text-gradient">ذكية ومُمتعة</span>
          </h1>

          {/* Subtitle */}
          <p className="text-base sm:text-lg md:text-xl text-muted-foreground mb-8 sm:mb-10 max-w-2xl mx-auto animate-slide-up arabic-text px-1" style={{ animationDelay: "0.2s" }}>
            منصة EduCore Egypt تُقدم تجربة تعليمية تفاعلية مخصصة لكل طالب، 
            مع شرح مفصل ومتوافق مع المناهج المصرية من الابتدائية حتى الثانوية العامة
          </p>

          {/* CTA Buttons */}
          <div className="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 mb-10 sm:mb-16 animate-slide-up" style={{ animationDelay: "0.3s" }}>
            <a href="#grades" className="w-full sm:w-auto">
              <Button variant="hero" size="xl" className="w-full sm:w-auto group">
                <BookOpen className="w-5 h-5" />
                <span>ابدأ رحلة التعلم</span>
                <ArrowLeft className="w-4 h-4 transition-transform group-hover:-translate-x-1" />
              </Button>
            </a>
            <Button variant="outline" size="xl" className="w-full sm:w-auto group">
              <Play className="w-5 h-5" />
              <span>شاهد كيف نعمل</span>
            </Button>
          </div>

          {/* Stats */}
          <div className="grid grid-cols-3 gap-2 sm:gap-4 md:gap-6 max-w-lg mx-auto animate-slide-up" style={{ animationDelay: "0.4s" }}>
            <div className="text-center min-w-0">
              <div className="text-2xl sm:text-3xl md:text-4xl font-bold text-gradient">+50</div>
              <div className="text-xs sm:text-sm text-muted-foreground arabic-text">مادة دراسية</div>
            </div>
            <div className="text-center border-x border-border min-w-0">
              <div className="text-2xl sm:text-3xl md:text-4xl font-bold text-gradient">12</div>
              <div className="text-xs sm:text-sm text-muted-foreground arabic-text">صف دراسي</div>
            </div>
            <div className="text-center min-w-0">
              <div className="text-2xl sm:text-3xl md:text-4xl font-bold text-gradient">24/7</div>
              <div className="text-xs sm:text-sm text-muted-foreground arabic-text">دعم متواصل</div>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom Wave */}
      <div className="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
          <path 
            d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
            fill="hsl(var(--muted))"
          />
        </svg>
      </div>
    </section>
  );
};

export default HeroSection;
