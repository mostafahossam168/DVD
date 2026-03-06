@extends('dashboard.layouts.backend')

@section('contant')

<div class="page-header-v2 anim-v2">
    <div class="page-header-right">
        <h1>لوحة التحكم 👋</h1>
        <p class="page-sub">أهلاً بك! هنا نظرة عامة على كل ما يدور في المنصة.</p>
    </div>
    <div class="page-header-left">
        <button type="button" class="btn-sm-v2 btn-outline-v2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            تصدير التقرير
        </button>
        <a href="{{ route('dashboard.students.create') }}" class="btn-sm-v2 btn-blue-v2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            إضافة جديد
        </a>
    </div>
</div>

<!-- Quick Stats -->
<div class="quick-stats-v2">
    @can('read_students')
    <a href="{{ route('dashboard.students.index') }}" class="qs-card-v2 c-blue anim-v2 d1-v2">
        <div class="qs-icon-v2">👨‍🎓</div>
        <div class="qs-info-v2">
            <div class="qs-value-v2">{{ $studentsCount ?? 0 }}</div>
            <div class="qs-label-v2">إجمالي الطلاب</div>
            <div class="qs-change-v2 up">↑ نشط</div>
        </div>
    </a>
    @endcan
    @can('read_teachers')
    <a href="{{ route('dashboard.teachers.index') }}" class="qs-card-v2 c-green anim-v2 d2-v2">
        <div class="qs-icon-v2">🎓</div>
        <div class="qs-info-v2">
            <div class="qs-value-v2">{{ $teachersCount ?? 0 }}</div>
            <div class="qs-label-v2">المعلمون النشطون</div>
            <div class="qs-change-v2 up">↑ نشط</div>
        </div>
    </a>
    @endcan
    @can('read_subjects')
    <a href="{{ route('dashboard.subjects.index') }}" class="qs-card-v2 c-purple anim-v2 d3-v2">
        <div class="qs-icon-v2">📖</div>
        <div class="qs-info-v2">
            <div class="qs-value-v2">{{ $subjectsCount ?? 0 }}</div>
            <div class="qs-label-v2">المواد الدراسية</div>
            <div class="qs-change-v2 up">↑ نشط</div>
        </div>
    </a>
    @endcan
    <a href="{{ route('dashboard.subscriptions-pending') }}" class="qs-card-v2 c-gold anim-v2 d4-v2">
        <div class="qs-icon-v2">⏳</div>
        <div class="qs-info-v2">
            <div class="qs-value-v2">{{ $pendingCount ?? 0 }}</div>
            <div class="qs-label-v2">طلبات معلّقة</div>
            <div class="qs-change-v2 {{ ($pendingCount ?? 0) > 0 ? 'down' : 'up' }}">{{ ($pendingCount ?? 0) > 0 ? '⚠ تحتاج مراجعة' : 'لا يوجد' }}</div>
        </div>
    </a>
</div>

