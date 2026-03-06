@extends('front.layouts.front', ['title' => $title ?? 'الشروط والأحكام'])

@section('content')
<div class="info-page">
  <div class="info-page-hero">
    <div class="hero-inner">
      <div class="hero-tag">📄 اتفاقية الاستخدام</div>
      <h1>الشروط والأحكام</h1>
      <p class="hero-desc">من فضلك اقرأ هذه الشروط بعناية قبل استخدام منصة فاهم.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 60L1440 60L1440 0C1200 50 900 60 720 40C540 20 240 0 0 30Z" fill="#f0f4ff"/>
    </svg>
  </div>

  <div class="policy-layout">
    <nav class="policy-nav">
      <div class="pn-title">الأقسام</div>
      <a href="#sec-accept"><span class="dot"></span> قبول الشروط</a>
      <a href="#sec-use"><span class="dot"></span> شروط الاستخدام</a>
      <a href="#sec-ip"><span class="dot"></span> حقوق الملكية الفكرية</a>
      <a href="#sec-sub"><span class="dot"></span> سياسة الاشتراكات</a>
    </nav>

    <div class="policy-content">
      <div class="last-updated">📅 آخر تحديث: يناير 2025</div>

      <div class="policy-section" id="sec-accept">
        <h2><div class="sec-icon">✅</div> قبول الشروط</h2>
        <p>باستخدامك لمنصة فاهم، فأنت توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي من هذه الشروط، يُرجى عدم استخدام المنصة.</p>
        <p>هذه الشروط تُشكّل اتفاقية قانونية ملزمة بينك وبين شركة فاهم للتعليم الإلكتروني.</p>
      </div>

      <div class="policy-section" id="sec-use">
        <h2><div class="sec-icon">📖</div> شروط الاستخدام</h2>
        <ul>
          <li>يجب أن تكون في سن 13 عاماً أو أكثر لإنشاء حساب على المنصة.</li>
          <li>أنت مسؤول عن الحفاظ على سرية بيانات حسابك وكلمة المرور.</li>
          <li>لا يجوز مشاركة حسابك مع الآخرين أو السماح لهم باستخدامه.</li>
          <li>يُحظر استخدام المنصة لأي غرض غير مشروع أو ضار.</li>
        </ul>
      </div>

      <div class="policy-section" id="sec-ip">
        <h2><div class="sec-icon">©️</div> حقوق الملكية الفكرية</h2>
        <p>جميع المحتويات المنشورة على منصة فاهم — بما في ذلك الفيديوهات، والنصوص، والصور، والاختبارات — هي ملك حصري لمنصة فاهم أو المدرسين المرخصين.</p>
        <ul>
          <li>يُحظر تنزيل أو نسخ أو إعادة توزيع أي محتوى دون إذن كتابي مسبق.</li>
          <li>يُحظر تسجيل الشاشة أو أي طريقة أخرى لنسخ محتوى الكورسات.</li>
          <li>المخالفة ستُعرّضك للمساءلة القانونية وفق قوانين حقوق الملكية الفكرية.</li>
        </ul>
      </div>

      <div class="policy-section" id="sec-sub">
        <h2><div class="sec-icon">💳</div> سياسة الاشتراكات</h2>
        <p>الأسعار المعروضة على المنصة تشمل جميع الرسوم ما لم يُذكر خلاف ذلك. نحتفظ بحق تغيير الأسعار مع إشعار مسبق.</p>
        <ul>
          <li>تُجدَّد الاشتراكات الدورية تلقائياً ما لم يتم إلغاؤها قبل موعد التجديد.</li>
          <li>يمكن طلب الاسترداد خلال 7 أيام من تاريخ الشراء وفق سياسة الاسترداد.</li>
          <li>في حال إلغاء الاشتراك، يظل الوصول متاحاً حتى نهاية الفترة المدفوعة.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
