@extends('front.layouts.front', ['title' => 'فاهم — الملف الشخصي'])

@section('content')
<div class="profile-page-wrap">

    <div class="profile-page-header">
        <div class="profile-page-eyebrow">👤 حسابي</div>
        <h1 class="profile-page-title">الملف الشخصي</h1>
    </div>

    {{-- Hero --}}
    <div class="profile-hero">
        <div class="profile-hero-avatar-wrap">
            <div class="profile-hero-avatar" id="heroAvatarEl" onclick="document.getElementById('avatarFileInput').click()">
                @if($user->image)
                    <img src="{{ display_file($user->image) }}" alt="">
                @else
                    {{ mb_substr($user->full_name, 0, 1) }}
                @endif
                <div class="avatar-overlay">📷</div>
            </div>
            <div class="avatar-badge">✓</div>
        </div>
        <div class="profile-hero-info">
            <div class="profile-hero-name">{{ $user->full_name }}</div>
            <div class="profile-hero-email">{{ $user->email }}</div>
            <div class="profile-hero-badges">
                <span class="hero-badge badge-active"><span class="profile-status-dot"></span> حساب مفعّل</span>
                <span class="hero-badge badge-courses">🎓 {{ $coursesCount }} كورس{{ $coursesCount !== 1 && $coursesCount !== 2 ? 'ات' : ($coursesCount === 2 ? 'ان' : '') }}</span>
                @if($ratingAvg !== null)
                    <span class="hero-badge" style="background:rgba(245,158,11,0.2);color:#FCD34D;border:1px solid rgba(245,158,11,0.3)">⭐ تقييماتي</span>
                @endif
            </div>
        </div>
        <div class="profile-hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-val">{{ $coursesCount }}</div>
                <div class="hero-stat-label">كورسات</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-val">{{ $ratingAvg ?? '—' }}</div>
                <div class="hero-stat-label">متوسط التقييم</div>
            </div>
        </div>
    </div>

    <div class="profile-grid">

        {{-- Left: Account info + quick links --}}
        <div>
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-title">📋 معلومات الحساب</div>
                    <span style="font-size:0.72rem;color:var(--muted);font-weight:600">آخر تحديث: اليوم</span>
                </div>
                <div class="profile-card-body">
                    <div class="profile-info-list">
                        <div class="profile-info-item">
                            <span class="profile-info-label">👤 الاسم</span>
                            <span class="profile-info-value">{{ $user->full_name }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">📧 الإيميل</span>
                            <span class="profile-info-value email">{{ $user->email }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">📱 الهاتف</span>
                            <span class="profile-info-value">{{ $user->phone ?? '—' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">🔰 الحالة</span>
                            <span class="profile-status-chip"><span class="profile-status-dot"></span> {{ $user->status ? 'مفعّل' : 'غير مفعّل' }}</span>
                        </div>
                        <div class="profile-info-item">
                            <span class="profile-info-label">📅 تاريخ الانضمام</span>
                            <span class="profile-info-value">{{ $user->created_at->translatedFormat('F Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('front.courses.my') }}" class="btn-profile-courses">🎓 الذهاب إلى كورساتي</a>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-title">⚡ روابط سريعة</div>
                </div>
                <div class="profile-card-body" style="padding:12px">
                    <a href="{{ route('front.courses.my') }}" class="profile-quick-link"><span style="font-size:1.1rem">🎓</span> دوراتي المسجل فيها</a>
                    <a href="{{ route('front.quizzes.history') }}" class="profile-quick-link"><span style="font-size:1.1rem">📝</span> اختباراتي</a>
                    <a href="{{ route('front.favorites.index') }}" class="profile-quick-link"><span style="font-size:1.1rem">❤️</span> الكورسات المفضلة</a>
                </div>
            </div>
        </div>

        {{-- Right: Edit form --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-title">✏️ تعديل البيانات</div>
                <span style="font-size:0.75rem;background:var(--blue-light);color:var(--blue);padding:3px 10px;border-radius:20px;font-weight:700">تحرير</span>
            </div>
            <div class="profile-card-body">

                <form method="POST" action="{{ route('front.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                    @csrf

                    <div class="profile-form-section-title">الصورة الشخصية</div>
                    <div class="profile-avatar-upload-area" onclick="document.getElementById('avatarFileInput').click()">
                        <div class="profile-upload-preview" id="uploadPreview">
                            @if($user->image)
                                <img src="{{ display_file($user->image) }}" alt="">
                            @else
                                {{ mb_substr($user->full_name, 0, 1) }}
                            @endif
                        </div>
                        <div class="profile-upload-text-area">
                            <div class="profile-upload-title">تغيير الصورة الشخصية</div>
                            <div class="profile-upload-hint-text">JPG، PNG، GIF أو WebP — حد أقصى 2 ميجا</div>
                            <label class="upload-btn-label" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;padding:6px 14px;background:var(--white);border:1.5px solid var(--border);border-radius:8px;font-size:0.78rem;font-weight:700;color:var(--mid);cursor:pointer" onclick="event.stopPropagation()">
                                📎 اختر صورة
                                <input type="file" name="image" id="avatarFileInput" accept="image/*" style="display:none" onchange="profilePreviewAvatar(this)"/>
                            </label>
                        </div>
                    </div>

                    <div class="profile-form-section-title">البيانات الشخصية</div>
                    <div class="profile-form-row">
                        <div class="profile-form-group" style="margin-bottom:0">
                            <label class="profile-form-label">الاسم الأول <span>*</span></label>
                            <input type="text" name="f_name" class="profile-form-input" value="{{ old('f_name', $user->f_name) }}" placeholder="الاسم الأول" required>
                        </div>
                        <div class="profile-form-group" style="margin-bottom:0">
                            <label class="profile-form-label">الاسم الأخير <span>*</span></label>
                            <input type="text" name="l_name" class="profile-form-input" value="{{ old('l_name', $user->l_name) }}" placeholder="الاسم الأخير" required>
                        </div>
                    </div>

                    <div class="profile-form-group" style="margin-top:14px">
                        <label class="profile-form-label">الإيميل</label>
                        <input type="email" class="profile-form-input" value="{{ $user->email }}" disabled>
                        <div class="profile-form-hint">⚠️ لا يمكن تغيير الإيميل، تواصل مع الدعم الفني إذا كنت بحاجة لذلك.</div>
                    </div>

                    <div class="profile-form-group">
                        <label class="profile-form-label">رقم الهاتف <span>*</span></label>
                        <input type="tel" name="phone" class="profile-form-input" value="{{ old('phone', $user->phone) }}" placeholder="01XXXXXXXXX" required>
                    </div>

                    <div class="profile-form-section-title" style="margin-top:8px">تغيير كلمة المرور</div>
                    <div class="profile-password-section">
                        <div class="profile-password-section-title">🔐 تغيير كلمة المرور <span style="font-size:0.72rem;font-weight:500;color:var(--muted)">(اتركها فارغة إذا لم ترغب في التغيير)</span></div>
                        <div class="profile-form-group">
                            <label class="profile-form-label">كلمة المرور الحالية</label>
                            <div class="profile-pass-input-wrap">
                                <input type="password" name="current_password" class="profile-form-input" id="currentPass" placeholder="أدخل كلمة المرور الحالية">
                                <button class="profile-pass-toggle" type="button" onclick="profileTogglePass('currentPass',this)">👁</button>
                            </div>
                            @error('current_password')<div class="profile-form-hint" style="color:var(--red)">{{ $message }}</div>@enderror
                        </div>
                        <div class="profile-form-group">
                            <label class="profile-form-label">كلمة المرور الجديدة</label>
                            <div class="profile-pass-input-wrap">
                                <input type="password" name="password" class="profile-form-input" id="newPass" placeholder="أدخل كلمة المرور الجديدة" oninput="profileCheckStrength(this.value)">
                                <button class="profile-pass-toggle" type="button" onclick="profileTogglePass('newPass',this)">👁</button>
                            </div>
                            <div class="profile-pass-strength">
                                <div class="profile-strength-bar" id="profileSb1"></div>
                                <div class="profile-strength-bar" id="profileSb2"></div>
                                <div class="profile-strength-bar" id="profileSb3"></div>
                                <div class="profile-strength-bar" id="profileSb4"></div>
                            </div>
                            <div class="profile-form-hint" id="profileStrengthLabel"></div>
                        </div>
                        <div class="profile-form-group" style="margin-bottom:0">
                            <label class="profile-form-label">تأكيد كلمة المرور</label>
                            <div class="profile-pass-input-wrap">
                                <input type="password" name="password_confirmation" class="profile-form-input" id="confirmPass" placeholder="أعد إدخال كلمة المرور الجديدة">
                                <button class="profile-pass-toggle" type="button" onclick="profileTogglePass('confirmPass',this)">👁</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-profile-save" id="profileSaveBtn">
                        <span>💾</span> حفظ التعديلات
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

{{-- Toast --}}
<div class="profile-toast" id="profileToast"></div>

@push('scripts')
<script>
(function() {
  var toastEl = document.getElementById('profileToast');
  @if (session('success'))
    toastEl.textContent = {{ json_encode(session('success')) }};
    toastEl.className = 'profile-toast success show';
    setTimeout(function() { toastEl.classList.remove('show'); }, 3000);
  @endif
  @if ($errors->any())
    toastEl.textContent = {{ json_encode($errors->first()) }};
    toastEl.className = 'profile-toast show';
    setTimeout(function() { toastEl.classList.remove('show'); }, 4000);
  @endif

  window.profilePreviewAvatar = function(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function(e) {
      var preview = document.getElementById('uploadPreview');
      preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
      var hero = document.getElementById('heroAvatarEl');
      if (hero) {
        hero.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover"><div class="avatar-overlay">📷</div>';
      }
    };
    reader.readAsDataURL(input.files[0]);
  };

  window.profileTogglePass = function(id, btn) {
    var inp = document.getElementById(id);
    if (inp.type === 'password') { inp.type = 'text'; btn.textContent = '🙈'; }
    else { inp.type = 'password'; btn.textContent = '👁'; }
  };

  window.profileCheckStrength = function(val) {
    var bars = ['profileSb1', 'profileSb2', 'profileSb3', 'profileSb4'];
    var lbl = document.getElementById('profileStrengthLabel');
    bars.forEach(function(b) { document.getElementById(b).className = 'profile-strength-bar'; });
    if (!val) { lbl.textContent = ''; return; }
    var score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    var cls = score <= 1 ? 'weak' : score <= 2 ? 'medium' : 'strong';
    var labels = ['', 'ضعيفة 🔴', 'متوسطة 🟡', 'متوسطة 🟡', 'قوية 🟢'];
    for (var i = 0; i < score; i++) document.getElementById(bars[i]).classList.add(cls);
    lbl.textContent = 'قوة كلمة المرور: ' + (labels[score] || '');
    lbl.style.color = score <= 1 ? 'var(--red)' : score <= 2 ? 'var(--amber)' : 'var(--green)';
  };

  var form = document.getElementById('profileForm');
  if (form) {
    form.addEventListener('submit', function() {
      var btn = document.getElementById('profileSaveBtn');
      if (btn) {
        btn.innerHTML = '<span>⏳</span> جارٍ الحفظ...';
        btn.disabled = true;
      }
    });
  }
})();
</script>
@endpush
@endsection
