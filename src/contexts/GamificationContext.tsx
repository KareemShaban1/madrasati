import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';

export interface Badge {
  id: string;
  name: string;
  nameEn: string;
  description: string;
  icon: string;
  category: 'learning' | 'streak' | 'mastery' | 'special';
  requirement: number;
  earned: boolean;
  earnedAt?: string;
}

export interface Achievement {
  id: string;
  title: string;
  description: string;
  icon: string;
  xpReward: number;
  unlocked: boolean;
  unlockedAt?: string;
  progress: number;
  target: number;
}

export interface GamificationState {
  xp: number;
  level: number;
  streak: number;
  lastActivityDate: string | null;
  lessonsCompleted: number;
  quizzesCompleted: number;
  perfectQuizzes: number;
  totalTimeSpent: number; // in minutes
  badges: Badge[];
  achievements: Achievement[];
}

interface GamificationContextType extends GamificationState {
  addXP: (amount: number, reason?: string) => void;
  completeLesson: (lessonId: string) => void;
  completeQuiz: (score: number, totalQuestions: number) => void;
  updateStreak: () => void;
  getLevelProgress: () => number;
  getXPForNextLevel: () => number;
  recentReward: { xp: number; badge?: Badge; achievement?: Achievement } | null;
  clearRecentReward: () => void;
}

const defaultBadges: Badge[] = [
  // Learning Badges
  { id: 'first-lesson', name: 'الخطوة الأولى', nameEn: 'First Step', description: 'أكمل أول درس', icon: '🎯', category: 'learning', requirement: 1, earned: false },
  { id: 'lesson-5', name: 'متعلم نشيط', nameEn: 'Active Learner', description: 'أكمل 5 دروس', icon: '📚', category: 'learning', requirement: 5, earned: false },
  { id: 'lesson-10', name: 'طالب مجتهد', nameEn: 'Diligent Student', description: 'أكمل 10 دروس', icon: '🌟', category: 'learning', requirement: 10, earned: false },
  { id: 'lesson-25', name: 'باحث عن المعرفة', nameEn: 'Knowledge Seeker', description: 'أكمل 25 درس', icon: '🎓', category: 'learning', requirement: 25, earned: false },
  { id: 'lesson-50', name: 'عالم صغير', nameEn: 'Young Scholar', description: 'أكمل 50 درس', icon: '🏆', category: 'learning', requirement: 50, earned: false },
  
  // Streak Badges
  { id: 'streak-3', name: 'بداية قوية', nameEn: 'Strong Start', description: '3 أيام متتالية', icon: '🔥', category: 'streak', requirement: 3, earned: false },
  { id: 'streak-7', name: 'أسبوع كامل', nameEn: 'Full Week', description: '7 أيام متتالية', icon: '⚡', category: 'streak', requirement: 7, earned: false },
  { id: 'streak-14', name: 'المثابر', nameEn: 'Persistent', description: '14 يوم متتالي', icon: '💪', category: 'streak', requirement: 14, earned: false },
  { id: 'streak-30', name: 'البطل الشهري', nameEn: 'Monthly Champion', description: '30 يوم متتالي', icon: '👑', category: 'streak', requirement: 30, earned: false },
  
  // Mastery Badges
  { id: 'perfect-quiz-1', name: 'إجابة مثالية', nameEn: 'Perfect Answer', description: 'اختبار بدون أخطاء', icon: '✨', category: 'mastery', requirement: 1, earned: false },
  { id: 'perfect-quiz-5', name: 'متقن', nameEn: 'Master', description: '5 اختبارات مثالية', icon: '💎', category: 'mastery', requirement: 5, earned: false },
  { id: 'perfect-quiz-10', name: 'عبقري', nameEn: 'Genius', description: '10 اختبارات مثالية', icon: '🧠', category: 'mastery', requirement: 10, earned: false },
  
  // Special Badges
  { id: 'early-bird', name: 'الطائر المبكر', nameEn: 'Early Bird', description: 'تعلم قبل 7 صباحاً', icon: '🌅', category: 'special', requirement: 1, earned: false },
  { id: 'night-owl', name: 'بومة الليل', nameEn: 'Night Owl', description: 'تعلم بعد 10 مساءً', icon: '🦉', category: 'special', requirement: 1, earned: false },
  { id: 'weekend-warrior', name: 'محارب عطلة نهاية الأسبوع', nameEn: 'Weekend Warrior', description: 'تعلم في عطلة نهاية الأسبوع', icon: '⚔️', category: 'special', requirement: 1, earned: false },
];

