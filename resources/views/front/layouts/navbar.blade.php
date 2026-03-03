<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('front.home') }}">
            <img src="assets/logo.png" alt="Logo" class="logo-img">
        </a>

        <a class="navbar-brand fw-bold" href="#"></a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- ===== Left Links ===== -->
            <ul class="navbar-nav align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('front.home') }}">الرئيسية</a>
                </li>

                <!-- المراحل الدراسية -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        المراحل الدراسية
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($navbarStages ?? [] as $stage)
                            <li><a class="dropdown-item" href="{{ route('front.stages.show', $stage) }}">{{ $stage->name }}</a></li>
                        @endforeach
                        @if (($navbarStagesCount ?? 0) > 5)
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fw-bold" href="{{ route('front.stages.index') }}">عرض الكل</a></li>
                        @endif
                    </ul>
                </li>

                <!-- المواد -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        المواد
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($navbarSubjects ?? [] as $subject)
                            <li><a class="dropdown-item" href="{{ route('front.subjects.index') }}#subject-{{ $subject->id }}">{{ $subject->name }}</a></li>
                        @endforeach
                        @if (($navbarSubjectsCount ?? 0) > 5)
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fw-bold" href="{{ route('front.subjects.index') }}">عرض الكل</a></li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.courses.index') }}">الكورسات</a>
                </li>

                <ul class="navbar-nav">
                    <li class="nav-item" style="white-space: nowrap;">
                        <a class="nav-link" href="{{ route('front.contact') }}">تواصل معنا</a>
                    </li>
                </ul>


                <!-- ===== Right Actions ===== -->
                <div class="navbar-actions ms-auto">

                    <!-- Search -->
                    <div class="search-box">
                        <input type="text" placeholder="بحث">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </div>

                    @auth
                        @php
                            $student = auth()->user();
                        @endphp
                        <div class="dropdown ms-3">
                            <button class="btn-custom btn-login dropdown-toggle" type="button" id="studentMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $student->fullname ?? ($student->f_name ?? 'حسابي') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="studentMenuButton">
                                <li>
                                    <a class="dropdown-item" href="{{ route('front.profile.show') }}">الملف الشخصي</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('front.courses.my') }}">دوراتي المسجل فيها</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('front.quizzes.history') }}">اختباراتي</a>
                                </li>
                                @if ($student->type === 'student')
                                <li>
                                    <a class="dropdown-item" href="{{ route('front.favorites.index') }}">المفضلة</a>
                                </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('front.logout') }}" method="POST" class="px-3">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger p-0">
                                            تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Auth Buttons for guests -->
                        <a href="{{ route('front.login') }}" class="ms-2">
                            <button class="btn-custom btn-register">تسجيل الدخول</button>
                        </a>
                        <a href="{{ route('front.register') }}">
                            <button class="btn-custom btn-login"> انشاء حساب</button>
                        </a>
                    @endauth
                </div>

        </div>
    </div>
</nav>
