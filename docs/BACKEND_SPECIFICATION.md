# EduCore Egypt - Backend Specification

## Project Overview

**EduCore Egypt** is an AI-powered educational platform for Egyptian students, aligned with the national curriculum across all grades. The platform follows a mandatory 8-step pedagogical pipeline for all lessons.

### Tech Stack (Frontend)
- **Framework**: React 18 + TypeScript
- **Build Tool**: Vite
- **Styling**: Tailwind CSS + shadcn/ui
- **State Management**: React Context + TanStack Query
- **Routing**: React Router DOM v6

---

## Data Architecture

### Curriculum Hierarchy (5-tier structure)

```
Stage (المرحلة)
└── Grade (الصف)
    └── Subject (المادة)
        └── Unit (الوحدة)
            └── Lesson (الدرس)
```

#### 1. Stage (المرحلة)
```typescript
interface Stage {
  id: string;           // "primary" | "preparatory" | "secondary"
  name: string;         // Arabic name: "المرحلة الابتدائية"
  nameEn: string;       // English name: "Primary School"
  description: string;  // Stage description
  grades: Grade[];
}
```

#### 2. Grade (الصف)
```typescript
interface Grade {
  id: string;           // "primary-1", "primary-6", "prep-1", etc.
  name: string;         // "الصف الأول الابتدائي"
  nameEn: string;       // "Grade 1"
  subjects: Subject[];
}
```

#### 3. Subject (المادة)
```typescript
interface Subject {
  id: string;           // "p6-math", "p6-arabic", "p6-science"
  name: string;         // "الرياضيات"
  nameEn: string;       // "Mathematics"
  icon: string;         // Lucide icon name
  color: string;        // Tailwind color class
  units: Unit[];
}
```

#### 4. Unit (الوحدة)
```typescript
interface Unit {
  id: string;           // "numbers-operations", "geometry"
  name: string;         // "الأعداد والعمليات"
  nameEn: string;       // "Numbers & Operations"
  description: string;
  lessons: Lesson[];
}
```

#### 5. Lesson (الدرس)
```typescript
interface Lesson {
  id: string;           // "lesson-1", "lesson-2"
  title: string;        // "مفهوم الأعداد الصحيحة"
  titleEn: string;      // "Understanding Integers"
  duration: string;     // "15 دقيقة"
  type: "video" | "interactive" | "quiz";
}
```

---

## Lesson Content Structure

Each lesson follows an **8-step pedagogical pipeline**:

### LessonContent Interface
```typescript
interface LessonContent {
  lessonId: string;
  title: string;
  titleEn: string;
  objectives: string[];           // Learning objectives
  keyPoints: string[];            // Key takeaways
  sections: LessonSection[];      // Content sections
  quickQuiz: QuizQuestion[];      // Assessment questions
  prevLessonId?: string;
  nextLessonId?: string;
}
```

### Section Types
```typescript
type LessonSection = 
  | VideoSection
  | TextSection
  | SummarySection
  | CartoonSection
  | StorySection
  | VisualizationSection
  | CharacterDialogSection
  | StepByStepSection
  | InteractiveSection;
```

#### Section Interfaces

```typescript
// Video content
interface VideoSection {
  type: "video";
  title: string;
  videoUrl: string;
  duration: string;
}

// Rich text content
interface TextSection {
  type: "text";
  title: string;
  content: string;  // Supports markdown/HTML
}

// Summary/recap
interface SummarySection {
  type: "summary";
  title: string;
  points: string[];
}

// Educational cartoon/illustration
interface CartoonSection {
  type: "cartoon";
  title: string;
  description: string;
  imageUrl?: string;
  caption: string;
}

// Narrative story for context
interface StorySection {
  type: "story";
  title: string;
  content: string;
  moral?: string;
}

// Visual metaphor/diagram
interface VisualizationSection {
  type: "visualization";
  title: string;
  description: string;
  imageUrl?: string;
}

// Character-led instruction
interface CharacterDialogSection {
  type: "character-dialog";
  character: {
    name: string;      // "الأستاذ عادل"
    nameEn: string;    // "Professor Adel"
    role: string;      // "معلم الرياضيات"
    avatar?: string;
  };
  messages: string[];  // Dialog messages
}

// Step-by-step guide
interface StepByStepSection {
  type: "step-by-step";
  title: string;
  steps: {
    stepNumber: number;
    title: string;
    content: string;
    tip?: string;
  }[];
}

// Interactive exercise
interface InteractiveSection {
  type: "interactive";
  title: string;
  instructions: string;
  exerciseType: "fill-blank" | "drag-drop" | "matching" | "ordering";
  exercises: {
    question: string;
    correctAnswer: string;
    options?: string[];
  }[];
}
```

### Quiz Questions
```typescript
interface QuizQuestion {
  id: string;
  question: string;
  options: string[];
  correctAnswer: number;  // Index of correct option
  explanation?: string;
}
```

---

## Gamification System