<!-- Main Grid -->
<div class="main-grid-v2">
    @can('read_admins')
    <a href="{{ route('dashboard.admins.index') }}" class="stat-card-v2 sc-blue anim-v2 d1-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">👤</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $adminsCount ?? 0 }}</div>
        <div class="stat-title-v2">المشرفين</div>
        <div class="stat-sub-v2">مشرفون نشطون يديرون المنصة</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $adminsCount ? min(100, $adminsCount * 20) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع المشرفين ←</span>
            <span class="mini-badge-v2" style="background:#eff6ff;color:var(--blue)">نشط</span>
        </div>
    </a>
    @endcan
    @can('read_teachers')
    <a href="{{ route('dashboard.teachers.index') }}" class="stat-card-v2 sc-green anim-v2 d2-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">🎓</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $teachersCount ?? 0 }}</div>
        <div class="stat-title-v2">المعلمين</div>
        <div class="stat-sub-v2">معلمون مسجلون ومفعّلون على المنصة</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $teachersCount ? min(100, $teachersCount * 40) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع المعلمين ←</span>
            <span class="mini-badge-v2" style="background:#f0fdf4;color:#16a34a">{{ $teachersCount ?? 0 }} نشط</span>
        </div>
    </a>
    @endcan
    @can('read_students')
    <a href="{{ route('dashboard.students.index') }}" class="stat-card-v2 sc-purple anim-v2 d3-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">👨‍🎓</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $studentsCount ?? 0 }}</div>
        <div class="stat-title-v2">الطلاب</div>
        <div class="stat-sub-v2">طلاب مسجلون في المراحل الدراسية</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $studentsCount ? min(100, $studentsCount * 25) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع الطلاب ←</span>
            <span class="mini-badge-v2" style="background:#f5f3ff;color:#7c3aed">نشط</span>
        </div>
    </a>
    @endcan
    @can('read_stages')
    <a href="{{ route('dashboard.stages.index') }}" class="stat-card-v2 sc-orange anim-v2 d4-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">🏫</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $stagesCount ?? 0 }}</div>
        <div class="stat-title-v2">المراحل الدراسية</div>
        <div class="stat-sub-v2">مراحل من الإعدادي حتى البكالوريا</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:100%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع المراحل ←</span>
            <span class="mini-badge-v2" style="background:#fff7ed;color:#ea580c">مكتمل</span>
        </div>
    </a>
    @endcan
    @can('read_subjects')
    <a href="{{ route('dashboard.subjects.index') }}" class="stat-card-v2 sc-teal anim-v2 d5-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">📖</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $subjectsCount ?? 0 }}</div>
        <div class="stat-title-v2">المواد الدراسية</div>
        <div class="stat-sub-v2">مواد منشورة ومتاحة للطلاب الآن</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $subjectsCount ? min(100, $subjectsCount * 33) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع المواد ←</span>
            <span class="mini-badge-v2" style="background:#f0fdfa;color:#0891b2">نشط</span>
        </div>
    </a>
    @endcan
    @can('read_lectuers')
    <a href="{{ route('dashboard.lectuers.index') }}" class="stat-card-v2 sc-rose anim-v2 d6-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">🎬</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $lecturesCount ?? 0 }}</div>
        <div class="stat-title-v2">الدروس</div>
        <div class="stat-sub-v2">دروس مرئية منشورة ومتاحة للمشاهدة</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $lecturesCount ? min(100, $lecturesCount * 35) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع الدروس ←</span>
            <span class="mini-badge-v2" style="background:#fff1f2;color:#e11d48">{{ $lecturesCount ?? 0 }} منشور</span>
        </div>
    </a>
    @endcan
    @can('read_roles')
    <a href="{{ route('dashboard.roles.index') }}" class="stat-card-v2 sc-indigo anim-v2 d7-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">🔑</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $rolesCount ?? 0 }}</div>
        <div class="stat-title-v2">الصلاحيات</div>
        <div class="stat-sub-v2">مجموعات صلاحيات معرّفة في النظام</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $rolesCount ? min(100, $rolesCount * 50) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع الصلاحيات ←</span>
            <span class="mini-badge-v2" style="background:#eef2ff;color:#4338ca">مُعدَّل</span>
        </div>
    </a>
    @endcan
    @can('read_contacts')
    <a href="{{ route('dashboard.contacts.index') }}" class="stat-card-v2 sc-gold anim-v2 d8-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">💬</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">{{ $contactsCount ?? 0 }}</div>
        <div class="stat-title-v2">تواصل معنا</div>
        <div class="stat-sub-v2">رسائل تنتظر الرد من فريق الدعم</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:{{ $contactsCount ? min(100, $contactsCount * 25) : 0 }}%"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض جميع الرسائل ←</span>
            <span class="mini-badge-v2" style="background:#fffbeb;color:#d97706">{{ ($contactsCount ?? 0) > 0 ? 'جديد' : '—' }}</span>
        </div>
    </a>
    @endcan
    @can('read_settings')
    <a href="{{ route('dashboard.settings') }}" class="stat-card-v2 settings-card-v2 anim-v2">
        <div class="stat-card-top-v2">
            <div class="stat-icon-wrap-v2">⚙️</div>
            <div class="stat-menu-v2">⋯</div>
        </div>
        <div class="stat-num-v2">—</div>
        <div class="stat-title-v2">الإعدادات</div>
        <div class="stat-sub-v2">ضبط إعدادات المنصة والنظام بالكامل</div>
        <div class="stat-bar-v2"><div class="stat-bar-fill-v2" style="width:80%;background:rgba(255,255,255,.4)"></div></div>
        <div class="stat-footer-v2">
            <span class="stat-link-v2">عرض الإعدادات ←</span>
        </div>
    </a>
    @endcan
