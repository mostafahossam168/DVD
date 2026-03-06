@extends('front.layouts.front', ['title' => $title ?? 'من نحن'])

@section('content')
<div class="info-page">
  <div class="info-page-hero">
    <div class="hero-inner">
      <div class="hero-tag">👋 تعرّف علينا</div>
      <h1>نحن فاهم —<br>منصة التعليم المختلفة</h1>
      <p class="hero-desc">بنؤمن إن كل طالب يقدر يفهم ويتفوق لو اتعلّم بالأسلوب الصح. مش بس منهج، دي رحلة تعلّم حقيقية.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 60L1440 60L1440 0C1200 50 900 60 720 40C540 20 240 0 0 30Z" fill="#f0f4ff"/>
    </svg>
  </div>

  <div class="about-body">
    <div class="mission-grid">
      <div class="mission-card">
        <div class="mc-icon" style="background:#eff6ff">🎯</div>
        <div class="mc-title">رسالتنا</div>
        <div class="mc-text">نقدم تعليماً عالي الجودة يناسب كل طالب بأسلوب سهل ومبسّط يضمن الفهم الحقيقي لا الحفظ.</div>
      </div>
      <div class="mission-card">
        <div class="mc-icon" style="background:#f0fdf4">🌱</div>
        <div class="mc-title">رؤيتنا</div>
        <div class="mc-text">أن نكون المنصة التعليمية الأولى في المنطقة العربية التي تغيّر مفهوم التعلم وتجعله ممتعاً وفعّالاً.</div>
      </div>
      <div class="mission-card">
        <div class="mc-icon" style="background:#fff7ed">💡</div>
        <div class="mc-title">قيمنا</div>
        <div class="mc-text">الشفافية، الجودة، الابتكار، والتركيز على نتائج حقيقية قابلة للقياس لكل طالب على منصتنا.</div>
      </div>
    </div>

    <div class="story-section">
      <div class="story-text">
        <h2>قصتنا مع <span>التعليم</span></h2>
        <p>بدأت فاهم برؤية بسيطة: إن الطالب المصري يستحق تعليماً بجودة عالمية بأسلوب يناسبه ويفهمه.</p>
        <p>من غرفة صغيرة لمنصة يثق فيها آلاف الطلاب، رحلتنا كلها كانت عشان نحل مشكلة حقيقية — الفهم مش الحفظ.</p>
        <ul class="story-list">
          <li><div class="check">✓</div>محتوى تعليمي محدّث باستمرار يواكب المناهج الحديثة</li>
          <li><div class="check">✓</div>مدرسين متخصصين بخبرة عملية واسعة</li>
          <li><div class="check">✓</div>متابعة مستمرة وتقييمات دورية لكل طالب</li>
          <li><div class="check">✓</div>دعم فني على مدار الساعة لضمان تجربة سلسة</li>
        </ul>
      </div>
      <div class="story-visual">
        <div class="stats-big">
          <div class="stat-big"><div class="n">50K+</div><div class="l">طالب نشط</div></div>
          <div class="stat-big"><div class="n">+1200</div><div class="l">كورس متاح</div></div>
          <div class="stat-big"><div class="n">4.9★</div><div class="l">متوسط التقييم</div></div>
          <div class="stat-big"><div class="n">98%</div><div class="l">نسبة الرضا</div></div>
        </div>
      </div>
    </div>

    <div class="team-section">
      <div class="info-section-title">
        <h2>فريق فاهم</h2>
        <p>ناس بتؤمن بقوة التعليم وبتشتغل كل يوم عشانك</p>
      </div>
      <div class="team-grid">
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#1a56db,#3b82f6)">👨‍💼</div>
          <div class="team-name">أحمد محمد</div>
          <div class="team-role">المؤسس والرئيس التنفيذي</div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">👩‍🏫</div>
          <div class="team-name">سارة علي</div>
          <div class="team-role">مديرة المحتوى التعليمي</div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#059669,#34d399)">👨‍💻</div>
          <div class="team-name">كريم حسن</div>
          <div class="team-role">مدير التطوير التقني</div>
        </div>
        <div class="team-card">
          <div class="team-avatar" style="background:linear-gradient(135deg,#ea580c,#fb923c)">👩‍🎨</div>
          <div class="team-name">منى خالد</div>
          <div class="team-role">مديرة تجربة المستخدم</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
