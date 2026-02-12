import { 
  Brain, 
  Target, 
  MessageCircle, 
  BarChart3, 
  Clock, 
  Shield 
} from "lucide-react";

const features = [
  {
    icon: Brain,
    title: "ذكاء اصطناعي متقدم",
    description: "يفهم أسلوب تعلمك ويتكيف معك لتقديم شرح مخصص يناسب مستواك"
  },
  {
    icon: Target,
    title: "تدريبات تفاعلية",
    description: "أسئلة متدرجة الصعوبة مع تصحيح فوري وتوضيح للأخطاء"
  },
  {
    icon: MessageCircle,
    title: "حوار تعليمي مباشر",
    description: "اسأل أي سؤال واحصل على إجابة فورية بأسلوب مبسط وواضح"
  },
  {
    icon: BarChart3,
    title: "تتبع التقدم",
    description: "تقارير مفصلة عن أدائك ونقاط القوة والضعف لديك"
  },
  {
    icon: Clock,
    title: "متاح على مدار الساعة",
    description: "تعلم في أي وقت يناسبك بدون قيود أو حدود"
  },
  {
    icon: Shield,
    title: "محتوى موثوق",
    description: "شرح متوافق 100% مع المناهج المصرية الرسمية"
  }
];

const FeaturesSection = () => {
  return (
    <section id="features" className="py-20 bg-muted">
      <div className="container mx-auto px-4">
        {/* Section Header */}
        <div className="text-center mb-14">
          <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4 arabic-text">
            لماذا EduCore Egypt؟
          </h2>
          <p className="text-muted-foreground max-w-xl mx-auto arabic-text">
            نجمع بين أحدث تقنيات الذكاء الاصطناعي وأفضل أساليب التعليم
          </p>
        </div>

        {/* Features Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {features.map((feature, index) => (
            <div
              key={index}
              className="group p-6 rounded-2xl bg-card border border-border/50 shadow-soft hover:shadow-card transition-all duration-300 hover:-translate-y-1"
            >
              {/* Icon */}
              <div className="w-12 h-12 rounded-xl gradient-hero flex items-center justify-center mb-4 shadow-soft group-hover:scale-110 transition-transform">
                <feature.icon className="w-6 h-6 text-primary-foreground" />
              </div>

              {/* Content */}
              <h3 className="font-bold text-lg text-foreground mb-2 arabic-text">
                {feature.title}
              </h3>
              <p className="text-sm text-muted-foreground arabic-text leading-relaxed">
                {feature.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;
