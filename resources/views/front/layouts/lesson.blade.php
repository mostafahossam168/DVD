<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'فاهم — الدرس' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/fahm.css') }}">
</head>
<body class="lesson-page">

<nav class="lesson-navbar">
    <a href="{{ route('front.home') }}" class="lesson-nav-logo">
        <div class="lesson-nav-logo-mark">ف</div>
        <span class="lesson-nav-logo-text">فاهم</span>
    </a>
    <ul class="lesson-nav-links">
        <li><a href="{{ route('front.home') }}">الرئيسية</a></li>
        <li><a href="{{ route('front.courses.index') }}">الكورسات</a></li>
        <li><a href="{{ route('front.contact') }}">تواصل معنا</a></li>
    </ul>
    @if(isset($subject))
    <a href="{{ route('front.courses.subject', $subject) }}" class="nav-back">← الرجوع للكورس</a>
    @endif
    @auth
    <div class="lesson-user-wrap" style="margin-right: auto;">
        <button type="button" class="lesson-user-btn" id="lessonUserBtn" onclick="lessonToggleDropdown()">
            <div class="lesson-user-avatar">{{ mb_substr(auth()->user()->full_name ?? auth()->user()->f_name ?? 'م', 0, 1) }}</div>
            <span style="max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ auth()->user()->full_name ?? auth()->user()->f_name ?? 'حسابي' }}</span>
            <span style="font-size:0.6rem;transition:transform 0.2s">▼</span>
        </button>
        <div class="lesson-dropdown" id="lessonDropdown">
            <div class="lesson-dropdown-header">
                <div style="font-weight:800;font-size:0.88rem;color:var(--dark);">{{ auth()->user()->full_name ?? auth()->user()->f_name }}</div>
                <div style="font-size:0.73rem;color:var(--muted);">{{ auth()->user()->email }}</div>
            </div>
            <a href="{{ route('front.profile.show') }}" class="lesson-dropdown-item"><div class="lesson-dropdown-icon" style="background:#EFF6FF">👤</div>الملف الشخصي</a>
            <a href="{{ route('front.courses.my') }}" class="lesson-dropdown-item"><div class="lesson-dropdown-icon" style="background:#F0FDF4">🎓</div>دوراتي</a>
            <a href="{{ route('front.quizzes.history') }}" class="lesson-dropdown-item"><div class="lesson-dropdown-icon" style="background:#FFFBEB">📝</div>اختباراتي</a>
            <a href="{{ route('front.favorites.index') }}" class="lesson-dropdown-item"><div class="lesson-dropdown-icon" style="background:#FDF4FF">❤️</div>المفضلة</a>
            <div class="lesson-dropdown-divider"></div>
            <form method="POST" action="{{ route('front.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="lesson-dropdown-item danger" style="width:100%"><div class="lesson-dropdown-icon" style="background:#FEF2F2">🚪</div>تسجيل الخروج</button>
            </form>
        </div>
    </div>
    @endauth
</nav>

@yield('content')

<script>
function lessonToggleDropdown(){
  document.getElementById('lessonUserBtn').classList.toggle('open');
  document.getElementById('lessonDropdown').classList.toggle('show');
}
document.addEventListener('click', function(e){
  var wrap = document.querySelector('.lesson-user-wrap');
  if(wrap && !wrap.contains(e.target)){
    document.getElementById('lessonUserBtn').classList.remove('open');
    document.getElementById('lessonDropdown').classList.remove('show');
  }
});
</script>
@stack('scripts')
</body>
</html>
