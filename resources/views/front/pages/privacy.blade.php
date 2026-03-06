@extends('front.layouts.front', ['title' => $title ?? 'سياسة الخصوصية'])

@section('content')
<div class="info-page">
  <div class="info-page-hero">
    <div class="hero-inner">
      <div class="hero-tag">خصوصيتك أمانة عندنا</div>
      <h1>سياسة الخصوصية</h1>
      <p class="hero-desc">بنأخد خصوصيتك بجدية تامة. اقرأ كيف نجمع بياناتك ونستخدمها ونحميها.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 60L1440 60L1440 0C1200 50 900 60 720 40C540 20 240 0 0 30Z" fill="#f0f4ff"/>
    </svg>
  </div>

  <div class="policy-layout">
    <nav class="policy-nav">
      <div class="pn-title">المحتوى</div>
      <a href="#sec-info"><span class="dot"></span> المعلومات التي نجمعها</a>
      <a href="#sec-use"><span class="dot"></span> كيف نستخدم بياناتك</a>
      <a href="#sec-protect"><span class="dot"></span> حماية البيانات</a>
      <a href="#sec-rights"><span class="dot"></span> حقوقك</a>
    </nav>

    <div class="policy-content">
      <div class="last-updated">آخر تحديث: يناير 2025</div>

      <div class="policy-section" id="sec-info">
        <h2><div class="sec-icon">1</div> المعلومات التي نجمعها</h2>
        <p>عند استخدامك لمنصة فاهم، نقوم بجمع أنواع مختلفة من المعلومات لتقديم خدمة أفضل وتجربة مخصصة لك.</p>
        <ul>
          <li>معلومات الحساب: الاسم، البريد الإلكتروني، رقم الهاتف، وكلمة المرور المشفّرة.</li>
          <li>بيانات الاستخدام: الكورسات التي شاهدتها، وقت المشاهدة، ونتائج الاختبارات.</li>
          <li>بيانات الجهاز: نوع المتصفح، نظام التشغيل، وعنوان IP.</li>
          <li>معلومات الدفع: بيانات المعاملات المالية (لا نحتفظ بأرقام البطاقات الكاملة).</li>
        </ul>
      </div>

      <div class="policy-section" id="sec-use">
        <h2><div class="sec-icon">2</div> كيف نستخدم بياناتك</h2>
        <p>نستخدم المعلومات التي نجمعها لتحسين خدماتنا وتقديم تجربة تعليمية مخصصة لك.</p>
        <ul>
          <li>تشغيل المنصة وتقديم الخدمات التعليمية بكفاءة عالية.</li>
          <li>تخصيص المحتوى التعليمي بناءً على مستواك واهتماماتك.</li>
          <li>إرسال إشعارات مهمة عن الكورسات والتحديثات والعروض.</li>
          <li>تحليل أداء المنصة وتطويرها باستمرار.</li>
        </ul>
      </div>

      <div class="policy-section" id="sec-protect">
        <h2><div class="sec-icon">3</div> حماية البيانات</h2>
        <p>أمان بياناتك أولويتنا القصوى. نستخدم أحدث تقنيات التشفير والحماية لضمان سلامة معلوماتك. جميع البيانات مشفّرة بتقنية SSL/TLS، ونجري تدقيقات أمنية دورية على أنظمتنا.</p>
      </div>

      <div class="policy-section" id="sec-rights">
        <h2><div class="sec-icon">4</div> حقوقك</h2>
        <p>لديك حقوق كاملة فيما يتعلق ببياناتك الشخصية على منصتنا.</p>
        <ul>
          <li>حق الوصول: يمكنك طلب نسخة من جميع بياناتك المحفوظة لدينا.</li>
          <li>حق التصحيح: تعديل أي معلومات غير دقيقة في أي وقت.</li>
          <li>حق الحذف: طلب حذف حسابك وجميع بياناتك نهائياً.</li>
          <li>حق الاعتراض: رفض استخدام بياناتك لأغراض التسويق.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
