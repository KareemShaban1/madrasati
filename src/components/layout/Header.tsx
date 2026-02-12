import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Menu, X, GraduationCap } from "lucide-react";
import XPBar from "@/components/gamification/XPBar";
import BadgesDisplay from "@/components/gamification/BadgesDisplay";

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const location = useLocation();
  const isHome = location.pathname === "/";

  const navLinks = [
    { href: "#subjects", label: "المواد الدراسية" },
    { href: "#grades", label: "المراحل التعليمية" },
    { href: "#features", label: "المميزات" },
  ];

  const handleNavClick = (e: React.MouseEvent<HTMLAnchorElement>, href: string) => {
    if (!isHome || !href.startsWith("#")) return;
    e.preventDefault();
    document.querySelector(href)?.scrollIntoView({ behavior: "smooth" });
    setIsMenuOpen(false);
  };

  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-background/90 backdrop-blur-xl border-b border-border/50 shadow-sm overflow-x-hidden transition-shadow duration-300">
      <div className="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link
            to="/"
            className="flex items-center gap-3 group min-h-[44px] min-w-[44px] items-center"
          >
            <div className="w-10 h-10 rounded-xl gradient-hero flex items-center justify-center shadow-soft group-hover:shadow-hover transition-shadow duration-300">
              <GraduationCap className="w-6 h-6 text-primary-foreground" />
            </div>
            <div className="flex flex-col">
              <span className="font-bold text-lg text-foreground leading-tight">EduCore</span>
              <span className="text-xs text-muted-foreground leading-tight">مصر 🇪🇬</span>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center gap-1">
            {navLinks.map(({ href, label }) => (
              <a
                key={href}
                href={isHome ? href : `/${href}`}
                onClick={(e) => handleNavClick(e, href)}
                className="px-4 py-2 rounded-lg text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted/60 transition-all duration-200"
              >
                {label}
              </a>
            ))}
          </nav>

          {/* Gamification Stats & Actions */}
          <div className="hidden md:flex items-center gap-2">
            <XPBar />
            <BadgesDisplay />
            <Button variant="ghost" size="sm" className="min-h-[40px]">
              تسجيل الدخول
            </Button>
            <Link to="/stage/primary">
              <Button variant="hero" size="sm" className="min-h-[40px]">
                ابدأ التعلم
              </Button>
            </Link>
          </div>

          {/* Mobile Menu Button */}
          <div className="md:hidden flex items-center gap-1">
            <XPBar />
            <button
              className="p-2.5 rounded-xl hover:bg-muted transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              aria-expanded={isMenuOpen}
            >
              {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        <div
          className={`md:hidden overflow-hidden transition-all duration-300 ease-out ${
            isMenuOpen ? "max-h-80 opacity-100" : "max-h-0 opacity-0"
          }`}
        >
          <nav className="py-4 border-t border-border/50 flex flex-col gap-1">
            <div className="flex items-center justify-between py-2 px-1">
              <BadgesDisplay />
            </div>
            {navLinks.map(({ href, label }) => (
              <a
                key={href}
                href={isHome ? href : `/${href}`}
                onClick={(e) => handleNavClick(e, href)}
                className="py-3 px-4 rounded-xl text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted/60 transition-colors"
              >
                {label}
              </a>
            ))}
            <div className="flex flex-col gap-2 pt-3 mt-2 border-t border-border/50">
              <Button variant="outline" className="w-full min-h-[44px]">
                تسجيل الدخول
              </Button>
              <Link to="/stage/primary" onClick={() => setIsMenuOpen(false)}>
                <Button variant="hero" className="w-full min-h-[44px]">
                  ابدأ التعلم
                </Button>
              </Link>
            </div>
          </nav>
        </div>
      </div>
    </header>
  );
};

export default Header;
