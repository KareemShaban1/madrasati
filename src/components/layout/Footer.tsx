import { Link } from "react-router-dom";
import { GraduationCap, BookOpen, Shield, FileText, Mail } from "lucide-react";

const footerLinks = [
  { href: "#", label: "عن المنصة", icon: BookOpen },
  { href: "#", label: "سياسة الخصوصية", icon: Shield },
  { href: "#", label: "شروط الاستخدام", icon: FileText },
  { href: "#", label: "تواصل معنا", icon: Mail },
];

const Footer = () => {
  return (
    <footer className="bg-foreground text-primary-foreground relative overflow-hidden">
      {/* Subtle gradient overlay */}
      <div className="absolute inset-0 bg-gradient-to-t from-primary/5 to-transparent pointer-events-none" />
      <div className="container mx-auto px-4 sm:px-6 max-w-7xl relative py-10 sm:py-14">
        <div className="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12">
          {/* Logo */}
          <Link
            to="/"
            className="flex items-center gap-3 justify-center md:justify-start group shrink-0"
          >
            <div className="w-11 h-11 rounded-xl bg-primary/20 flex items-center justify-center group-hover:bg-primary/30 transition-colors">
              <GraduationCap className="w-6 h-6" />
            </div>
            <div className="flex flex-col">
              <span className="font-bold text-base sm:text-lg leading-tight">EduCore Egypt</span>
              <span className="text-xs opacity-80 leading-tight">منصة تعليمية ذكية 🇪🇬</span>
            </div>
          </Link>

          {/* Links */}
          <nav className="flex flex-wrap items-center justify-center gap-6 sm:gap-8 text-sm">
            {footerLinks.map(({ href, label, icon: Icon }) => (
              <a
                key={label}
                href={href}
                className="flex items-center gap-2 opacity-75 hover:opacity-100 transition-opacity duration-200"
              >
                <Icon className="w-4 h-4 opacity-70" />
                {label}
              </a>
            ))}
          </nav>

          {/* Copyright */}
          <p className="text-xs sm:text-sm opacity-70 arabic-text text-center md:text-left max-w-full">
            © 2025 EduCore Egypt. جميع الحقوق محفوظة.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