const defaultAchievements: Achievement[] = [
  { id: 'xp-100', title: 'جامع النقاط', description: 'اجمع 100 نقطة خبرة', icon: '💫', xpReward: 25, unlocked: false, progress: 0, target: 100 },
  { id: 'xp-500', title: 'صائد النقاط', description: 'اجمع 500 نقطة خبرة', icon: '⭐', xpReward: 50, unlocked: false, progress: 0, target: 500 },
  { id: 'xp-1000', title: 'ملك النقاط', description: 'اجمع 1000 نقطة خبرة', icon: '🌟', xpReward: 100, unlocked: false, progress: 0, target: 1000 },
  { id: 'level-5', title: 'المستوى الخامس', description: 'وصلت للمستوى 5', icon: '🎖️', xpReward: 50, unlocked: false, progress: 0, target: 5 },
  { id: 'level-10', title: 'المستوى العاشر', description: 'وصلت للمستوى 10', icon: '🏅', xpReward: 100, unlocked: false, progress: 0, target: 10 },
  { id: 'all-badges', title: 'جامع الشارات', description: 'احصل على 10 شارات', icon: '🎪', xpReward: 200, unlocked: false, progress: 0, target: 10 },
];

const STORAGE_KEY = 'educore-gamification';

const GamificationContext = createContext<GamificationContextType | undefined>(undefined);

// XP required for each level (increases progressively)
const getXPForLevel = (level: number): number => {
  return Math.floor(100 * Math.pow(1.5, level - 1));
};

const getTotalXPForLevel = (level: number): number => {
  let total = 0;
  for (let i = 1; i < level; i++) {
    total += getXPForLevel(i);
  }
  return total;
};

