<div class="topbar-v2">
    <div class="topbar-right">
        <button type="button" class="icon-btn d-lg-none" id="sidebarToggle" aria-label="القائمة">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
        </button>
        <div class="breadcrumb-v2">
            <a href="{{ route('dashboard.home') }}" class="bc-home">الرئيسية</a>
            <span class="sep">/</span>
            <span class="bc-current">{{ $breadcrumb ?? $title ?? 'لوحة التحكم' }}</span>
        </div>
    </div>
    <div class="topbar-left">
        <div class="topbar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" placeholder="بحث سريع...">
        </div>
        <div class="topbar-date">{{ now()->locale('ar')->translatedFormat('l، d F Y') }}</div>
        <a href="{{ route('dashboard.contacts.index') }}" class="icon-btn" title="تواصل معنا" style="position:relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            @php $contactsUnread = \App\Models\Contact::count(); @endphp
            @if($contactsUnread > 0)<div class="notif-dot"></div>@endif
        </a>

        <!-- User Menu -->
        @php $user = auth()->user(); $userName = $user->full_name ?: 'مدير النظام'; $userRole = $user->getRoleNames()->first() ?: 'Super Admin'; $userInitial = mb_substr($userName, 0, 1) ?: 'أ'; @endphp
        <div class="user-menu-v2" id="userMenuV2">
            <div class="user-btn-v2" id="userBtnV2" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">
                <div class="user-info-v2">
                    <span class="user-name-v2">{{ $userName }}</span>
                    <span class="user-role-v2">{{ $userRole }}</span>
                </div>
                <div class="user-avatar-v2">
                @if($user->image)
                    <img src="{{ display_file($user->image) }}" alt="{{ $userName }}" class="avatar-img-v2">
                @else
                    {{ $userInitial }}
                @endif
                </div>
                <div class="user-chevron-v2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>

            <div class="user-dropdown-v2" id="userDropdownV2" aria-hidden="true">
                <div class="dd-header-v2">
                    <div class="dd-avatar-big-v2">
                    @if($user->image)
                        <img src="{{ display_file($user->image) }}" alt="{{ $userName }}" class="avatar-img-v2">
                    @else
                        {{ $userInitial }}
                    @endif
                </div>
                    <div>
                        <div class="dd-name-v2">{{ $userName }}</div>
                        <div class="dd-email-v2">{{ $user->email ?? '—' }}</div>
                        <div class="dd-badge-v2">🛡️ {{ $userRole }}</div>
                    </div>
                </div>

                <a href="{{ route('dashboard.profile') }}" class="dd-item-v2">
                    <div class="dd-icon-v2" style="background:#eff6ff">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="var(--blue)" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </div>
                    <span class="dd-label-v2">الملف الشخصي</span>
                    <span class="dd-arrow-v2">←</span>
                </a>
                <a href="{{ route('dashboard.profile') }}#password" class="dd-item-v2">
                    <div class="dd-icon-v2" style="background:#f0fdf4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <span class="dd-label-v2">تغيير كلمة المرور</span>
                    <span class="dd-arrow-v2">←</span>
                </a>
                <a href="{{ route('dashboard.profile') }}" class="dd-item-v2">
                    <div class="dd-icon-v2" style="background:#f5f3ff">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#7c3aed" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    </div>
                    <span class="dd-label-v2">إعدادات الحساب</span>
                    <span class="dd-arrow-v2">←</span>
                </a>

                <div class="dd-sep-v2"></div>

                <form action="{{ route('dashboard.logout') }}" method="POST" class="d-inline" id="logoutFormV2">
                    @csrf
                    <button type="submit" class="dd-item-v2 logout w-100 text-start border-0 bg-transparent" style="cursor:pointer">
                        <div class="dd-icon-v2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        </div>
                        <span class="dd-label-v2">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