</div>

<!-- Bottom Row -->
<div class="bottom-row-v2">
    <div class="widget-v2 anim-v2">
        <div class="widget-head-v2">
            <h3><span class="wh-icon">🕐</span> آخر النشاطات</h3>
            <a href="{{ route('dashboard.students.index') }}" class="widget-more-v2">عرض الكل ←</a>
        </div>
        <div class="activity-list-v2">
            <div class="activity-item-v2">
                <div class="act-avatar-v2" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">م</div>
                <div class="act-info-v2">
                    <div class="act-name-v2">الطلاب والمعلمون</div>
                    <div class="act-desc-v2">آخر التسجيلات والنشاطات تظهر هنا</div>
                </div>
                <div class="act-time-v2">—</div>
            </div>
            <div class="activity-item-v2">
                <div class="act-avatar-v2" style="background:linear-gradient(135deg,#059669,#34d399)">د</div>
                <div class="act-info-v2">
                    <div class="act-name-v2">الدروس والمواد</div>
                    <div class="act-desc-v2">آخر الدروس المضافة أو المحدّثة</div>
                </div>
                <div class="act-time-v2">—</div>
            </div>
            <div class="activity-item-v2">
                <div class="act-avatar-v2" style="background:linear-gradient(135deg,#1a56db,#3b82f6)">اش</div>
                <div class="act-info-v2">
                    <div class="act-name-v2">الاشتراكات</div>
                    <div class="act-desc-v2">طلبات الاشتراك والمدفوعات</div>
                </div>
                <div class="act-time-v2">—</div>
            </div>
        </div>
    </div>

    <div class="widget-v2 anim-v2 d2-v2">
        <div class="widget-head-v2">
            <h3><span class="wh-icon">⏳</span> طلبات الاشتراك المعلّقة</h3>
            <a href="{{ route('dashboard.subscriptions-pending') }}" class="widget-more-v2">عرض الكل ←</a>
        </div>
        <div class="pending-list-v2">
            @forelse($pendingSubscriptions ?? collect() as $item)
            <div class="pending-item-v2">
                <div class="act-avatar-v2" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">{{ mb_substr($item->user->name ?? '—', 0, 1) }}</div>
                <div class="pend-info-v2">
                    <div class="pend-name-v2">{{ $item->user->name ?? '—' }}</div>
                    <div class="pend-sub-v2">اشتراك {{ $item->subject->name ?? '—' }}</div>
                </div>
                <div class="pend-actions-v2">
                    <form action="{{ route('dashboard.subscriptions.approve', $item) }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="pend-btn-v2 pend-accept-v2">قبول</button>
                    </form>
                    <form action="{{ route('dashboard.subscriptions.reject', $item) }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="pend-btn-v2 pend-reject-v2">رفض</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="pending-item-v2" style="opacity:.7">
                <div class="act-avatar-v2" style="background:#e2e8f0;color:#94a3b8">—</div>
                <div class="pend-info-v2">
                    <div class="pend-name-v2" style="color:var(--muted)">لا توجد طلبات أخرى</div>
                    <div class="pend-sub-v2">كل الطلبات السابقة تمت معالجتها</div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