### User Progress Model
```typescript
interface UserProgress {
  id: string;
  
  // XP & Levels
  totalXP: number;
  level: number;
  
  // Streaks
  currentStreak: number;
  longestStreak: number;
  lastActivityDate: string;  // ISO date
  
  // Completion tracking
  completedLessons: string[];      // Lesson IDs
  completedQuizzes: string[];      // Quiz IDs
  
  // Badges & Achievements
  unlockedBadges: string[];        // Badge IDs
  unlockedAchievements: string[];  // Achievement IDs
  
  // Quiz performance
  quizScores: {
    lessonId: string;
    score: number;
    maxScore: number;
    completedAt: string;
  }[];
}
```

### XP Rewards System
| Action | XP Reward |
|--------|-----------|
| Complete lesson | +25 XP |
| Complete quiz (100%) | +25 XP |
| Complete quiz (75%+) | +15 XP |
| Complete quiz (<75%) | +10 XP |
| Daily login streak | +5 XP per day |

### Level Calculation
```typescript
function calculateLevel(totalXP: number): number {
  // Progressive difficulty curve
  // Level 1: 0-99 XP
  // Level 2: 100-249 XP
  // Level 3: 250-449 XP
  // etc.
  return Math.floor(Math.sqrt(totalXP / 50)) + 1;
}
```

### Badges System
```typescript
interface Badge {
  id: string;
  name: string;           // Arabic name
  nameEn: string;         // English name
  description: string;
  icon: string;           // Lucide icon name
  category: "learning" | "streak" | "mastery" | "special";
  requirement: BadgeRequirement;
}

interface BadgeRequirement {
  type: "lessons_completed" | "quizzes_passed" | "streak_days" | "perfect_quizzes" | "subject_mastery";
  value: number;
  subjectId?: string;  // For subject-specific badges
}
```

### Available Badges
| ID | Name | Category | Requirement |
|----|------|----------|-------------|
| first-lesson | المتعلم الأول | learning | Complete 1 lesson |
| five-lessons | المستكشف | learning | Complete 5 lessons |
| ten-lessons | الباحث | learning | Complete 10 lessons |
| twenty-lessons | العالم الصغير | learning | Complete 20 lessons |
| streak-3 | نجم الاستمرارية | streak | 3-day streak |
| streak-7 | بطل الأسبوع | streak | 7-day streak |
| streak-30 | الملتزم | streak | 30-day streak |
| first-quiz | المختبر الأول | mastery | Complete 1 quiz |
| perfect-quiz | الإتقان | mastery | 100% on any quiz |
| five-perfect | الخبير | mastery | 5 perfect quizzes |
| math-master | عبقري الرياضيات | special | 10 math lessons |
| science-master | عالم المستقبل | special | 10 science lessons |
| arabic-master | فارس اللغة | special | 10 Arabic lessons |
| english-master | متحدث عالمي | special | 10 English lessons |
| social-master | مؤرخ صغير | special | 10 social studies lessons |

### Achievements System
```typescript
interface Achievement {
  id: string;
  name: string;
  description: string;
  icon: string;
  maxProgress: number;
  xpReward: number;
}
```

---

## API Endpoints Specification

### Authentication
```
POST   /api/auth/register          # Register new user
POST   /api/auth/login             # Login
POST   /api/auth/logout            # Logout
POST   /api/auth/refresh           # Refresh token
GET    /api/auth/me                # Get current user
POST   /api/auth/forgot-password   # Request password reset
POST   /api/auth/reset-password    # Reset password
```

### User Profile
```
GET    /api/users/:id              # Get user profile
PUT    /api/users/:id              # Update profile
GET    /api/users/:id/progress     # Get learning progress
GET    /api/users/:id/badges       # Get earned badges
GET    /api/users/:id/achievements # Get achievements
```

### Curriculum
```
GET    /api/stages                 # List all stages
GET    /api/stages/:id             # Get stage details
GET    /api/stages/:id/grades      # List grades in stage
GET    /api/grades/:id             # Get grade details
GET    /api/grades/:id/subjects    # List subjects in grade
GET    /api/subjects/:id           # Get subject details
GET    /api/subjects/:id/units     # List units in subject
GET    /api/units/:id              # Get unit details
GET    /api/units/:id/lessons      # List lessons in unit
GET    /api/lessons/:id            # Get lesson details
GET    /api/lessons/:id/content    # Get full lesson content
```

### Progress & Gamification
```
POST   /api/progress/lesson        # Mark lesson complete
POST   /api/progress/quiz          # Submit quiz results
GET    /api/progress/streak        # Get streak info
POST   /api/progress/streak/check  # Check/update daily streak
GET    /api/leaderboard            # Get leaderboard
GET    /api/leaderboard/:gradeId   # Grade-specific leaderboard
```

### Analytics (Admin)
```
GET    /api/analytics/users        # User activity stats
GET    /api/analytics/lessons      # Lesson completion rates
GET    /api/analytics/subjects     # Subject popularity
```

---

## Database Schema (Suggested)

