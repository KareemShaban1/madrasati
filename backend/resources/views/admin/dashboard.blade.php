<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - EduCore Egypt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', system-ui, sans-serif; background:#0f172a; color:#f1f5f9; margin:0; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:240px; background:#0f172a; border-right:1px solid rgba(148,163,184,0.2); padding:1.5rem 1.25rem; }
        .sidebar-brand { display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid rgba(148,163,184,0.15); }
        .sidebar-brand-icon { width:40px; height:40px; border-radius:0.75rem; background:linear-gradient(135deg,#eab308,#f59e0b,#ea580c); display:flex; align-items:center; justify-content:center; font-size:1.25rem; }
        .sidebar h1 { font-size:1.1rem; font-weight:700; margin:0; }
        .sidebar span { display:block; font-size:0.75rem; color:#94a3b8; margin-top:0.15rem; }
        .sidebar nav a { display:block; padding:0.5rem 0.65rem; font-size:0.9rem; color:#94a3b8; text-decoration:none; border-radius:0.5rem; transition:all 0.2s; }
        .sidebar nav a.active, .sidebar nav a:hover { background:#1e293b; color:#f1f5f9; }
        .main { flex:1; padding:1.5rem 2rem 2.5rem; min-width:0; }
        .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:0.75rem; }
        .topbar-title { font-size:1.35rem; font-weight:700; }
        .status { font-size:0.85rem; color:#94a3b8; display:flex; flex-wrap:wrap; gap:0.5rem; margin-top:0.25rem; }
        .logout form { display:inline; }
        .logout button { background:transparent; border:1px solid rgba(148,163,184,0.3); color:#94a3b8; border-radius:0.5rem; padding:0.4rem 0.9rem; font-size:0.85rem; cursor:pointer; transition:all 0.2s; }
        .logout button:hover { border-color:#ea580c; color:#fed7aa; }
        .grid { display:grid; gap:1.5rem; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); }
        .card { background:#1e293b; border-radius:1rem; padding:1.25rem 1.25rem; border:1px solid rgba(148,163,184,0.15); box-shadow:0 1px 3px rgba(0,0,0,0.2); transition:box-shadow 0.2s; }
        .card:hover { box-shadow:0 4px 12px rgba(0,0,0,0.25); }
        .card h2 { font-size:1rem; margin:0 0 0.5rem; font-weight:600; }
        .card p { font-size:0.8rem; color:#94a3b8; margin:0 0 1rem; line-height:1.5; }
        label { display:block; font-size:0.85rem; font-weight:500; margin-bottom:0.3rem; color:#e2e8f0; }
        input, select, textarea { width:100%; padding:0.5rem 0.65rem; border-radius:0.5rem; border:1px solid #334155; background:#0f172a; color:#f1f5f9; font-size:0.85rem; transition:border-color 0.2s, box-shadow 0.2s; }
        input:focus, select:focus, textarea:focus { outline:none; border-color:#eab308; box-shadow:0 0 0 2px rgba(234,179,8,0.25); }
        .field { margin-bottom:0.75rem; }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:0.35rem; padding:0.5rem 0.9rem; border-radius:0.5rem; border:none; font-size:0.85rem; font-weight:600; cursor:pointer; background:linear-gradient(135deg,#eab308,#f59e0b,#ea580c); color:white; transition:transform 0.15s, box-shadow 0.2s; }
        .btn:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(234,179,8,0.35); }
        .btn span { font-size:1rem; }
        .badge { display:inline-flex; align-items:center; gap:0.35rem; font-size:0.8rem; background:rgba(30,41,59,0.8); border-radius:9999px; padding:0.3rem 0.7rem; border:1px solid rgba(148,163,184,0.25); color:#94a3b8; }
        .badge strong { color:#f1f5f9; }
        .pill-count { font-size:0.75rem; padding:0 0.5rem; border-radius:9999px; background:#0f172a; font-weight:600; }
        .alert { margin-bottom:1rem; font-size:0.85rem; padding:0.65rem 1rem; border-radius:0.75rem; border:1px solid rgba(34,197,94,0.4); background:rgba(22,163,74,0.15); color:#bbf7d0; }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">📚</div>
            <div>
                <h1>EduCore Admin</h1>
                <span>Curriculum management</span>
            </div>
        </div>
        <nav>
            <a href="#" class="active">Dashboard</a>
            <a href="{{ route('admin.stages.index') }}">Stages</a>
            <a href="{{ route('admin.grades.index') }}">Grades</a>
            <a href="{{ route('admin.subjects.index') }}">Subjects</a>
            <a href="{{ route('admin.units.index') }}">Units</a>
            <a href="{{ route('admin.lessons.index') }}">Lessons</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Curriculum Dashboard</div>
                <div class="status">
                    <span class="badge">
                        Stages <span class="pill-count">{{ $stages->count() }}</span>
                    </span>
                    <span class="badge">
                        Grades <span class="pill-count">{{ $grades->count() }}</span>
                    </span>
                    <span class="badge">
                        Subjects <span class="pill-count">{{ $subjects->count() }}</span>
                    </span>
                    <span class="badge">
                        Units <span class="pill-count">{{ $units->count() }}</span>
                    </span>
                </div>
            </div>
            <div class="logout">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Sign out</button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid">
            <section class="card">
                <h2>Stage</h2>
                <p>Create a learning stage (Primary / Preparatory / Secondary).</p>
                <form method="POST" action="{{ route('admin.stages.store') }}">
                    @csrf
                    <div class="field">
                        <label for="stage_id">ID (e.g. primary)</label>
                        <input id="stage_id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="stage_name">Name (Arabic)</label>
                        <input id="stage_name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="stage_name_en">Name (English)</label>
                        <input id="stage_name_en" name="name_en" required>
                    </div>
                    <div class="field">
                        <label for="stage_description">Description</label>
                        <textarea id="stage_description" name="description" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn"><span>＋</span>Create Stage</button>
                </form>
            </section>

            <section class="card">
                <h2>Grade</h2>
                <p>Attach a grade to an existing stage.</p>
                <form method="POST" action="{{ route('admin.grades.store') }}">
                    @csrf
                    <div class="field">
                        <label for="grade_id">ID (e.g. primary-6)</label>
                        <input id="grade_id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="grade_stage_id">Stage</label>
                        <select id="grade_stage_id" name="stage_id" required>
                            <option value="">Select stage…</option>
                            @foreach($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->id }} — {{ $stage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="grade_name">Name (Arabic)</label>
                        <input id="grade_name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="grade_name_en">Name (English)</label>
                        <input id="grade_name_en" name="name_en" required>
                    </div>
                    <button type="submit" class="btn"><span>＋</span>Create Grade</button>
                </form>
            </section>

            <section class="card">
                <h2>Subject</h2>
                <p>Create a subject under a grade (Math, Arabic, Science…).</p>
                <form method="POST" action="{{ route('admin.subjects.store') }}">
                    @csrf
                    <div class="field">
                        <label for="subject_id">ID (e.g. p6-math)</label>
                        <input id="subject_id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="subject_grade_id">Grade</label>
                        <select id="subject_grade_id" name="grade_id" required>
                            <option value="">Select grade…</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->id }} — {{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="subject_name">Name (Arabic)</label>
                        <input id="subject_name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="subject_name_en">Name (English)</label>
                        <input id="subject_name_en" name="name_en" required>
                    </div>
                    <div class="field">
                        <label for="subject_icon">Icon (Lucide name, optional)</label>
                        <input id="subject_icon" name="icon">
                    </div>
                    <div class="field">
                        <label for="subject_color">Color class (e.g. text-blue-500)</label>
                        <input id="subject_color" name="color">
                    </div>
                    <button type="submit" class="btn"><span>＋</span>Create Subject</button>
                </form>
            </section>

            <section class="card">
                <h2>Unit</h2>
                <p>Group lessons inside a subject (Numbers, Geometry…).</p>
                <form method="POST" action="{{ route('admin.units.store') }}">
                    @csrf
                    <div class="field">
                        <label for="unit_id">ID (e.g. numbers-operations)</label>
                        <input id="unit_id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="unit_subject_id">Subject</label>
                        <select id="unit_subject_id" name="subject_id" required>
                            <option value="">Select subject…</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->id }} — {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="unit_name">Name (Arabic)</label>
                        <input id="unit_name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="unit_name_en">Name (English)</label>
                        <input id="unit_name_en" name="name_en" required>
                    </div>
                    <div class="field">
                        <label for="unit_description">Description</label>
                        <textarea id="unit_description" name="description" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn"><span>＋</span>Create Unit</button>
                </form>
            </section>

            <section class="card">
                <h2>Lesson</h2>
                <p>Create a lesson inside a unit. Content details are managed via APIs later.</p>
                <form method="POST" action="{{ route('admin.lessons.store') }}">
                    @csrf
                    <div class="field">
                        <label for="lesson_id">ID (e.g. lesson-1)</label>
                        <input id="lesson_id" name="id" required>
                    </div>
                    <div class="field">
                        <label for="lesson_unit_id">Unit</label>
                        <select id="lesson_unit_id" name="unit_id" required>
                            <option value="">Select unit…</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->id }} — {{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="lesson_title">Title (Arabic)</label>
                        <input id="lesson_title" name="title" required>
                    </div>
                    <div class="field">
                        <label for="lesson_title_en">Title (English)</label>
                        <input id="lesson_title_en" name="title_en" required>
                    </div>
                    <div class="field">
                        <label for="lesson_duration">Duration (e.g. 15 دقيقة)</label>
                        <input id="lesson_duration" name="duration">
                    </div>
                    <div class="field">
                        <label for="lesson_type">Type</label>
                        <select id="lesson_type" name="type" required>
                            <option value="video">Video</option>
                            <option value="interactive">Interactive</option>
                            <option value="quiz">Quiz</option>
                        </select>
                    </div>
                    <button type="submit" class="btn"><span>＋</span>Create Lesson</button>
                </form>
            </section>
        </div>
    </main>
</div>
</body>
</html>

