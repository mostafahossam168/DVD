<nav class="nav-fahm">
    <button type="button" class="nav-hamburger" id="navHamburger" aria-label="القائمة" onclick="toggleNavMobile()">
        <span></span><span></span><span></span>
    </button>

    <a class="nav-logo" href="{{ route('front.home') }}">
        <div class="nav-logo-mark">ف</div>
        <span class="nav-logo-text">فاهم</span>
    </a>

    <ul class="nav-links">
        <li><a href="{{ route('front.home') }}"
                class="{{ request()->routeIs('front.home') ? 'active' : '' }}">الرئيسية</a></li>
        <li><a href="{{ route('front.courses.index') }}"
                class="{{ request()->routeIs('front.courses.index') ? 'active' : '' }}">الكورسات</a></li>
        <li class="nav-item dropdown d-inline-block">
            <a href="#" class="nav-links-a dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">المواد</a>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach ($navbarSubjects ?? [] as $sub)
                    <li><a class="dropdown-item"
                            href="{{ route('front.subjects.index') }}#subject-{{ $sub->id }}">{{ $sub->name }}</a>
                    </li>
                @endforeach
                @if (($navbarSubjectsCount ?? 0) > 5)
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item fw-bold" href="{{ route('front.subjects.index') }}">عرض الكل</a></li>
                @endif
            </ul>
        </li>
        <li class="nav-item dropdown d-inline-block">
            <a href="#" class="nav-links-a dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">المراحل الدراسية</a>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach ($navbarStages ?? [] as $stage)
                    <li><a class="dropdown-item"
                            href="{{ route('front.stages.show', $stage) }}">{{ $stage->name }}</a></li>
                @endforeach
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item view-all fw-bold" href="{{ route('front.stages.index') }}">عرض الكل</a>
                </li>
            </ul>
        </li>
        <li><a href="{{ route('front.page.about') }}"
                class="{{ request()->routeIs('front.page.about') ? 'active' : '' }}">من نحن</a></li>
        <li><a href="{{ route('front.contact') }}"
                class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">تواصل معنا</a></li>
    </ul>

    <div class="nav-search">
        <span class="nav-search-icon">🔍</span>
        <input type="text" placeholder="ابحث عن كورس أو مادة..." aria-label="بحث" />
    </div>

    <div class="nav-actions">
        @auth
            @php
                $student = auth()->user();
                $displayName = $student->fullname ?? ($student->f_name ?? 'حسابي');
                $displaySub = $student->email ?? ($student->phone ?? '');
                $initial = mb_substr($displayName, 0, 1);
            @endphp
            <div class="user-dropdown-wrap">
                <button class="user-btn" type="button" id="userBtn" onclick="toggleUserDropdown()" aria-expanded="false"
                    aria-haspopup="true">
                    <div class="user-avatar">{{ $initial }}</div>
                    <span class="user-name">{{ $displayName }}</span>
                    <span class="user-chevron">▼</span>
                </button>
                <div class="user-dropdown-menu" id="userDropdownMenu" role="menu">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name">{{ $displayName }}</div>
                        @if ($displaySub)
                            <div class="user-dropdown-email">{{ $displaySub }}</div>
                        @endif
                    </div>
                    <a href="{{ route('front.profile.show') }}" class="user-dropdown-item" role="menuitem">
                        <div class="user-dropdown-icon" style="background:#EFF6FF">👤</div>
                        الملف الشخصي
                    </a>
                    <a href="{{ route('front.courses.my') }}" class="user-dropdown-item" role="menuitem">
                        <div class="user-dropdown-icon" style="background:#F0FDF4">🎓</div>
                        دوراتي المسجل فيها
                    </a>
                    <a href="{{ route('front.quizzes.history') }}" class="user-dropdown-item" role="menuitem">
                        <div class="user-dropdown-icon" style="background:#FFFBEB">📝</div>
                        اختباراتي
                    </a>
                    @if ($student->type === 'student')
                        <a href="{{ route('front.favorites.index') }}" class="user-dropdown-item" role="menuitem">
                            <div class="user-dropdown-icon" style="background:#FDF4FF">❤️</div>
                            المفضلة
                        </a>
                    @endif
                    <div class="user-dropdown-divider"></div>
                    <form action="{{ route('front.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="user-dropdown-item danger w-100" role="menuitem">
                            <div class="user-dropdown-icon" style="background:#FEF2F2">🚪</div>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('front.login') }}"><button type="button" class="btn-ghost">تسجيل الدخول</button></a>
            <a href="{{ route('front.register') }}"><button type="button" class="btn-primary">إنشاء حساب</button></a>
        @endauth
    </div>

    <!-- قائمة الموبايل (تظهر عند فتح الهمبرجر) -->
    <div class="nav-mobile-overlay" id="navMobileOverlay" onclick="toggleNavMobile()"></div>
    <div class="nav-mobile-menu" id="navMobileMenu">
        <div class="nav-mobile-inner">
            <a href="{{ route('front.home') }}"
                class="nav-mobile-link {{ request()->routeIs('front.home') ? 'active' : '' }}">الرئيسية</a>
            <a href="{{ route('front.courses.index') }}"
                class="nav-mobile-link {{ request()->routeIs('front.courses.index') ? 'active' : '' }}">الكورسات</a>
            <a href="{{ route('front.subjects.index') }}" class="nav-mobile-link">المواد</a>
            <a href="{{ route('front.stages.index') }}" class="nav-mobile-link">المراحل الدراسية</a>
            <a href="{{ route('front.page.about') }}"
                class="nav-mobile-link {{ request()->routeIs('front.page.about') ? 'active' : '' }}">من نحن</a>
            <a href="{{ route('front.contact') }}"
                class="nav-mobile-link {{ request()->routeIs('front.contact') ? 'active' : '' }}">تواصل معنا</a>
            <div class="nav-mobile-search">
                <span class="nav-search-icon">🔍</span>
                <input type="text" placeholder="ابحث عن كورس أو مادة..." aria-label="بحث" />
            </div>
            @auth
                <a href="{{ route('front.profile.show') }}" class="nav-mobile-link">الملف الشخصي</a>
                <a href="{{ route('front.courses.my') }}" class="nav-mobile-link">دوراتي</a>
                <a href="{{ route('front.quizzes.history') }}" class="nav-mobile-link">اختباراتي</a>
                @if (auth()->user()->type === 'student')
                    <a href="{{ route('front.favorites.index') }}" class="nav-mobile-link">المفضلة</a>
                @endif
                <form action="{{ route('front.logout') }}" method="POST" class="nav-mobile-logout">
                    @csrf
                    <button type="submit" class="nav-mobile-link danger">تسجيل الخروج</button>
                </form>
            @else
                <div class="nav-mobile-actions">
                    <a href="{{ route('front.login') }}" class="nav-mobile-btn ghost">تسجيل الدخول</a>
                    <a href="{{ route('front.register') }}" class="nav-mobile-btn primary">إنشاء حساب</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleNavMobile() {
        var menu = document.getElementById('navMobileMenu');
        var overlay = document.getElementById('navMobileOverlay');
        var btn = document.getElementById('navHamburger');
        if (menu) menu.classList.toggle('open');
        if (overlay) overlay.classList.toggle('open');
        if (btn) btn.classList.toggle('open');
        document.body.classList.toggle('nav-mobile-open', menu && menu.classList.contains('open'));
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-mobile-menu .nav-mobile-link, .nav-mobile-menu .nav-mobile-btn')
            .forEach(function(el) {
                el.addEventListener('click', function() {
                    toggleNavMobile();
                });
            });
    });
</script>

<style>
    .fahm-wrap .nav-links-a {
        text-decoration: none;
        color: var(--muted);
        font-size: 0.88rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .fahm-wrap .nav-links-a:hover {
        color: var(--blue);
        background: var(--blue-light);
    }

    .fahm-wrap .nav-fahm .dropdown-menu {
        min-width: 180px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
</style>
@auth
    <script>
        (function() {
            function toggleUserDropdown() {
                var btn = document.getElementById('userBtn');
                var menu = document.getElementById('userDropdownMenu');
                if (!btn || !menu) return;
                btn.classList.toggle('open');
                menu.classList.toggle('show');
                btn.setAttribute('aria-expanded', menu.classList.contains('show'));
            }
            window.toggleUserDropdown = toggleUserDropdown;
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('click', function(e) {
                    var wrap = document.querySelector('.user-dropdown-wrap');
                    if (wrap && !wrap.contains(e.target)) {
                        var btn = document.getElementById('userBtn');
                        var menu = document.getElementById('userDropdownMenu');
                        if (btn) btn.classList.remove('open');
                        if (menu) menu.classList.remove('show');
                        if (btn) btn.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        })
        ();
    </script>
@endauth
