<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاهم — تسجيل الدخول | لوحة التحكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    :root{
      --blue:#1a56db;--blue-dark:#0d1b4b;--blue-mid:#1344b4;
      --blue-light:#3b72f0;--blue-glow:rgba(26,86,219,.22);
      --gold:#f5a623;--gold-light:#fde68a;
      --text:#0d1b4b;--muted:#6b7bb0;--border:#dde3f5;
      --bg:#f0f4ff;--white:#fff;
      --sh:0 8px 32px rgba(26,86,219,.1);--sh2:0 20px 60px rgba(26,86,219,.18);
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html,body{height:100%;font-family:'Cairo',sans-serif;overflow-x:hidden}

    .wrapper{display:flex;min-height:100vh;flex-wrap:wrap}

    .left-panel{
      flex:0 0 52%;min-height:100vh;position:relative;overflow:hidden;
      background:var(--blue-dark)}
    .left-panel .bg-img{
      position:absolute;inset:0;
      background:url('https://images.unsplash.com/photo-1531545514256-b1400bc00f31?w=1200&q=80') center/cover no-repeat;
      opacity:.25}
    .left-panel .geo{position:absolute;border-radius:50%;pointer-events:none}
    .geo-1{width:500px;height:500px;top:-150px;right:-150px;
      background:radial-gradient(circle,rgba(26,86,219,.35) 0%,transparent 70%)}
    .geo-2{width:400px;height:400px;bottom:-100px;left:-100px;
      background:radial-gradient(circle,rgba(245,166,35,.15) 0%,transparent 70%)}
    .geo-3{width:200px;height:200px;top:40%;left:30%;
      background:radial-gradient(circle,rgba(59,114,240,.2) 0%,transparent 70%)}
    .left-panel .grid-pattern{
      position:absolute;inset:0;
      background-image:
        linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);
      background-size:40px 40px}

    .left-content{
      position:relative;z-index:1;height:100%;min-height:100vh;
      display:flex;flex-direction:column;padding:3rem 3.5rem}
    .left-logo{display:flex;align-items:center;gap:14px}
    .left-logo .logo-box{
      width:48px;height:48px;border-radius:14px;
      background:rgba(255,255,255,.15);backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,.2);
      display:flex;align-items:center;justify-content:center;
      color:#fff;font-size:1.2rem;font-weight:900}
    .left-logo .logo-name{font-size:1.3rem;font-weight:900;color:#fff;line-height:1.1}
    .left-logo .logo-sub{font-size:.72rem;color:rgba(255,255,255,.55);font-weight:600;letter-spacing:.02em}
    .left-hero{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:1rem}
    .hero-badge{
      display:inline-flex;align-items:center;gap:8px;
      background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);
      backdrop-filter:blur(10px);color:rgba(255,255,255,.85);
      font-size:.78rem;font-weight:700;padding:7px 18px;border-radius:30px;margin-bottom:.5rem}
    .hero-badge .dot{width:7px;height:7px;border-radius:50%;background:var(--gold);animation:dpulse 2s infinite}
    .hero-title{font-size:clamp(2rem,4vw,3.2rem);font-weight:900;color:#fff;line-height:1.15;text-shadow:0 4px 20px rgba(0,0,0,.3)}
    .hero-title span{color:var(--gold)}
    .hero-desc{font-size:1rem;color:rgba(255,255,255,.7);line-height:1.7;max-width:380px;font-weight:500}
    .left-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
    .lstat{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
      border-radius:16px;padding:1rem;text-align:center;backdrop-filter:blur(10px);transition:all .3s}
    .lstat:hover{background:rgba(255,255,255,.12)}
    .lstat .n{font-size:1.6rem;font-weight:900;color:var(--gold)}
    .lstat .l{font-size:.72rem;color:rgba(255,255,255,.6);font-weight:600;margin-top:2px}

    .right-panel{
      flex:1;min-width:320px;background:var(--bg);
      display:flex;flex-direction:column;align-items:center;justify-content:center;
      padding:1.5rem 2rem;overflow-y:auto;position:relative}
    .panel-tag{
      position:absolute;top:1.8rem;left:1.8rem;
      display:flex;align-items:center;gap:6px;
      background:#fff;border:1.5px solid var(--border);
      border-radius:20px;padding:5px 14px;font-size:.75rem;font-weight:700;color:var(--muted)}
    .panel-tag .tag-dot{width:7px;height:7px;border-radius:50%;background:#16a34a;animation:dpulse 2s infinite}

    .role-switch{
      display:flex;gap:0;background:#fff;border:1.5px solid var(--border);
      border-radius:14px;padding:4px;margin-bottom:1.2rem;width:100%;max-width:380px;box-shadow:var(--sh)}
    .role-btn{
      flex:1;padding:10px 16px;border-radius:10px;border:none;
      font-family:'Cairo',sans-serif;font-size:.88rem;font-weight:700;
      cursor:pointer;transition:all .3s;color:var(--muted);background:transparent;
      display:flex;align-items:center;justify-content:center;gap:7px}
    .role-btn.active{
      background:linear-gradient(135deg,var(--blue),var(--blue-light));
      color:#fff;box-shadow:0 4px 14px var(--blue-glow)}

    .login-card{
      background:#fff;border-radius:24px;padding:1.8rem 2rem;
      border:1.5px solid var(--border);box-shadow:var(--sh2);
      width:100%;max-width:420px;position:relative;overflow:hidden}
    .login-card::before{
      content:'';position:absolute;top:0;right:0;left:0;height:5px;
      background:linear-gradient(90deg,var(--blue) 0%,var(--blue-light) 50%,var(--gold) 100%)}
    .card-head{text-align:center;margin-bottom:1.2rem}
    .card-avatar{
      width:52px;height:52px;border-radius:16px;margin:0 auto .8rem;
      background:linear-gradient(135deg,var(--blue),var(--blue-light));
      display:flex;align-items:center;justify-content:center;font-size:1.5rem;
      box-shadow:0 6px 18px var(--blue-glow)}
    .card-avatar.teacher{background:linear-gradient(135deg,#7c3aed,#a78bfa);box-shadow:0 8px 24px rgba(124,58,237,.25)}
    .card-head h2{font-size:1.4rem;font-weight:900;color:var(--text);margin-bottom:.25rem}
    .card-head p{font-size:.82rem;color:var(--muted);font-weight:500;line-height:1.5}
    .role-label{display:inline-flex;align-items:center;gap:6px;margin-top:.6rem;
      font-size:.78rem;font-weight:700;padding:4px 14px;border-radius:20px}
    .role-label.admin{background:#eff6ff;color:var(--blue)}
    .role-label.teacher{background:#f5f3ff;color:#7c3aed}

    .field{margin-bottom:.9rem}
    .field label{display:flex;align-items:center;justify-content:space-between;
      font-size:.83rem;font-weight:700;color:var(--text);margin-bottom:7px}
    .field label a{font-size:.78rem;font-weight:600;color:var(--gold);text-decoration:none;transition:opacity .2s}
    .field label a:hover{opacity:.7}
    .input-wrap{position:relative;display:flex;align-items:center}
    .input-wrap input{
      width:100%;padding:11px 44px 11px 44px;
      border:1.5px solid var(--border);border-radius:13px;
      background:#f7f9ff;font-family:'Cairo',sans-serif;
      font-size:.9rem;color:var(--text);outline:none;transition:all .3s;direction:rtl}
    .input-wrap input::placeholder{color:#b0b8d8}
    .input-wrap input:focus{border-color:var(--blue);background:#fff;box-shadow:0 0 0 4px var(--blue-glow)}
    .input-wrap .i-right{position:absolute;right:14px;color:var(--muted);pointer-events:none;display:flex}
    .input-wrap .i-left{position:absolute;left:14px;color:var(--muted);cursor:pointer;display:flex;background:none;border:none;transition:color .2s;padding:0}
    .input-wrap .i-left:hover{color:var(--blue)}
    .field .err{font-size:.78rem;color:#dc2626;margin-top:4px;font-weight:600}

    .remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
    .checkbox-wrap{display:flex;align-items:center;gap:8px;cursor:pointer}
    .checkbox-wrap input[type="checkbox"]{width:18px;height:18px;accent-color:var(--blue);cursor:pointer;border-radius:5px}
    .checkbox-wrap span{font-size:.83rem;font-weight:600;color:var(--muted)}

    .btn-login{
      width:100%;padding:12px;border-radius:12px;border:none;
      background:linear-gradient(135deg,var(--blue) 0%,var(--blue-light) 100%);
      color:#fff;font-family:'Cairo',sans-serif;font-size:.95rem;font-weight:800;
      cursor:pointer;transition:all .3s;box-shadow:0 6px 24px var(--blue-glow);
      display:flex;align-items:center;justify-content:center;gap:7px;
      position:relative;overflow:hidden}
    .btn-login::after{content:'';position:absolute;inset:0;
      background:linear-gradient(135deg,transparent 40%,rgba(255,255,255,.12) 100%)}
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(26,86,219,.3)}
    .btn-login:active{transform:translateY(0)}
    .btn-login.teacher-btn{
      background:linear-gradient(135deg,#7c3aed 0%,#a78bfa 100%);
      box-shadow:0 6px 24px rgba(124,58,237,.28)}
    .btn-login.teacher-btn:hover{box-shadow:0 12px 32px rgba(124,58,237,.35)}
    .btn-login:disabled{opacity:.8;cursor:not-allowed;transform:none}

    .security-note{
      display:flex;align-items:center;justify-content:center;gap:7px;
      margin-top:1rem;font-size:.72rem;color:var(--muted);font-weight:600}
    .security-note svg{color:#16a34a}

    .toast{
      position:fixed;top:1.5rem;left:50%;transform:translateX(-50%) translateY(-80px);
      background:#fff;border:1.5px solid #bbf7d0;border-radius:16px;
      padding:12px 20px;display:flex;align-items:center;gap:10px;
      box-shadow:0 8px 30px rgba(0,0,0,.1);z-index:500;
      font-size:.88rem;font-weight:700;color:#16a34a;
      transition:transform .4s cubic-bezier(.22,1,.36,1);min-width:280px}
    .toast.show{transform:translateX(-50%) translateY(0)}
    .toast.error{border-color:#fecaca;color:#dc2626}

    @keyframes dpulse{0%,100%{opacity:1}50%{opacity:.4}}
    @keyframes dfadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .anim{animation:dfadeUp .55s cubic-bezier(.22,1,.36,1) both}
    .d1{animation-delay:.1s}.d2{animation-delay:.18s}.d3{animation-delay:.26s}

    @media (max-width: 992px) {
      .left-panel{flex:0 0 100%;min-height:40vh}
      .left-content{min-height:40vh;padding:2rem}
      .left-hero{margin:1rem 0}
      .left-stats{grid-template-columns:repeat(3,1fr);gap:.75rem}
      .lstat .n{font-size:1.3rem}
      .right-panel{padding:2rem 1.5rem;min-height:60vh}
    }
    @media (max-width: 560px) {
      .hero-title{font-size:1.75rem}
      .role-switch{flex-direction:column}
      .login-card{padding:1.5rem 1.25rem}
    }
    </style>
</head>
<body>

@if(session('success'))
<div class="toast show" id="toast">
    <span>✅</span>
    <span id="toast-msg">{{ session('success') }}</span>
    <button type="button" class="t-close" style="margin-right:auto;cursor:pointer;background:none;border:none;font-size:1.1rem;color:var(--muted)" onclick="document.getElementById('toast').classList.remove('show')">×</button>
</div>
@endif
@if(session('error'))
<div class="toast error show" id="toast">
    <span>⚠️</span>
    <span id="toast-msg">{{ session('error') }}</span>
    <button type="button" class="t-close" style="margin-right:auto;cursor:pointer;background:none;border:none;font-size:1.1rem;color:var(--muted)" onclick="document.getElementById('toast').classList.remove('show')">×</button>
</div>
@endif

<div class="wrapper">
    <div class="left-panel">
        <div class="bg-img"></div>
        <div class="grid-pattern"></div>
        <div class="geo geo-1"></div>
        <div class="geo geo-2"></div>
        <div class="geo geo-3"></div>
        <div class="left-content">
            <div class="left-logo anim">
                <div class="logo-box">ف</div>
                <div class="logo-info">
                    <div class="logo-name">فاهم</div>
                    <div class="logo-sub">لوحة التحكم</div>
                </div>
            </div>
            <div class="left-hero">
                <div class="hero-badge anim d1">
                    <div class="dot"></div>
                    النظام يعمل بكفاءة كاملة
                </div>
                <h1 class="hero-title anim d2">منصة<br><span>فاهم</span></h1>
                <p class="hero-desc anim d2">
                    بيئة إدارية متكاملة لإدارة المحتوى التعليمي، المعلمين، والطلاب بكل سهولة واحترافية.
                </p>
            </div>
            <div class="left-stats anim d3">
                <div class="lstat"><div class="n">50K+</div><div class="l">طالب مسجل</div></div>
                <div class="lstat"><div class="n">+1200</div><div class="l">كورس متاح</div></div>
                <div class="lstat"><div class="n">4.9★</div><div class="l">تقييم المنصة</div></div>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="panel-tag">
            <div class="tag-dot"></div>
            نظام آمن ومشفّر
        </div>

        <div class="role-switch anim" id="roleSwitcher">
            <button type="button" class="role-btn active" id="btnAdmin" onclick="switchRole('admin')">🛡️ مدير النظام</button>
            <button type="button" class="role-btn" id="btnTeacher" onclick="switchRole('teacher')">🎓 مدرّس</button>
        </div>

        <form action="{{ route('dashboard.login-submit') }}" method="POST" class="login-card anim d1" id="loginForm">
            @csrf
            <div class="card-head">
                <div class="card-avatar" id="cardAvatar">🛡️</div>
                <h2 id="cardTitle">مرحباً بك</h2>
                <p id="cardDesc">أدخل بياناتك للوصول إلى لوحة التحكم</p>
                <div class="role-label admin" id="roleLabel">مدير النظام — Admin</div>
            </div>

            <div class="field">
                <label>البريد الإلكتروني</label>
                <div class="input-wrap">
                    <input type="email" name="email" id="emailInput" placeholder="admin@fahim.com" value="{{ old('email') }}" required autocomplete="email">
                    <span class="i-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </span>
                </div>
                @error('email')<div class="err">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>
                    كلمة المرور
                    <a href="#">نسيت كلمة المرور؟</a>
                </label>
                <div class="input-wrap">
                    <input type="password" name="password" id="passInput" placeholder="أدخل كلمة المرور" required autocomplete="current-password">
                    <span class="i-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <button type="button" class="i-left" id="eyeBtn" onclick="togglePass()" aria-label="إظهار كلمة المرور">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')<div class="err">{{ $message }}</div>@enderror
            </div>

            <div class="remember-row">
                <label class="checkbox-wrap">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span>تذكّرني دائماً</span>
                </label>
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <span>دخول</span>
            </button>

            <div class="security-note">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                الاتصال مشفّر — بياناتك آمنة
            </div>
        </form>
    </div>
</div>

<script>
var currentRole = 'admin';
var passVisible = false;

function switchRole(role) {
    currentRole = role;
    var isAdmin = role === 'admin';
    document.getElementById('btnAdmin').classList.toggle('active', isAdmin);
    document.getElementById('btnTeacher').classList.toggle('active', !isAdmin);
    document.getElementById('cardAvatar').textContent = isAdmin ? '🛡️' : '🎓';
    document.getElementById('cardAvatar').className = 'card-avatar' + (isAdmin ? '' : ' teacher');
    document.getElementById('cardTitle').textContent = isAdmin ? 'مرحباً بك' : 'مرحباً أيها المدرّس';
    document.getElementById('cardDesc').textContent = isAdmin ? 'أدخل بياناتك للوصول إلى لوحة التحكم' : 'أدخل بياناتك للوصول إلى منطقة المدرسين';
    document.getElementById('roleLabel').textContent = isAdmin ? 'مدير النظام — Admin' : 'مدرّس — Teacher';
    document.getElementById('roleLabel').className = 'role-label ' + (isAdmin ? 'admin' : 'teacher');
    document.getElementById('emailInput').placeholder = isAdmin ? 'admin@fahim.com' : 'teacher@fahim.com';
    var btn = document.getElementById('loginBtn');
    btn.className = 'btn-login' + (isAdmin ? '' : ' teacher-btn');
}

function togglePass() {
    passVisible = !passVisible;
    var inp = document.getElementById('passInput');
    inp.type = passVisible ? 'text' : 'password';
    var icon = document.getElementById('eyeIcon');
    if (passVisible) {
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
    }
}

document.getElementById('loginForm').addEventListener('submit', function() {
    var btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> جاري التحقق...';
});
</script>
<style>@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}</style>
</body>
</html>
