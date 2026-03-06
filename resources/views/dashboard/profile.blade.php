@extends('dashboard.layouts.backend', ['title' => 'الملف الشخصي'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <span class="current">الملف الشخصي</span>
    </div>

    <div class="page-header-ds fade-up-ds">
        <h1>الملف الشخصي</h1>
        <div class="page-header-actions">
            <button type="submit" form="profileForm" class="btn-ds btn-success-ds">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                حفظ التعديلات
            </button>
        </div>
    </div>

    <x-alert-component></x-alert-component>

    <form id="profileForm" action="{{ route('dashboard.update-profile') }}" enctype="multipart/form-data" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="profile-layout-ds">
            <!-- Sidebar -->
            <div class="profile-sidebar-ds">
                <div class="profile-cover-ds"></div>
                <div class="profile-avatar-wrap-ds">
                    @if($user->image && file_exists(public_path($user->image)))
                        <img src="{{ display_file($user->image) }}" alt="" class="profile-avatar-ds">
                    @else
                        <div class="profile-avatar-ph-ds">{{ mb_substr($user->full_name ?? 'أ', 0, 1) }}</div>
                    @endif
                    <div class="profile-name-ds">{{ $user->full_name ?: 'المشرف' }}</div>
                    <div class="profile-email-ds">{{ $user->email ?? '—' }}</div>
                    <div class="profile-role-ds">🛡️ {{ $user->getRoleNames()->first() ?: 'Super Admin' }}</div>
                </div>
                <div class="profile-stats-ds">
                    <div class="profile-stat-ds"><div class="ps-num-ds">{{ \App\Models\Stage::count() }}</div><div class="ps-lbl-ds">مراحل</div></div>
                    <div class="profile-stat-ds"><div class="ps-num-ds">{{ \App\Models\Subject::count() }}</div><div class="ps-lbl-ds">مواد</div></div>
                </div>
                <div class="profile-nav-ds">
                    <a href="#personal" class="profile-nav-item-ds active-ds"><span class="pni-icon-ds">👤</span> البيانات الشخصية</a>
                    <a href="#password" class="profile-nav-item-ds"><span class="pni-icon-ds">🔒</span> الأمان وكلمة المرور</a>
                </div>
            </div>

            <!-- Main -->
            <div>
                <div id="personal" class="profile-section-ds">
                    <div class="section-head-ds"><h3><span class="sh-icon">👤</span> البيانات الشخصية</h3></div>
                    <div class="section-body-ds">
                        <div class="form-grid-ds">
                            <div class="form-group-ds">
                                <label class="form-label-ds">الاسم الأول <span class="required-ds">*</span></label>
                                <input type="text" name="f_name" class="form-control-ds" value="{{ $user->f_name }}" required>
                            </div>
                            <div class="form-group-ds">
                                <label class="form-label-ds">الاسم الأخير <span class="required-ds">*</span></label>
                                <input type="text" name="l_name" class="form-control-ds" value="{{ $user->l_name }}" required>
                            </div>
                            <div class="form-group-ds">
                                <label class="form-label-ds">البريد الإلكتروني <span class="required-ds">*</span></label>
                                <input type="email" name="email" class="form-control-ds" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group-ds">
                                <label class="form-label-ds">الهاتف</label>
                                <input type="text" name="phone" class="form-control-ds" value="{{ $user->phone }}" style="direction:ltr;text-align:right">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section-ds">
                    <div class="section-head-ds"><h3><span class="sh-icon">🖼️</span> الصورة الشخصية</h3></div>
                    <div class="section-body-ds">
                        <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap">
                            @if($user->image && file_exists(public_path($user->image)))
                                <img src="{{ display_file($user->image) }}" alt="" class="profile-avatar-ds" style="width:80px;height:80px">
                            @else
                                <div class="profile-avatar-ph-ds" style="width:80px;height:80px;font-size:1.8rem">{{ mb_substr($user->full_name ?? 'أ', 0, 1) }}</div>
                            @endif
                            <label class="file-upload-ds" style="flex:1;min-width:200px;position:relative">
                                <input type="file" name="image" accept="image/*">
                                <div class="file-upload-icon-ds" style="font-size:2rem;margin-bottom:.5rem;opacity:.5">📷</div>
                                <div class="file-upload-text-ds" style="font-size:.84rem;font-weight:600;color:var(--muted)">اسحب الصورة هنا أو <span style="color:var(--blue);font-weight:700">تصفح</span></div>
                                <div class="file-upload-hint-ds" style="font-size:.72rem;color:#b0b8d8;margin-top:.25rem">PNG, JPG حتى 2MB</div>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="password" class="profile-section-ds">
                    <div class="section-head-ds"><h3><span class="sh-icon">🔒</span> تغيير كلمة المرور</h3></div>
                    <div class="section-body-ds">
                        <p style="font-size:.85rem;color:var(--muted);margin-bottom:1rem">اترك الحقول فارغة إذا لم ترد تغيير كلمة المرور.</p>
                        <div class="form-grid-ds">
                            <div class="form-group-ds col-span-2-ds" style="grid-column:span 2">
                                <label class="form-label-ds">كلمة المرور الجديدة</label>
                                <input type="password" name="password" class="form-control-ds" placeholder="••••••••">
                            </div>
                            <div class="form-group-ds col-span-2-ds" style="grid-column:span 2">
                                <label class="form-label-ds">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" class="form-control-ds" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
