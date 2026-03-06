@extends('front.layouts.front', ['title' => 'فاهم — منصة التعليم الذكي'])
@section('content')
<div class="home-page">
  <!-- HERO -->
  <section class="hp-hero">
    <div class="hp-orb hp-orb1"></div>
    <div class="hp-orb hp-orb2"></div>
    <div class="hp-hero-content">
      <div>
        <div class="h-eyebrow"><span class="e-dot"></span>منصة التعليم الأولى في مصر</div>
        <h1 class="h-headline">
          <span class="h-line-small">من أول خطوة...</span>
          طريق <span class="h-accent">نجاحك</span> الدراسي<br/>يبدأ معنا
        </h1>
        <p class="h-desc">منصة تعليمية متكاملة لطلاب <strong>الإعدادي والثانوي</strong>، كورسات منظمة، مدرسين متخصصين، وحصص مباشرة.</p>
        <div class="h-ctas">
          <a href="{{ route('front.register') }}" class="btn-hp">ابدأ التعلم مجاناً</a>
          <a href="{{ route('front.courses.index') }}" class="btn-hs">استكشف الكورسات</a>
        </div>
        <div class="trust-row">
          <div class="t-avs">
            <div class="t-av">أ</div><div class="t-av">م</div><div class="t-av">ك</div><div class="t-av">س</div>
            <div class="t-av" style="background:linear-gradient(135deg,#F59E0B,#D97706);font-size:0.57rem">+</div>
          </div>
          <div class="t-info"><strong>+٥٠٠٠ طالب انضموا</strong>انضم إليهم الآن مجاناً</div>
        </div>
      </div>
      <div class="hp-visual">
        <div class="hvc">
          <div class="hp-cp">
            <div class="hp-cph">
              <div class="hp-cphi">✍️</div>
              <div>
                <div class="hp-cphn">لغة عربية — إعدادي أول</div>
                <div class="hp-cphp">١٢ درس</div>
              </div>
            </div>
            <div class="hp-cpp">
              <div class="hp-cpp-row"><span class="hp-cpp-l">تقدمك</span><span class="hp-cpp-v">٦٨٪</span></div>
              <div class="hp-cpp-track"><div class="hp-cpp-fill"></div></div>
            </div>
            <div class="hp-cpl">
              <div class="hp-cpli"><div class="hp-cpli-ico ig">✓</div><span class="hp-cpli-t">الدرس الأول — مقدمة النحو</span><span class="hp-cpli-b bd">مكتمل</span></div>
              <div class="hp-cpli active"><div class="hp-cpli-ico ib">▶</div><span class="hp-cpli-t">الدرس الثاني — الفعل والفاعل</span><span class="hp-cpli-b bn">الآن</span></div>
              <div class="hp-cpli" style="opacity:0.45"><div class="hp-cpli-ico il">🔒</div><span class="hp-cpli-t">الدرس الثالث — المبتدأ والخبر</span></div>
            </div>
          </div>
        </div>
        <div class="hp-fc hp-fc1"><div class="hp-fc-val">+٥K <span class="hp-fc-tr">↑١٢٪</span></div><div class="hp-fc-lbl">طالب مسجل</div></div>
        <div class="hp-fc hp-fc2"><div class="hp-fc-val">٤.٩</div><div class="hp-fc-lbl">متوسط التقييم</div></div>
        <div class="hp-fc hp-fc3"><div class="hp-fc-val" style="font-size:0.88rem">لايف الآن</div><div class="hp-fc-lbl">حصة — رياضيات</div></div>
      </div>
    </div>
  </section>

  <!-- STATS (ثابتة) -->
  <section class="stats-band">
    <div class="stats-grid reveal">
      <div class="stat-box"><span class="stat-ico">👨‍🎓</span><div class="stat-num">+<span>٥</span>K</div><div class="stat-lbl">طالب مسجل</div></div>
      <div class="stat-box"><span class="stat-ico">📚</span><div class="stat-num"><span>١٢٠</span>+</div><div class="stat-lbl">كورس متاح</div></div>
      <div class="stat-box"><span class="stat-ico">👨‍🏫</span><div class="stat-num"><span>٣٠</span>+</div><div class="stat-lbl">مدرس متخصص</div></div>
      <div class="stat-box"><span class="stat-ico">⭐</span><div class="stat-num"><span>٤.٩</span></div><div class="stat-lbl">متوسط التقييم</div></div>
    </div>
  </section>

  <!-- STAGES -->
  @php
    $stageCards = [
      ['n' => 'المرحلة ١', 'ico' => '📘', 'name' => 'الإعدادية عربي', 'desc' => 'مواد المنهج المصري للصفوف الإعدادية الأول والثاني والثالث', 'cnt' => '٣٦ كورس', 'sc' => '#BFDBFE', 'sg' => 'linear-gradient(90deg, var(--blue), #7C3AED)'],
      ['n' => 'المرحلة ٢', 'ico' => '🌐', 'name' => 'الإعدادية لغات', 'desc' => 'المنهج بنظام اللغات للصفوف الإعدادية مع شرح احترافي', 'cnt' => '٢٤ كورس', 'sc' => '#BBF7D0', 'sg' => 'linear-gradient(90deg, #10B981, #059669)'],
      ['n' => 'المرحلة ٣', 'ico' => '📗', 'name' => 'الثانوية عربي', 'desc' => 'كورسات الثانوية العامة كاملة مع مراجعات وامتحانات تجريبية', 'cnt' => '٤٢ كورس', 'sc' => '#FDE68A', 'sg' => 'linear-gradient(90deg, #F59E0B, #D97706)'],
      ['n' => 'المرحلة ٤', 'ico' => '🌍', 'name' => 'الثانوية لغات', 'desc' => 'المنهج الثانوي بنظام اللغات — شرح باللغتين', 'cnt' => '٣٠ كورس', 'sc' => '#DDD6FE', 'sg' => 'linear-gradient(90deg, #8B5CF6, #7C3AED)'],
      ['n' => 'المرحلة ٥', 'ico' => '🎓', 'name' => 'الثانوية بكالوريا عربي', 'desc' => 'نظام البكالوريا الدولية مع تحضير متكامل للامتحانات', 'cnt' => '١٨ كورس', 'sc' => '#FECACA', 'sg' => 'linear-gradient(90deg, #EF4444, #DC2626)'],
      ['n' => 'المرحلة ٦', 'ico' => '🏆', 'name' => 'الثانوية بكالوريا لغات', 'desc' => 'بكالوريا دولية بنظام اللغات مع مدرسين معتمدين', 'cnt' => '١٢ كورس', 'sc' => '#99F6E4', 'sg' => 'linear-gradient(90deg, #14B8A6, #0D9488)'],
    ];
  @endphp
  <section class="stages-section" id="stages">
    <div class="sec-hd reveal">
      <div class="s-ey">المراحل الدراسية</div>
      <h2 class="s-ti">اختر <em>مسارك الدراسي</em></h2>
      <p class="s-sb">كورسات مخصصة لكل مرحلة — ابدأ رحلتك الآن</p>
    </div>
    <div class="stages-grid">
      @foreach($stageCards as $st)
        <a class="stg" href="{{ route('front.stages.index') }}" style="--stg-hover:{{ $st['sc'] }};--stg-line:{{ $st['sg'] }}">
          <div class="stg-n">{{ $st['n'] }}</div>
          <span class="stg-ico">{{ $st['ico'] }}</span>
          <div class="stg-name">{{ $st['name'] }}</div>
          <div class="stg-desc">{{ $st['desc'] }}</div>
          <div class="stg-cnt">{{ $st['cnt'] }}</div>
        </a>
      @endforeach
    </div>
  </section>

  <!-- SUBJECTS -->
  <section class="subj-sec" id="subjects">
    <div class="sec-hd reveal"><div class="s-ey">المواد الدراسية</div><h2 class="s-ti">كل المواد في <em>مكان واحد</em></h2></div>
    <div class="subj-scroll reveal">
      @forelse($subjects ?? [] as $subj)
        <a href="{{ route('front.courses.subject', $subj) }}" class="sp">
          <div class="sp-ic" style="background:linear-gradient(135deg,#EFF6FF,#BFDBFE)">📖</div>
          <div><div class="sp-n">{{ $subj->name }}</div><div class="sp-c">كورس</div></div>
        </a>
      @empty
        @foreach(['لغة عربية' => '٢٤', 'فيزياء' => '١٨', 'رياضيات' => '٣٢', 'علوم وبيولوجيا' => '٢٠', 'لغة إنجليزية' => '١٥', 'جغرافيا' => '١٢', 'تاريخ' => '١٠', 'كيمياء' => '١٤'] as $name => $cnt)
          <a href="{{ route('front.subjects.index') }}" class="sp"><div class="sp-ic" style="background:linear-gradient(135deg,#EFF6FF,#BFDBFE)">📖</div><div><div class="sp-n">{{ $name }}</div><div class="sp-c">{{ $cnt }} كورس</div></div></a>
        @endforeach
      @endforelse
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="how-sec">
    <div class="sec-hd reveal"><div class="s-ey">كيف يعمل</div><h2 class="s-ti">أربع خطوات لـ <em>التفوق</em></h2></div>
    <div class="steps-grid">
      <div class="steps-line"></div>
      <div class="step-card reveal"><div class="step-ico si1">١</div><div class="step-title">سجّل حسابك</div><div class="step-desc">أنشئ حساباً مجانياً في ثوانٍ بدون بطاقة ائتمان</div></div>
      <div class="step-card reveal rd1"><div class="step-ico si2">٢</div><div class="step-title">اختر مرحلتك</div><div class="step-desc">حدد صفك الدراسي والمواد التي تريد تحسينها</div></div>
      <div class="step-card reveal rd2"><div class="step-ico si3">٣</div><div class="step-title">اشترك في الكورس</div><div class="step-desc">فيديوهات + اختبارات + ملخصات في مكان واحد</div></div>
      <div class="step-card reveal rd3"><div class="step-ico si4">٤</div><div class="step-title">تفوّق وانجح</div><div class="step-desc">راجع إجاباتك وحقق أعلى الدرجات</div></div>
    </div>
  </section>

  <!-- COURSES PREVIEW -->
  <section class="courses-prev" id="courses">
    <div class="sec-hd reveal"><div class="s-ey">أشهر الكورسات</div><h2 class="s-ti">الكورسات الأكثر <em>تميزاً</em></h2></div>
    <div class="cpg">
      @forelse($featuredSubjects ?? [] as $subj)
        <a href="{{ route('front.courses.subject', $subj) }}" class="pc reveal">
          <div class="pc-thumb" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE)">📚</div>
          <div class="pc-body">
            <div class="pc-subj" style="color:var(--blue)">{{ $subj->grade?->name ?? 'كورس' }}</div>
            <div class="pc-title">{{ $subj->name }}</div>
            <div class="pc-meta">كورس متاح</div>
            <div class="pc-foot"><div class="pc-rating">٤.٩</div><div class="pc-stu">طالب</div></div>
          </div>
        </a>
      @empty
        <a href="{{ route('front.courses.index') }}" class="pc reveal"><div class="pc-thumb" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE)">✍️</div><div class="pc-body"><div class="pc-subj" style="color:var(--blue)">لغة عربية</div><div class="pc-title">لغة عربية — إعدادي أول</div><div class="pc-meta">١٢ درس</div><div class="pc-foot"><div class="pc-rating">٤.٩</div><div class="pc-stu">١٢٠٠</div></div></div></a>
        <a href="{{ route('front.courses.index') }}" class="pc reveal rd1"><div class="pc-thumb" style="background:linear-gradient(135deg,#F0FDF4,#BBF7D0)">📐</div><div class="pc-body"><div class="pc-subj" style="color:#10B981">رياضيات</div><div class="pc-title">رياضيات — ثانوي ثاني</div><div class="pc-meta">٢٠ درس</div><div class="pc-foot"><div class="pc-rating">٤.٨</div><div class="pc-stu">٩٨٠</div></div></div></a>
        <a href="{{ route('front.courses.index') }}" class="pc reveal rd2"><div class="pc-thumb" style="background:linear-gradient(135deg,#FFFBEB,#FDE68A)">🌍</div><div class="pc-body"><div class="pc-subj" style="color:#D97706">جغرافيا</div><div class="pc-title">جغرافيا — ثانوي ثاني</div><div class="pc-meta">١٦ درس</div><div class="pc-foot"><div class="pc-rating">٤.٧</div><div class="pc-stu">٧٥٠</div></div></div></a>
      @endforelse
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testi-sec">
    <div class="sec-hd reveal"><div class="s-ey">آراء الطلاب</div><h2 class="s-ti">بيقولوا <em>إيه عننا؟</em></h2></div>
    <div class="tg">
      @forelse($reviews ?? [] as $review)
        <div class="tc reveal">
          <div class="tc-stars">★★★★★</div>
          <div class="tc-text">{{ Str::limit($review->review_text, 120) }}</div>
          <div class="tc-user">
            <div class="tc-av">{{ mb_substr($review->name ?? '؟', 0, 1) }}</div>
            <div><div class="tc-name">{{ $review->name ?? 'طالب' }}</div><div class="tc-grade">{{ $review->subject_field ?? $review->subject?->name ?? '' }}</div></div>
          </div>
        </div>
      @empty
        <div class="tc reveal"><div class="tc-stars">★★★★★</div><div class="tc-text">المنصة دي غيرت طريقة مذاكرتي خالص! الشرح واضح والاختبارات بتساعدني أعرف أنا فاهم إيه.</div><div class="tc-user"><div class="tc-av">أ</div><div><div class="tc-name">أحمد محمد</div><div class="tc-grade">ثانوية ثالث</div></div></div></div>
        <div class="tc reveal rd1"><div class="tc-stars">★★★★★</div><div class="tc-text">دخلت فاهم وانا مش متوقع حاجة وطلعت مبسوط جداً. الدروس منظمة ومدرسين محترمين.</div><div class="tc-user"><div class="tc-av" style="background:linear-gradient(135deg,#F59E0B,#D97706)">م</div><div><div class="tc-name">مريم خالد</div><div class="tc-grade">إعدادية ثاني</div></div></div></div>
        <div class="tc reveal rd2"><div class="tc-stars">★★★★★</div><div class="tc-text">الحصص اللايف دي ميزة عظيمة! أقدر أسأل المدرس مباشرة وبتاخد رد في نفس الوقت.</div><div class="tc-user"><div class="tc-av" style="background:linear-gradient(135deg,#10B981,#059669)">ك</div><div><div class="tc-name">كريم سامي</div><div class="tc-grade">ثانوية أول</div></div></div></div>
      @endforelse
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-sec">
    <div class="cta-in reveal">
      <div class="cta-badge">انضم إلينا اليوم</div>
      <h2 class="cta-title">جاهز تبدأ رحلة نجاحك الدراسي؟</h2>
      <p class="cta-sub">أكثر من ٥٠٠٠ طالب بدأوا معنا ووصلوا لأحلامهم. أنت التالي.</p>
      <div class="cta-btns">
        <a href="{{ route('front.register') }}" class="btn-cw">إنشاء حساب مجاناً</a>
        <a href="{{ route('front.courses.index') }}" class="btn-co">تصفح الكورسات</a>
      </div>
    </div>
  </section>
</div>
@push('scripts')
<script>
(function(){
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(x){ if(x.isIntersecting) x.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('.home-page .reveal').forEach(function(el){ obs.observe(el); });
})();
</script>
@endpush
@endsection
