import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { GamificationProvider } from "@/contexts/GamificationContext";
import RewardPopup from "@/components/gamification/RewardPopup";
import Index from "./pages/Index";
import StagePage from "./pages/StagePage";
import GradePage from "./pages/GradePage";
import SubjectDetailPage from "./pages/SubjectDetailPage";
import LessonPage from "./pages/LessonPage";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <GamificationProvider>
      <TooltipProvider>
        <Toaster />
        <Sonner />
        <RewardPopup />
        <BrowserRouter>
          <Routes>
            <Route path="/" element={<Index />} />
            <Route path="/stage/:stageId" element={<StagePage />} />
            <Route path="/stage/:stageId/grade/:gradeId" element={<GradePage />} />
            <Route path="/stage/:stageId/grade/:gradeId/subject/:subjectId" element={<SubjectDetailPage />} />
            {/* Short lesson URL: /lesson/:subjectId/:lessonId (e.g. /lesson/p1-math/lesson-1) */}
            <Route path="/lesson/:subjectId/:lessonId" element={<LessonPage />} />
            <Route path="/stage/:stageId/grade/:gradeId/subject/:subjectId/unit/:unitId/lesson/:lessonId" element={<LessonPage />} />
            {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
            <Route path="*" element={<NotFound />} />
          </Routes>
        </BrowserRouter>
      </TooltipProvider>
    </GamificationProvider>
  </QueryClientProvider>
);

export default App;
