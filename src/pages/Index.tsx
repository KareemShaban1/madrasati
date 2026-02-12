import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import HeroSection from "@/components/home/HeroSection";
import SubjectsSection from "@/components/home/SubjectsSection";
import GradesSection from "@/components/home/GradesSection";
import FeaturesSection from "@/components/home/FeaturesSection";
import LearningModesSection from "@/components/home/LearningModesSection";
import CTASection from "@/components/home/CTASection";

const Index = () => {
  return (
    <div className="min-h-screen bg-background overflow-x-hidden" dir="rtl">
      <Header />
      <main className="scroll-smooth">
        <HeroSection />
        <SubjectsSection />
        <GradesSection />
        <FeaturesSection />
        <LearningModesSection />
        <CTASection />
      </main>
      <Footer />
    </div>
  );
};

export default Index;
