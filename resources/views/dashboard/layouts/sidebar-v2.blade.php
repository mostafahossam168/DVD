<aside class="sidebar-v2" id="dashboardSidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">ف</div>
        <div class="logo-text">فاهم</div>
        <div class="logo-badge">Admin</div>
    </div>

    <div class="sidebar-scroll">
        <div class="nav-section">
            <span class="nav-label">الرئيسية</span>
            <a href="{{ route('dashboard.home') }}" class="nav-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
                <div class="ni-icon"><i class="fa-solid fa-house"></i></div>
                <span class="ni-label">لوحة التحكم</span>
            </a>
        </div>

        @can('read_settings')
            @php
                $settingsActive = request()->routeIs('dashboard.settings') || request()->routeIs('dashboard.pages.*');
                $currentStaticPage = request()->route('page');
            @endphp
            <div class="nav-section">
                <span class="nav-label">الإعدادات</span>
                <a href="#" class="nav-item nav-item-toggle {{ $settingsActive ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#collapse-settings-v2" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                    <div class="ni-icon"><i class="fa-solid fa-gear"></i></div>
                    <span class="ni-label">الإعدادات</span>
                    <i class="fa-solid fa-angle-left ni-arrow ms-auto"></i>
                </a>
                <div id="collapse-settings-v2" class="collapse nav-collapse {{ $settingsActive ? 'show' : '' }}">
                    <a href="{{ route('dashboard.settings') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-sliders"></i></div>
                        <span class="ni-label">الإعدادات العامة</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'about') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'about' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">عن المنصة</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'vision') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'vision' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">رؤيتنا</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'team') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'team' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">فريق العمل</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'faq') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'faq' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">الأسئلة الشائعة</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'privacy') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'privacy' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">سياسة الخصوصية</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'terms') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'terms' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">الشروط والأحكام</span>
                    </a>
                    <a href="{{ route('dashboard.pages.edit', 'usage') }}" class="nav-item nav-item-sub {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'usage' ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-circle-dot"></i></div>
                        <span class="ni-label">سياسة الاستخدام</span>
                    </a>
                </div>
            </div>
        @endcan

        <div class="nav-section">
            <span class="nav-label">إدارة المستخدمين</span>
            @can('read_admins')
                <a href="{{ route('dashboard.admins.index') }}" class="nav-item {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-users"></i></div>
                    <span class="ni-label">المشرفين</span>
                    @php $adminsCount = \App\Models\User::admins()->count(); @endphp
                    @if($adminsCount > 0)<span class="ni-count">{{ $adminsCount }}</span>@endif
                </a>
            @endcan
            @can('read_teachers')
                <a href="{{ route('dashboard.teachers.index') }}" class="nav-item {{ request()->routeIs('dashboard.teachers.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                    <span class="ni-label">المعلمين</span>
                    @php $teachersCount = \App\Models\User::teachers()->count(); @endphp
                    @if($teachersCount > 0)<span class="ni-count">{{ $teachersCount }}</span>@endif
                </a>
            @endcan
            @can('read_students')
                <a href="{{ route('dashboard.students.index') }}" class="nav-item {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-user-tie"></i></div>
                    <span class="ni-label">الطلاب</span>
                    @php $studentsCount = \App\Models\User::students()->count(); @endphp
                    @if($studentsCount > 0)<span class="ni-count">{{ $studentsCount }}</span>@endif
                </a>
            @endcan
            @can('read_roles')
                <a href="{{ route('dashboard.roles.index') }}" class="nav-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-user-shield"></i></div>
                    <span class="ni-label">الصلاحيات</span>
                </a>
            @endcan
        </div>

        <div class="nav-section">
            <span class="nav-label">المحتوى التعليمي</span>
            @can('read_stages')
                <a href="{{ route('dashboard.stages.index') }}" class="nav-item {{ request()->routeIs('dashboard.stages.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <span class="ni-label">المراحل الدراسية</span>
                    @php $stagesCount = \App\Models\Stage::count(); @endphp
                    @if($stagesCount > 0)<span class="ni-count">{{ $stagesCount }}</span>@endif
                </a>
            @endcan
            @can('read_grades')
                <a href="{{ route('dashboard.grades.index') }}" class="nav-item {{ request()->routeIs('dashboard.grades.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <span class="ni-label">الصفوف الدراسية</span>
                </a>
            @endcan
            @can('read_subjects')
                <a href="{{ route('dashboard.subjects.index') }}" class="nav-item {{ request()->routeIs('dashboard.subjects.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-book"></i></div>
                    <span class="ni-label">المواد الدراسية</span>
                    @php $subjectsCount = \App\Models\Subject::count(); @endphp
                    @if($subjectsCount > 0)<span class="ni-count">{{ $subjectsCount }}</span>@endif
                </a>
            @endcan
            @can('read_lectuers')
                <a href="{{ route('dashboard.lectuers.index') }}" class="nav-item {{ request()->routeIs('dashboard.lectuers.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-video"></i></div>
                    <span class="ni-label">الدروس</span>
                    @php $lecturesCount = \App\Models\Lecture::count(); @endphp
                    @if($lecturesCount > 0)<span class="ni-count">{{ $lecturesCount }}</span>@endif
                </a>
            @endcan
            @can('read_lectuers')
                <a href="{{ route('dashboard.online-meetings.index') }}" class="nav-item {{ request()->routeIs('dashboard.online-meetings.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-desktop"></i></div>
                    <span class="ni-label">المحاضرات الأونلاين</span>
                </a>
            @endcan
            @can('read_materials')
                <a href="{{ route('dashboard.materials.index') }}" class="nav-item {{ request()->routeIs('dashboard.materials.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-file-pdf"></i></div>
                    <span class="ni-label">المواد التعليمية</span>
                </a>
            @endcan
            @can('read_plans')
                <a href="{{ route('dashboard.plans.index') }}" class="nav-item {{ request()->routeIs('dashboard.plans.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <span class="ni-label">الخطط</span>
                </a>
            @endcan
        </div>

        <div class="nav-section">
            <span class="nav-label">الاشتراكات والمدفوعات</span>
            @can('read_teacher_subscriptions')
                <a href="{{ route('dashboard.teacher-subscriptions.index') }}" class="nav-item {{ request()->routeIs('dashboard.teacher-subscriptions.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-user-check"></i></div>
                    <span class="ni-label">اشتراكات المدرسين</span>
                </a>
            @endcan
            @can('read_subscriptions')
                <a href="{{ route('dashboard.subscriptions.index') }}" class="nav-item {{ request()->routeIs('dashboard.subscriptions.index') && !request()->routeIs('dashboard.subscriptions-pending') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-user-graduate"></i></div>
                    <span class="ni-label">اشتراكات الطلاب</span>
                </a>
                @can('update_subscriptions')
                    <a href="{{ route('dashboard.subscriptions-pending') }}" class="nav-item {{ request()->routeIs('dashboard.subscriptions-pending') ? 'active' : '' }}">
                        <div class="ni-icon"><i class="fa-solid fa-clock"></i></div>
                        <span class="ni-label">طلبات معلّقة</span>
                        @php $pendingCount = \App\Models\Subscription::where('payment_status', 'pending')->count(); @endphp
                        @if($pendingCount > 0)<span class="ni-count new">{{ $pendingCount }}</span>@endif
                    </a>
                @endcan
            @endcan
            @can('read_payment_methods')
                <a href="{{ route('dashboard.payment-methods.index') }}" class="nav-item {{ request()->routeIs('dashboard.payment-methods.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <span class="ni-label">طرق الدفع</span>
                </a>
            @endcan
        </div>

        <div class="nav-section">
            <span class="nav-label">أخرى</span>
            @can('read_quiz_results')
                <a href="{{ route('dashboard.quiz-results.index') }}" class="nav-item {{ request()->routeIs('dashboard.quiz-results.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-list-check"></i></div>
                    <span class="ni-label">نتائج الاختبارات</span>
                </a>
            @endcan
            @can('read_course_reviews')
                <a href="{{ route('dashboard.course-reviews.index') }}" class="nav-item {{ request()->routeIs('dashboard.course-reviews.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-star"></i></div>
                    <span class="ni-label">تقييمات الكورسات</span>
                </a>
            @endcan
            @can('read_contacts')
                <a href="{{ route('dashboard.contacts.index') }}" class="nav-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-comments"></i></div>
                    <span class="ni-label">تواصل معنا</span>
                    @php $contactsCount = \App\Models\Contact::count(); @endphp
                    @if($contactsCount > 0)<span class="ni-count new">{{ $contactsCount }}</span>@endif
                </a>
            @endcan
            @can('read_coupons')
                <a href="{{ route('dashboard.coupons.index') }}" class="nav-item {{ request()->routeIs('dashboard.coupons.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-gift"></i></div>
                    <span class="ni-label">الكوبونات</span>
                </a>
            @endcan
            @can('read_quizes')
                <a href="{{ route('dashboard.quizes.index') }}" class="nav-item {{ request()->routeIs('dashboard.quizes.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-clipboard-question"></i></div>
                    <span class="ni-label">الاختبارات</span>
                </a>
            @endcan
            @can('read_questions')
                <a href="{{ route('dashboard.questions.index') }}" class="nav-item {{ request()->routeIs('dashboard.questions.*') ? 'active' : '' }}">
                    <div class="ni-icon"><i class="fa-solid fa-question-circle"></i></div>
                    <span class="ni-label">الأسئلة</span>
                </a>
            @endcan
        </div>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('dashboard.profile') }}" class="admin-card">
            <div class="admin-avatar">{{ mb_substr(auth()->user()->full_name ?? auth()->user()->f_name ?? 'أ', 0, 1) }}</div>
            <div class="admin-info">
                <div class="admin-name">{{ auth()->user()->full_name ?? auth()->user()->f_name ?? 'المشرف' }}</div>
                <div class="admin-role">{{ auth()->user()->getRoleNames()->first() ?: (auth()->user()->type === 'admin' ? 'Super Admin' : (auth()->user()->type === 'teacher' ? 'مدرّس' : 'مشرف')) }}</div>
            </div>
            <div class="admin-more">⋯</div>
        </a>
    </div>
</aside>
