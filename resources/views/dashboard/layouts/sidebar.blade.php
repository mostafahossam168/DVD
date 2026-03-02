<div class="sidebar">
    <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="list">
        <li class="list-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}">
                <div>
                    <i class="fa-solid fa-house"></i>
                    الرئيسية
                </div>
            </a>
        </li>
        @can('read_settings')
            @php
                $settingsActive =
                    request()->routeIs('dashboard.settings') || request()->routeIs('dashboard.pages.*');
                $currentStaticPage = request()->route('page');
            @endphp
            <li class="list-item {{ $settingsActive ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#collapse-settings" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        الإعدادات
                    </div>
                    <i class="fa-solid fa-angle-right arrow"></i>
                </a>
            </li>
            <div id="collapse-settings" class="collapse item-collapse {{ $settingsActive ? 'show' : '' }}">
                <li class="list-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.settings') }}">
                        <div>
                            <i class="fa-solid fa-sliders"></i>
                            الإعدادات العامة
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'about' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'about') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            عن المنصة
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'vision' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'vision') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            رؤيتنا
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'team' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'team') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            فريق العمل
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'faq' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'faq') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            الأسئلة الشائعة
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'privacy' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'privacy') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            سياسة الخصوصية
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'terms' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'terms') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            الشروط والأحكام
                        </div>
                    </a>
                </li>
                <li
                    class="list-item {{ request()->routeIs('dashboard.pages.edit') && $currentStaticPage === 'usage' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.pages.edit', 'usage') }}">
                        <div>
                            <i class="fa-solid fa-circle-dot"></i>
                            سياسة الاستخدام
                        </div>
                    </a>
                </li>
            </div>
        @endcan
        @can('read_admins')
            <li class="list-item {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.admins.index') }}">
                    <div>
                        <i class="fa-solid fa-users"></i>
                        المشرفين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_teachers')
            <li class="list-item {{ request()->routeIs('dashboard.teachers.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.teachers.index') }}">
                    <div>
                        <i class="fa-solid fa-person-chalkboard"></i>
                        المعلمين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_roles')
            <li class="list-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.roles.index') }}">
                    <div>
                        <i class="fa-solid fa-user-shield"></i>
                        الصلاحيات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_students')
            <li class="list-item {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.students.index') }}">
                    <div>
                        <i class="fa-solid fa-user-tie"></i>
                        الطلاب
                    </div>
                </a>
            </li>
        @endcan
        @can('read_stages')
            <li class="list-item {{ request()->routeIs('dashboard.stages.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.stages.index') }}">
                    <div>
                        <i class="fa-solid fa-graduation-cap"></i>
                        المراحل الدراسية
                    </div>
                </a>
            </li>
        @endcan
        @can('read_grades')
            <li class="list-item {{ request()->routeIs('dashboard.grades.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.grades.index') }}">
                    <div>
                        <i class="fa-solid fa-layer-group"></i>
                        الصفوف الدراسية
                    </div>
                </a>
            </li>
        @endcan
        @can('read_subjects')
            <li class="list-item {{ request()->routeIs('dashboard.subjects.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.subjects.index') }}">
                    <div>
                        <i class="fa-solid fa-book"></i>
                        المواد الدراسية
                    </div>
                </a>
            </li>
        @endcan
        @can('read_plans')
            <li class="list-item {{ request()->routeIs('dashboard.plans.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.plans.index') }}">
                    <div>
                        <i class="fa-solid fa-credit-card"></i>
                        الخطط
                    </div>
                </a>
            </li>
        @endcan
        @can('read_teacher_subscriptions')
            <li class="list-item {{ request()->routeIs('dashboard.teacher-subscriptions.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.teacher-subscriptions.index') }}">
                    <div>
                        <i class="fa-solid fa-user-check"></i>
                        اشتراكات المدرسين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_subscriptions')
            <li class="list-item {{ request()->routeIs('dashboard.subscriptions.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.subscriptions.index') }}">
                    <div>
                        <i class="fa-solid fa-user-graduate"></i>
                        اشتراكات الطلاب
                    </div>
                </a>
            </li>
            @can('update_subscriptions')
            <li class="list-item {{ request()->routeIs('dashboard.subscriptions-pending') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.subscriptions-pending') }}">
                    <div>
                        <i class="fa-solid fa-clock"></i>
                        طلبات الاشتراك (معلقة)
                    </div>
                </a>
            </li>
            @endcan
        @endcan
        @can('read_payment_methods')
            <li class="list-item {{ request()->routeIs('dashboard.payment-methods.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.payment-methods.index') }}">
                    <div>
                        <i class="fa-solid fa-credit-card"></i>
                        طرق الدفع
                    </div>
                </a>
            </li>
        @endcan
        @can('read_quiz_results')
            <li class="list-item {{ request()->routeIs('dashboard.quiz-results.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.quiz-results.index') }}">
                    <div>
                        <i class="fa-solid fa-list-check"></i>
                        نتائج الاختبارات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_contacts')
            <li class="list-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.contacts.index') }}">
                    <div>
                        <i class="fa-solid fa-comments"></i>
                        تواصل معنا
                    </div>
                </a>
            </li>
        @endcan
        @can('read_coupons')
            <li class="list-item {{ request()->routeIs('dashboard.coupons.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.coupons.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        الكوبونات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_lectuers')
            <li class="list-item {{ request()->routeIs('dashboard.lectuers.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.lectuers.index') }}">
                    <div>
                        <i class="fa-solid fa-video"></i>
                        الدروس
                    </div>
                </a>
            </li>
        @endcan
        @can('read_lectuers')
        <li class="list-item {{ request()->routeIs('dashboard.online-meetings.*') ? 'active' : '' }} ">
            <a href="{{ route('dashboard.online-meetings.index') }}">
                <div>
                    <i class="fa-solid fa-desktop"></i>
                    المحاضرات الأونلاين
                </div>
            </a>
        </li>
        @endcan
        @can('read_materials')
            <li class="list-item {{ request()->routeIs('dashboard.materials.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.materials.index') }}">
                    <div>
                        <i class="fa-solid fa-file-pdf"></i>
                        المواد التعليمية
                    </div>
                </a>
            </li>
        @endcan

        @can('read_quizes')
            <li class="list-item {{ request()->routeIs('dashboard.quizes.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.quizes.index') }}">
                    <div>
                        <i class="fa-solid fa-clipboard-question"></i>
                        الاختبارات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_questions')
            <li class="list-item {{ request()->routeIs('dashboard.questions.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.questions.index') }}">
                    <div>
                        <i class="fa-solid fa-question-circle"></i>
                        الأسئلة
                    </div>
                </a>
            </li>
        @endcan
        {{-- @endcan --}}
        {{-- <li class="list-item">
            <a href="index.html">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    اشعارات المشتركين
                </div>
            </a>
        </li>
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#collapse-1" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-gear icon"></i>
                    الإعدادات
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div id="collapse-1" class="collapse item-collapse">
            <li class="list-item">
                <a href="settings.html" class="">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        الإعدادات
                    </div>
                </a>
            </li>
        </div> --}}
        {{-- @can('read_settings')
            <li class="list-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                <a href="{{ route('dashboard.settings') }}">
                    <div>
                        <i class="fa-solid fa-gear icon"></i>
                        الإعدادات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_admins')
            <li class="list-item {{ request()->routeIs('dashboard.admins.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.admins.index') }}">
                    <div>
                        <i class="fa-solid fa-users"></i>
                        المشرفين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_teachers')
            <li class="list-item {{ request()->routeIs('dashboard.teachers.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.teachers.index') }}">
                    <div>
                        <i class="fa-solid fa-person-chalkboard"></i>
                        المعلمين
                    </div>
                </a>
            </li>
        @endcan
        @can('read_students')
            <li class="list-item {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.students.index') }}">
                    <div>
                        <i class="fa-solid fa-user-tie"></i>
                        الطلاب
                    </div>
                </a>
            </li>
        @endcan
        @can('read_roles')
            <li class="list-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.roles.index') }}">
                    <div>
                        <i class="fa-solid fa-user-shield"></i>
                        الصلاحيات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_categories')
            <li class="list-item {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.categories.index') }}">
                    <div>
                        <i class="fa-solid fa-sitemap"></i>
                        الاقسام
                    </div>
                </a>
            </li>
        @endcan
        @can('read_courses')
            <li class="list-item {{ request()->routeIs('dashboard.courses.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.courses.index') }}">
                    <div>
                        <i class="fa-solid fa-graduation-cap"></i>
                        الكورسات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_lessons')
            <li class="list-item {{ request()->routeIs('dashboard.lessons.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.lessons.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الدروس
                    </div>
                </a>
            </li>
        @endcan
        @can('read_coupones')
            <li class="list-item {{ request()->routeIs('dashboard.coupones.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.coupones.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        العروض
                    </div>
                </a>
            </li>
        @endcan
        @can('read_enrollments')
            <li class="list-item {{ request()->routeIs('dashboard.enrollments.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.enrollments.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        الاشتراكات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_reviews')
            <li class="list-item {{ request()->routeIs('dashboard.reviews.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.reviews.index') }}">
                    <div>
                        <i class="fa-solid fa-gift"></i>
                        التقيمات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_contacts')
            <li class="list-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.contacts.index') }}">
                    <div>
                        <i class="fa-solid fa-comments"></i>
                        تواصل معنا
                    </div>
                </a>
            </li>
        @endcan
        @can('read_actives')
            <li class="list-item {{ request()->routeIs('dashboard.actives.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.actives.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الجلسات النشطة
                    </div>
                </a>
            </li>
        @endcan
        @can('read_quizes')
            <li class="list-item {{ request()->routeIs('dashboard.quizes.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.quizes.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الاختبارات
                    </div>
                </a>
            </li>
        @endcan
        @can('read_questions')
            <li class="list-item {{ request()->routeIs('dashboard.questions.*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard.questions.index') }}">
                    <div>
                        <i class="fa-solid fa-chalkboard-teacher"></i>
                        الاسئله
                    </div>
                </a>
            </li>
        @endcan --}}
    </ul>
</div>