export const GamificationProvider = ({ children }: { children: ReactNode }) => {
  const [state, setState] = useState<GamificationState>(() => {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
      return JSON.parse(saved);
    }
    return {
      xp: 0,
      level: 1,
      streak: 0,
      lastActivityDate: null,
      lessonsCompleted: 0,
      quizzesCompleted: 0,
      perfectQuizzes: 0,
      totalTimeSpent: 0,
      badges: defaultBadges,
      achievements: defaultAchievements,
    };
  });

  const [recentReward, setRecentReward] = useState<{ xp: number; badge?: Badge; achievement?: Achievement } | null>(null);

  // Persist state to localStorage
  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
  }, [state]);

  const calculateLevel = (totalXP: number): number => {
    let level = 1;
    let xpRequired = getXPForLevel(level);
    let accumulatedXP = 0;
    
    while (accumulatedXP + xpRequired <= totalXP) {
      accumulatedXP += xpRequired;
      level++;
      xpRequired = getXPForLevel(level);
    }
    
    return level;
  };

  const addXP = (amount: number, reason?: string) => {
    setState(prev => {
      const newXP = prev.xp + amount;
      const newLevel = calculateLevel(newXP);
      
      // Check XP-based achievements
      const updatedAchievements = prev.achievements.map(achievement => {
        if (achievement.id.startsWith('xp-') && !achievement.unlocked) {
          const newProgress = newXP;
          if (newProgress >= achievement.target) {
            return { ...achievement, unlocked: true, unlockedAt: new Date().toISOString(), progress: achievement.target };
          }
          return { ...achievement, progress: newProgress };
        }
        if (achievement.id.startsWith('level-') && !achievement.unlocked) {
          if (newLevel >= achievement.target) {
            return { ...achievement, unlocked: true, unlockedAt: new Date().toISOString(), progress: achievement.target };
          }
          return { ...achievement, progress: newLevel };
        }
        return achievement;
      });

      setRecentReward({ xp: amount });

      return {
        ...prev,
        xp: newXP,
        level: newLevel,
        achievements: updatedAchievements,
      };
    });
  };

  const checkAndAwardBadges = (
    lessonsCompleted: number,
    streak: number,
    perfectQuizzes: number
  ): Badge | undefined => {
    let newBadge: Badge | undefined;

    setState(prev => {
      const updatedBadges = prev.badges.map(badge => {
        if (badge.earned) return badge;

        let shouldEarn = false;

        // Learning badges
        if (badge.category === 'learning' && lessonsCompleted >= badge.requirement) {
          shouldEarn = true;
        }
        // Streak badges
        if (badge.category === 'streak' && streak >= badge.requirement) {
          shouldEarn = true;
        }
        // Mastery badges
        if (badge.category === 'mastery' && perfectQuizzes >= badge.requirement) {
          shouldEarn = true;
        }
        // Special badges (time-based)
        if (badge.category === 'special') {
          const hour = new Date().getHours();
          const day = new Date().getDay();
          
          if (badge.id === 'early-bird' && hour < 7) shouldEarn = true;
          if (badge.id === 'night-owl' && hour >= 22) shouldEarn = true;
          if (badge.id === 'weekend-warrior' && (day === 5 || day === 6)) shouldEarn = true;
        }

        if (shouldEarn) {
          newBadge = { ...badge, earned: true, earnedAt: new Date().toISOString() };
          return newBadge;
        }
        return badge;
      });

      // Check badge collection achievement
      const earnedBadgesCount = updatedBadges.filter(b => b.earned).length;
      const updatedAchievements = prev.achievements.map(achievement => {
        if (achievement.id === 'all-badges' && !achievement.unlocked) {
          if (earnedBadgesCount >= achievement.target) {
            return { ...achievement, unlocked: true, unlockedAt: new Date().toISOString(), progress: achievement.target };
          }
          return { ...achievement, progress: earnedBadgesCount };
        }
        return achievement;
      });

      return {
        ...prev,
        badges: updatedBadges,
        achievements: updatedAchievements,
      };
    });

    return newBadge;
  };

  const completeLesson = (lessonId: string) => {
    const newLessonsCompleted = state.lessonsCompleted + 1;
    const xpEarned = 25;

    setState(prev => ({
      ...prev,
      lessonsCompleted: newLessonsCompleted,
    }));

    addXP(xpEarned, 'إكمال درس');
    updateStreak();
    const newBadge = checkAndAwardBadges(newLessonsCompleted, state.streak, state.perfectQuizzes);
    
    if (newBadge) {
      setRecentReward({ xp: xpEarned, badge: newBadge });
    }
  };

  const completeQuiz = (score: number, totalQuestions: number) => {
    const isPerfect = score === totalQuestions;
    const newPerfectQuizzes = isPerfect ? state.perfectQuizzes + 1 : state.perfectQuizzes;
    const baseXP = 10;
    const bonusXP = isPerfect ? 15 : Math.floor((score / totalQuestions) * 10);
    const xpEarned = baseXP + bonusXP;

    setState(prev => ({
      ...prev,
      quizzesCompleted: prev.quizzesCompleted + 1,
      perfectQuizzes: newPerfectQuizzes,
    }));

    addXP(xpEarned, 'إكمال اختبار');
    const newBadge = checkAndAwardBadges(state.lessonsCompleted, state.streak, newPerfectQuizzes);
    
    if (newBadge) {
      setRecentReward({ xp: xpEarned, badge: newBadge });
    }
  };

  const updateStreak = () => {
    const today = new Date().toDateString();
    const lastActivity = state.lastActivityDate;

    setState(prev => {
      if (lastActivity === today) {
        return prev; // Already counted today
      }

      const yesterday = new Date();
      yesterday.setDate(yesterday.getDate() - 1);
      const wasYesterday = lastActivity === yesterday.toDateString();

      const newStreak = wasYesterday ? prev.streak + 1 : 1;

      return {
        ...prev,
        streak: newStreak,
        lastActivityDate: today,
      };
    });
  };

  const getLevelProgress = (): number => {
    const currentLevelXP = getTotalXPForLevel(state.level);
    const nextLevelXP = getTotalXPForLevel(state.level + 1);
    const xpInCurrentLevel = state.xp - currentLevelXP;
    const xpNeededForLevel = nextLevelXP - currentLevelXP;
    
    return Math.min((xpInCurrentLevel / xpNeededForLevel) * 100, 100);
  };

  const getXPForNextLevel = (): number => {
    const currentLevelXP = getTotalXPForLevel(state.level);
    const nextLevelXP = getTotalXPForLevel(state.level + 1);
    return nextLevelXP - state.xp;
  };

  const clearRecentReward = () => {
    setRecentReward(null);
  };

  return (
    <GamificationContext.Provider
      value={{
        ...state,
        addXP,
        completeLesson,
        completeQuiz,
        updateStreak,
        getLevelProgress,
        getXPForNextLevel,
        recentReward,
        clearRecentReward,
      }}
    >
      {children}
    </GamificationContext.Provider>
  );
};

export const useGamification = () => {
  const context = useContext(GamificationContext);
  if (context === undefined) {
    throw new Error('useGamification must be used within a GamificationProvider');
  }
  return context;
};
