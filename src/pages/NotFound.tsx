import { useLocation, Link } from "react-router-dom";
import { useEffect } from "react";
import { FileQuestion, Home } from "lucide-react";
import { Button } from "@/components/ui/button";

const NotFound = () => {
  const location = useLocation();

  useEffect(() => {
    console.error("404 Error: User attempted to access non-existent route:", location.pathname);
  }, [location.pathname]);

  return (
    <div className="flex min-h-screen flex-col items-center justify-center bg-background px-4" dir="rtl">
      <div className="text-center max-w-md animate-fade-in-up">
        <div className="w-24 h-24 rounded-2xl gradient-hero flex items-center justify-center mx-auto mb-6 shadow-soft">
          <FileQuestion className="w-12 h-12 text-primary-foreground" />
        </div>
        <h1 className="mb-2 text-5xl sm:text-6xl font-bold text-foreground">404</h1>
        <p className="mb-2 text-lg text-muted-foreground arabic-text">
          الصفحة غير موجودة
        </p>
        <p className="mb-8 text-sm text-muted-foreground">
          عذراً، لم نتمكن من العثور على الصفحة المطلوبة
        </p>
        <Link to="/">
          <Button variant="hero" size="lg" className="gap-2">
            <Home className="w-5 h-5" />
            العودة للرئيسية
          </Button>
        </Link>
      </div>
    </div>
  );
};

export default NotFound;
