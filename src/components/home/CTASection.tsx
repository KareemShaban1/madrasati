import { Button } from "@/components/ui/button";
import { Sparkles, ArrowLeft } from "lucide-react";

const CTASection = () => {
  return (
    <section className="py-20 bg-background relative overflow-hidden">
      {/* Background Pattern */}
      <div className="absolute inset-0 bg-hero-pattern opacity-50" />
      
      <div className="container mx-auto px-4 relative z-10">
        <div className="max-w-3xl mx-auto text-center">
          {/* Decorative Icon */}
          <div className="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-hero shadow-lg mb-8 animate-pulse-glow">
            <Sparkles className="w-8 h-8 text-primary-foreground" />
          </div>

          {/* Heading */}
          <h2 className="text-3xl md:text-5xl font-bold text-foreground mb-6 arabic-text">
            ابدأ رحلة التعلم اليوم
          </h2>

          {/* Description */}
          <p className="text-lg text-muted-foreground mb-10 max-w-xl mx-auto arabic-text">
            انضم إلى آلاف الطلاب الذين يتعلمون بذكاء مع EduCore Egypt. 
            مجاني بالكامل ومتاح للجميع.
          </p>

          {/* CTA Button */}
          <Button variant="hero" size="xl" className="group">
            <span>ابدأ التعلم مجاناً</span>
            <ArrowLeft className="w-5 h-5 transition-transform group-hover:-translate-x-1" />
          </Button>

          {/* Trust Badge */}
          <p className="mt-8 text-sm text-muted-foreground arabic-text">
            ✓ لا يحتاج تسجيل  •  ✓ مجاني بالكامل  •  ✓ متوافق مع المناهج المصرية
          </p>
        </div>
      </div>
    </section>
  );
};

export default CTASection;
