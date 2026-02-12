<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - EduCore Egypt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Cairo', system-ui, sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color:#f1f5f9; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; padding:1rem; }
        .card { background:#1e293b; border-radius:1.25rem; padding:2.5rem 2rem; width:100%; max-width:420px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5), 0 0 0 1px rgba(148,163,184,0.1); }
        .brand-icon { width:56px; height:56px; border-radius:1rem; background: linear-gradient(135deg, #eab308 0%, #f59e0b 50%, #ea580c 100%); display:flex; align-items:center; justify-content:center; font-size:1.75rem; margin-bottom:1.25rem; }
        .title { font-size:1.5rem; font-weight:700; margin-bottom:0.25rem; }
        .subtitle { font-size:0.9rem; color:#94a3b8; margin-bottom:1.75rem; line-height:1.5; }
        label { display:block; font-size:0.85rem; font-weight:500; margin-bottom:0.35rem; color:#e2e8f0; }
        input[type="email"], input[type="password"] { width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #334155; background:#0f172a; color:#f1f5f9; font-size:0.9rem; transition: border-color 0.2s, box-shadow 0.2s; }
        input:focus { outline:none; border-color:#eab308; box-shadow:0 0 0 2px rgba(234,179,8,0.25); }
        .field { margin-bottom:1.1rem; }
        .button { width:100%; padding:0.75rem 1rem; border-radius:0.5rem; border:none; background:linear-gradient(135deg, #eab308 0%, #f59e0b 50%, #ea580c 100%); color:white; font-weight:600; font-size:0.95rem; cursor:pointer; box-shadow:0 4px 14px rgba(234,179,8,0.35); transition: transform 0.15s, box-shadow 0.2s; }
        .button:hover { transform: translateY(-1px); box-shadow:0 6px 20px rgba(234,179,8,0.4); }
        .button:active { transform: translateY(0); }
        .error { background:rgba(248,113,113,0.12); border:1px solid rgba(248,113,113,0.35); color:#fecaca; padding:0.75rem 1rem; border-radius:0.75rem; font-size:0.85rem; margin-bottom:1rem; }
        .remember { display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#94a3b8; margin-bottom:1.5rem; }
        .remember input { width:16px; height:16px; accent-color: #eab308; }
        .brand { font-size:0.8rem; color:#64748b; margin-top:1.5rem; text-align:center; }
    </style>
</head>
<body>
<div class="card">
    <div class="brand-icon">📚</div>
    <div class="title">EduCore Admin</div>
    <div class="subtitle">Sign in with an administrator account to manage curriculum data.</div>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="button">Sign in</button>
    </form>

    <div class="brand">EduCore Egypt · Admin Console</div>
</div>
</body>
</html>

