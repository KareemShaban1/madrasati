@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ar';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', __('admin.app_name')) - EduCore Egypt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --bg-card: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: rgba(15, 23, 42, 0.12);
            --sidebar-bg: #f8fafc;
            --sidebar-brand: linear-gradient(135deg, #eab308 0%, #f59e0b 50%, #ea580c 100%);
            --nav-hover: #e2e8f0;
            --nav-active: rgba(234, 179, 8, 0.15);
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --badge-bg: #e2e8f0;
            --alert-bg: rgba(22, 163, 74, 0.12);
            --alert-border: rgba(34, 197, 94, 0.4);
            --alert-text: #166534;
            --btn-primary: linear-gradient(135deg, #eab308 0%, #f59e0b 50%, #ea580c 100%);
            --btn-secondary-bg: #f1f5f9;
            --btn-secondary-border: #94a3b8;
            --btn-danger: #991b1b;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.08), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-card: 0 1px 3px rgba(0,0,0,0.06);
        }
        [data-theme="dark"] {
            --bg: #0f172a;
            --bg-card: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: rgba(148, 163, 184, 0.2);
            --sidebar-bg: #0f172a;
            --nav-hover: #1e293b;
            --nav-active: rgba(234, 179, 8, 0.12);
            --input-bg: #0f172a;
            --input-border: #334155;
            --badge-bg: #1e293b;
            --alert-bg: rgba(22, 163, 74, 0.15);
            --alert-border: rgba(34, 197, 94, 0.4);
            --alert-text: #bbf7d0;
            --btn-secondary-bg: #1e293b;
            --btn-secondary-border: rgba(148, 163, 184, 0.3);
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.3), 0 2px 4px -2px rgba(0,0,0,0.2);
            --shadow-card: 0 1px 3px rgba(0,0,0,0.2);
        }
        body { font-family: 'Cairo', system-ui, -apple-system, sans-serif; background: var(--bg); color: var(--text); margin: 0; transition: background 0.25s, color 0.25s; }
        a { color: inherit; text-decoration: none; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; min-width: 260px; background: var(--sidebar-bg); border-inline-end: 1px solid var(--border); padding: 1.5rem 1.25rem; }
        .sidebar-brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
        .sidebar-brand-icon { width: 40px; height: 40px; border-radius: 0.75rem; background: var(--sidebar-brand); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
        .sidebar h1 { font-size: 1.15rem; font-weight: 700; margin: 0; }
        .sidebar span { display: block; font-size: 0.75rem; color: var(--text-muted); margin-top: 0.15rem; }
        .nav-section { font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin: 1rem 0 0.5rem; letter-spacing: 0.06em; }
        .nav-link { display: block; padding: 0.5rem 0.65rem; border-radius: 0.5rem; font-size: 0.9rem; color: var(--text-muted); transition: all 0.2s; margin-bottom: 0.15rem; }
        .nav-link:hover { background: var(--nav-hover); color: var(--text); }
        .nav-link.active { background: var(--nav-active); color: var(--text); font-weight: 600; }
        .main { flex: 1; padding: 1.5rem 2rem 2.5rem; min-width: 0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
        .topbar-title { font-size: 1.35rem; font-weight: 700; }
        .topbar-sub { font-size: 0.85rem; color: var(--text-muted); margin-top: 0.2rem; }
        .topbar-actions { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
        .theme-toggle, .lang-link { background: var(--btn-secondary-bg); border: 1px solid var(--border); color: var(--text); border-radius: 0.5rem; padding: 0.4rem 0.85rem; font-size: 0.8rem; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .theme-toggle:hover, .lang-link:hover { background: var(--nav-hover); }
        .lang-link.active { background: var(--btn-primary); color: white; border-color: transparent; }
        .logout form { display: inline; }
        .logout button { background: transparent; border: 1px solid var(--border); color: var(--text-muted); border-radius: 0.5rem; padding: 0.4rem 0.9rem; font-size: 0.8rem; cursor: pointer; transition: all 0.2s; }
        .logout button:hover { border-color: #ea580c; color: #fed7aa; }
        .content-card { background: var(--bg-card); border-radius: 1rem; padding: 1.25rem 1.5rem; border: 1px solid var(--border); box-shadow: var(--shadow-card); transition: box-shadow 0.2s; }
        .alert { margin-bottom: 1rem; font-size: 0.85rem; padding: 0.65rem 1rem; border-radius: 0.75rem; border: 1px solid var(--alert-border); background: var(--alert-bg); color: var(--alert-text); }
        .table { width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-top: 0.75rem; }
        .table th, .table td { padding: 0.6rem 0.75rem; border-bottom: 1px solid var(--border); text-align: start; }
        .table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 600; }
        .table tbody tr:hover { background: var(--nav-hover); }
        .badge-pill { display: inline-flex; align-items: center; padding: 0.2rem 0.55rem; border-radius: 9999px; background: var(--badge-bg); font-size: 0.75rem; color: var(--text-muted); font-weight: 500; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.45rem 0.9rem; border-radius: 0.5rem; border: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; background: var(--btn-primary); color: white; transition: transform 0.15s, box-shadow 0.2s; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234, 179, 8, 0.35); }
        .btn:active { transform: translateY(0); }
        .btn-secondary { background: var(--btn-secondary-bg); border: 1px solid var(--border); color: var(--text); }
        .btn-secondary:hover { box-shadow: none; background: var(--nav-hover); }
        .btn-danger { background: var(--btn-danger); color: white; }
        .btn-danger:hover { box-shadow: 0 4px 12px rgba(153, 27, 27, 0.4); }
        .field { margin-bottom: 0.55rem; }
        label { display: block; font-size: 0.78rem; margin-bottom: 0.2rem; color: var(--text); }
        input, select, textarea { width: 100%; padding: 0.5rem 0.65rem; border-radius: 0.5rem; border: 1px solid var(--input-border); background: var(--input-bg); color: var(--text); font-size: 0.85rem; transition: border-color 0.2s, box-shadow 0.2s; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #eab308; box-shadow: 0 0 0 2px rgba(234, 179, 8, 0.25); }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.6rem; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem; }
        .page-title { font-size: 1rem; font-weight: 600; }
        .page-desc { font-size: 0.8rem; color: var(--text-muted); }
        .filters { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 0.6rem; margin-bottom: 1rem; padding: 1rem; background: var(--nav-hover); border-radius: 0.75rem; border: 1px solid var(--border); }
        .filters .filter-group { display: flex; flex-direction: column; gap: 0.25rem; }
        .filters .filter-group label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin: 0; }
        .filters .filter-group select, .filters .filter-group input { min-width: 140px; padding: 0.4rem 0.6rem; font-size: 0.82rem; }
        .filters .btn { padding: 0.4rem 0.75rem; font-size: 0.82rem; }
        .pagination { display: flex; flex-wrap: wrap; gap: 0.25rem; align-items: center; margin-top: 1rem; font-size: 0.8rem; }
        .pagination a, .pagination span { padding: 0.35rem 0.6rem; border-radius: 0.5rem; border: 1px solid var(--border); background: var(--bg-card); color: var(--text); text-decoration: none; }
        .pagination a:hover { background: var(--nav-hover); }
        @media (max-width: 768px) { .layout { flex-direction: column; } .sidebar { width: 100%; min-width: 100%; border-inline-end: none; border-bottom: 1px solid var(--border); } }
        .pagination .current { background: var(--btn-primary); color: white; border-color: transparent; }
        .pagination .disabled { opacity: 0.5; pointer-events: none; }
        [dir="rtl"] .table th, [dir="rtl"] .table td { text-align: right; }
        [dir="rtl"] .topbar-actions { flex-direction: row-reverse; }
        [dir="rtl"] .page-header { flex-direction: row-reverse; }
        [dir="rtl"] .pagination { flex-direction: row-reverse; }
        .json-field-wrap { margin-bottom: 1rem; }
        .json-field-wrap .json-actions { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; }
        .json-field-wrap .btn-json-format { padding: 0.25rem 0.5rem; font-size: 0.72rem; background: var(--btn-secondary-bg); border: 1px solid var(--border); border-radius: 0.5rem; color: var(--text); cursor: pointer; }
        .json-field-wrap .btn-json-format:hover { background: var(--nav-hover); }
        .json-field-wrap .json-status { font-size: 0.72rem; color: var(--text-muted); }
        .json-field-wrap .json-status.valid { color: #16a34a; }
        .json-field-wrap .json-status.invalid { color: #dc2626; }
        .json-field-wrap .json-hint { font-size: 0.72rem; color: var(--text-muted); margin-bottom: 0.2rem; }
        textarea.json-input { font-family: ui-monospace, "Cascadia Code", "Source Code Pro", Menlo, monospace; font-size: 0.78rem; line-height: 1.4; min-height: 8rem; }
        .json-field-wrap .json-error { font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; }
        .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: 1rem; }
        .modal-box { background: var(--bg-card); border: 1px solid var(--border); border-radius: 1rem; max-width: 90vw; max-height: 85vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: var(--shadow); }
        .modal-box .modal-header { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        .modal-box .modal-body { padding: 1rem; overflow: auto; }
        .modal-box pre { margin: 0; font-size: 0.78rem; font-family: ui-monospace, monospace; white-space: pre-wrap; word-break: break-word; color: var(--text); }
        .questions-section { margin: 1.25rem 0; }
        .questions-section-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; }
        .questions-section-title { margin: 0; font-size: 0.95rem; font-weight: 600; }
        .questions-list, .sections-list { display: flex; flex-direction: column; gap: 1rem; }
        .question-row { padding: 1rem; border: 1px solid var(--border); border-radius: 0.75rem; background: var(--bg); }
        .question-row-head { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem; }
        .question-row-head .question-type-select { width: auto; min-width: 140px; }
        .question-options-wrap { margin: 0.5rem 0; }
        .options-list { display: flex; flex-direction: column; gap: 0.35rem; }
        .option-item { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
        .option-item input[type="text"] { flex: 1; min-width: 120px; }
        .option-item .option-correct { display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; }
        .interactive-items-list { display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.25rem; }
        .interactive-item-row { display: grid; grid-template-columns: 1fr 1fr auto auto; gap: 0.35rem; align-items: center; padding: 0.4rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--bg); }
        .interactive-item-row input { margin: 0; }
        @media (max-width: 640px) { .interactive-item-row { grid-template-columns: 1fr 1fr; } .interactive-item-row .btn-remove-interactive-item { grid-column: span 2; } }
    </style>
</head>
<body data-theme="{{ session('admin_theme', 'dark') }}">
<div class="layout">
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand" style="text-decoration:none;color:inherit;">
            <div class="sidebar-brand-icon">📚</div>
            <div>
                <h1>{{ __('admin.app_name') }}</h1>
                <span>{{ __('admin.subtitle') }}</span>
            </div>
        </a>
        <div class="nav-section">{{ __('admin.nav_section') }}</div>
        <a href="{{ route('admin.stages.index') }}" class="nav-link {{ request()->routeIs('admin.stages.*') ? 'active' : '' }}">{{ __('admin.stages') }}</a>
        <a href="{{ route('admin.grades.index') }}" class="nav-link {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}">{{ __('admin.grades') }}</a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">{{ __('admin.subjects') }}</a>
        <a href="{{ route('admin.units.index') }}" class="nav-link {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">{{ __('admin.units') }}</a>
        <a href="{{ route('admin.lessons.index') }}" class="nav-link {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}">{{ __('admin.lessons') }}</a>
        <a href="{{ route('admin.lesson-contents.index') }}" class="nav-link {{ request()->routeIs('admin.lesson-contents.*') ? 'active' : '' }}">{{ __('admin.lesson_content') }}</a>
        <a href="{{ route('admin.badges.index') }}" class="nav-link {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">{{ __('admin.badges') }}</a>
        <a href="{{ route('admin.achievements.index') }}" class="nav-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">{{ __('admin.achievements') }}</a>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('heading', __('admin.app_name'))</div>
                <div class="topbar-sub">@yield('subheading', __('admin.manage_curriculum'))</div>
            </div>
            <div class="topbar-actions">
                <button type="button" class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">{{ session('admin_theme', 'dark') === 'light' ? __('admin.dark') : __('admin.light') }}</button>
                <a href="{{ route('admin.locale', 'en') }}" class="lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('admin.locale', 'ar') }}" class="lang-link {{ app()->getLocale() === 'ar' ? 'active' : '' }}">ع</a>
                <div class="logout">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">{{ __('admin.sign_out') }}</button>
                    </form>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        <div class="content-card">
            @yield('content')
        </div>
    </main>
</div>
<script>
(function() {
    const toggle = document.getElementById('theme-toggle');
    const body = document.body;
    const themeKey = 'admin_theme';
    function getTheme() { return body.getAttribute('data-theme') || 'dark'; }
    function setTheme(theme) {
        body.setAttribute('data-theme', theme);
        try { localStorage.setItem(themeKey, theme); } catch (e) {}
        toggle.textContent = theme === 'light' ? (toggle.dataset.darkLabel || 'Dark') : (toggle.dataset.lightLabel || 'Light');
    }
    toggle.dataset.darkLabel = '{{ __("admin.dark") }}';
    toggle.dataset.lightLabel = '{{ __("admin.light") }}';
    try {
        const saved = localStorage.getItem(themeKey);
        if (saved && (saved === 'light' || saved === 'dark')) setTheme(saved);
    } catch (e) {}
    toggle.addEventListener('click', function() {
        const next = getTheme() === 'light' ? 'dark' : 'light';
        setTheme(next);
        fetch('{{ route("admin.theme") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ theme: next }) }).catch(function() {});
    });
})();
</script>
@stack('scripts')
</body>
</html>
