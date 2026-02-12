import { Button } from "@/components/ui/button";
import { BookOpen, PenTool, FileCheck, Lightbulb, ArrowLeft } from "lucide-react";

const modes = [
  {
    icon: BookOpen,
    title: "وضع الدراسة",
    titleEn: "Study Mode",
    description: "شرح تفصيلي للدروس خطوة بخطوة مع أمثلة تطبيقية",
    color: "gradient-hero",
    features: ["شرح نظري شامل", "أمثلة محلولة", "رسوم توضيحية"]
  },
  {
    icon: PenTool,
    title: "وضع التدريب",
    titleEn: "Practice Mode",
    description: "تمارين متنوعة لتثبيت المعلومات وتطوير المهارات",
    color: "gradient-nile",
    features: ["أسئلة متدرجة", "تصحيح فوري", "توضيح الأخطاء"]
  },
  {
    icon: FileCheck,
    title: "وضع الامتحان",
    titleEn: "Exam Mode",
    description: "محاكاة للامتحانات الفعلية مع توقيت ودرجات",
    color: "bg-accent",
    features: ["أسئلة نموذج الوزارة", "توقيت حقيقي", "تقرير الأداء"]
  },
  {
    icon: Lightbulb,
    title: "وضع المراجعة",
    titleEn: "Revision Mode",
    description: "ملخصات سريعة ونقاط مهمة للمراجعة قبل الامتحان",
    color: "bg-golden",
    features: ["ملخصات ذكية", "نقاط أساسية", "أسئلة مراجعة"]
  }
];

const LearningModesSection = () => {
  return (
    <section className="py-20 bg-background">
      <div className="container mx-auto px-4">
        {/* Section Header */}
        <div className="text-center mb-14">
          <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4 arabic-text">
            أوضاع التعلم
          </h2>
          <p className="text-muted-foreground max-w-xl mx-auto arabic-text">
            اختر الوضع المناسب لاحتياجاتك التعليمية
          </p>
        </div>

        {/* Modes Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {modes.map((mode, index) => (
            <div
              key={index}
              className="group flex flex-col rounded-2xl bg-card border border-border/50 shadow-card overflow-hidden hover:shadow-hover transition-all duration-300 hover:-translate-y-1"
            >
              {/* Header */}
              <div className={`${mode.color} p-6 text-primary-foreground`}>
                <mode.icon className="w-10 h-10 mb-4" />
                <h3 className="text-lg font-bold arabic-text">{mode.title}</h3>
                <p className="text-sm opacity-80">{mode.titleEn}</p>
              </div>

              {/* Content */}
              <div className="p-6 flex-1 flex flex-col">
                <p className="text-sm text-muted-foreground mb-4 arabic-text">
                  {mode.description}
                </p>

                {/* Features */}
                <ul className="space-y-2 mb-6 flex-1">
                  {mode.features.map((feature, fIndex) => (
                    <li key={fIndex} className="flex items-center gap-2 text-sm text-foreground arabic-text">
                      <span className="w-1.5 h-1.5 rounded-full bg-primary" />
                      {feature}
                    </li>
                  ))}
                </ul>

                {/* CTA */}
                <Button variant="outline" size="sm" className="w-full group/btn">
                  <span>جرّب الآن</span>
                  <ArrowLeft className="w-4 h-4 transition-transform group-hover/btn:-translate-x-1" />
                </Button>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default LearningModesSection;