### Users Table
```sql
CREATE TABLE users (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  avatar_url TEXT,
  grade_id VARCHAR(50),
  role VARCHAR(20) DEFAULT 'student', -- 'student', 'teacher', 'admin'
  created_at TIMESTAMP DEFAULT NOW(),
  updated_at TIMESTAMP DEFAULT NOW()
);
```

### User Progress Table
```sql
CREATE TABLE user_progress (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  total_xp INTEGER DEFAULT 0,
  level INTEGER DEFAULT 1,
  current_streak INTEGER DEFAULT 0,
  longest_streak INTEGER DEFAULT 0,
  last_activity_date DATE,
  updated_at TIMESTAMP DEFAULT NOW()
);
```

### Completed Lessons Table
```sql
CREATE TABLE completed_lessons (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  lesson_id VARCHAR(100) NOT NULL,
  completed_at TIMESTAMP DEFAULT NOW(),
  UNIQUE(user_id, lesson_id)
);
```

### Quiz Results Table
```sql
CREATE TABLE quiz_results (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  lesson_id VARCHAR(100) NOT NULL,
  score INTEGER NOT NULL,
  max_score INTEGER NOT NULL,
  answers JSONB, -- Stores individual answers
  completed_at TIMESTAMP DEFAULT NOW()
);
```

### User Badges Table
```sql
CREATE TABLE user_badges (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  badge_id VARCHAR(50) NOT NULL,
  earned_at TIMESTAMP DEFAULT NOW(),
  UNIQUE(user_id, badge_id)
);
```

### User Achievements Table
```sql
CREATE TABLE user_achievements (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  achievement_id VARCHAR(50) NOT NULL,
  current_progress INTEGER DEFAULT 0,
  completed BOOLEAN DEFAULT FALSE,
  completed_at TIMESTAMP,
  UNIQUE(user_id, achievement_id)
);
```

---

## Real-time Features (WebSocket)

### Events to Broadcast
```typescript
// User earns XP
{ type: "XP_EARNED", userId: string, amount: number, newTotal: number }

// User levels up
{ type: "LEVEL_UP", userId: string, newLevel: number }

// Badge unlocked
{ type: "BADGE_UNLOCKED", userId: string, badgeId: string }

// Achievement progress
{ type: "ACHIEVEMENT_PROGRESS", userId: string, achievementId: string, progress: number }

// Streak update
{ type: "STREAK_UPDATE", userId: string, currentStreak: number }
```

---

## AI Features (Future)

### AI Chat Assistant
- Context-aware responses based on current lesson
- Explain concepts in simpler terms
- Answer student questions
- Provide hints for exercises

### Personalized Learning
- Adaptive difficulty based on quiz performance
- Recommended next lessons
- Weak areas identification
- Custom practice exercises

---

## Security Considerations

1. **Authentication**: JWT-based with refresh tokens
2. **Authorization**: Role-based access control (RBAC)
3. **Rate Limiting**: Prevent API abuse
4. **Input Validation**: Sanitize all user inputs
5. **Data Privacy**: GDPR/COPPA compliance for student data

---

## Environment Variables

```env
# Database
DATABASE_URL=postgresql://...

# Authentication
JWT_SECRET=your-secret-key
JWT_EXPIRY=15m
REFRESH_TOKEN_EXPIRY=7d

# AI Features (optional)
OPENAI_API_KEY=sk-...

# Storage
STORAGE_BUCKET=educore-assets

# Analytics
ANALYTICS_KEY=...
```

---

## File Structure Reference

```
src/
├── components/
│   ├── gamification/
│   │   ├── AchievementsPanel.tsx    # Progress panel
│   │   ├── BadgesDisplay.tsx        # Badge showcase
│   │   ├── LessonCompleteCard.tsx   # Completion celebration
│   │   ├── RewardPopup.tsx          # Badge/achievement popup
│   │   └── XPBar.tsx                # XP progress bar
│   ├── lesson/
│   │   ├── LessonContent.tsx        # Content renderer
│   │   ├── LessonHeader.tsx         # Lesson title/meta
│   │   ├── LessonNavigation.tsx     # Prev/next controls
│   │   ├── LessonQuiz.tsx           # Quiz component
│   │   ├── LessonSidebar.tsx        # Key points sidebar
│   │   └── LessonVideo.tsx          # Video player
│   └── subject/
│       ├── ExercisesSection.tsx
│       ├── LessonsList.tsx
│       ├── ProgressOverview.tsx
│       └── SubjectHero.tsx
├── contexts/
│   └── GamificationContext.tsx      # Gamification state
├── data/
│   ├── curriculum.ts                # Full curriculum data
│   ├── lessonContent.ts             # Lesson content mapping
│   └── gradeContent/
│       └── primary6Content.ts       # Grade 6 specific content
└── pages/
    ├── GradePage.tsx
    ├── Index.tsx
    ├── LessonPage.tsx
    ├── StagePage.tsx
    └── SubjectDetailPage.tsx
```

---

## Contact

For questions about this specification, refer to the codebase or project documentation.
