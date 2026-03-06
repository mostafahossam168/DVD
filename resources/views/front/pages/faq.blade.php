@extends('front.layouts.front', ['title' => $title ?? 'الأسئلة الشائعة'])

@section('content')
<div class="info-page">
  <div class="info-page-hero">
    <div class="hero-inner">
      <div class="hero-tag">مركز المساعدة</div>
      <h1>الأسئلة الشائعة</h1>
      <p class="hero-desc">كل اللي بتسأل عنه موجود هنا. لو ملقتش إجابتك، فريق الدعم موجود دايماً.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 60L1440 60L1440 0C1200 50 900 60 720 40C540 20 240 0 0 30Z" fill="#f0f4ff"/>
    </svg>
  </div>

  <div class="faq-body">
    <div class="faq-cats">
      <button type="button" class="faq-cat active" data-faq-filter="all">الكل</button>
      <button type="button" class="faq-cat" data-faq-filter="account">الحساب</button>
      <button type="button" class="faq-cat" data-faq-filter="payment">الدفع والاشتراك</button>
      <button type="button" class="faq-cat" data-faq-filter="courses">الكورسات</button>
      <button type="button" class="faq-cat" data-faq-filter="tech">مشاكل تقنية</button>
    </div>

    <div class="faq-list">
      <div class="faq-item" data-cat="account">
        <div class="faq-q">
          <div class="faq-num">01</div>
          <div class="faq-q-text">إزاي أعمل حساب جديد على منصة فاهم؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>اضغط على زر "إنشاء حساب" في أعلى الصفحة، ادخل اسمك وبريدك ورقم هاتفك وكلمة مرور قوية، وبعدين اضغط "إنشاء الحساب". هيجيلك تأكيد على بريدك أو برسالة SMS.</p></div>
      </div>
      <div class="faq-item" data-cat="account">
        <div class="faq-q">
          <div class="faq-num">02</div>
          <div class="faq-q-text">نسيت كلمة المرور، إزاي أعيدها؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>في صفحة تسجيل الدخول اضغط "هل نسيت كلمة المرور؟"، ادخل بريدك أو رقم هاتفك، وهتوصلك رسالة بها رابط لإعادة تعيين كلمة المرور صالح لمدة 30 دقيقة.</p></div>
      </div>
      <div class="faq-item" data-cat="payment">
        <div class="faq-q">
          <div class="faq-num">03</div>
          <div class="faq-q-text">إيه طرق الدفع المتاحة على المنصة؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>بنقبل الدفع بكارت الائتمان، فودافون كاش، اورنج موني، وي باي، والدفع عن طريق فوري والمحافظ الإلكترونية. كل المدفوعات مؤمّنة.</p></div>
      </div>
      <div class="faq-item" data-cat="payment">
        <div class="faq-q">
          <div class="faq-num">04</div>
          <div class="faq-q-text">هل في سياسة استرداد المبلغ لو مش راضي عن الكورس؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>أيوه! بنوفر ضمان استرداد المبلغ كامل خلال 7 أيام من تاريخ الشراء. تواصل مع فريق الدعم وهيتم الاسترداد خلال 3-5 أيام عمل.</p></div>
      </div>
      <div class="faq-item" data-cat="courses">
        <div class="faq-q">
          <div class="faq-num">05</div>
          <div class="faq-q-text">هل أقدر أشوف الكورسات من الموبايل؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>أيوه! المنصة متاحة على كل الأجهزة. وعندنا تطبيق للموبايل يديك تجربة أحسن وبيدعم التحميل للمشاهدة أوفلاين.</p></div>
      </div>
      <div class="faq-item" data-cat="courses">
        <div class="faq-q">
          <div class="faq-num">06</div>
          <div class="faq-q-text">لحد إمتى بيفضل الكورس متاح ليّ بعد الشراء؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>بعد شرائك للكورس بيفضل متاح في حسابك طوال السنة الدراسية. وبعض الكورسات بيكون فيها وصول مدى الحياة.</p></div>
      </div>
      <div class="faq-item" data-cat="tech">
        <div class="faq-q">
          <div class="faq-num">07</div>
          <div class="faq-q-text">مش بيشتغل الفيديو صح، إيه الحل؟</div>
          <div class="faq-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg></div>
        </div>
        <div class="faq-a"><p>جرب تحديث الصفحة أو تغيير المتصفح. تأكد إن الإنترنت شغّال كويس. لو المشكلة فضلت قلل جودة الفيديو. لو محلتش تواصل مع الدعم الفني.</p></div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  var items = document.querySelectorAll('.faq-item');
  var cats = document.querySelectorAll('.faq-cat');
  function toggle(el) {
    var open = el.classList.contains('open');
    items.forEach(function(i){ i.classList.remove('open'); });
    if (!open) el.classList.add('open');
  }
  items.forEach(function(item){
    item.querySelector('.faq-q').addEventListener('click', function(){ toggle(item); });
  });
  cats.forEach(function(btn){
    btn.addEventListener('click', function(){
      cats.forEach(function(b){ b.classList.remove('active'); });
      btn.classList.add('active');
      var filter = btn.getAttribute('data-faq-filter');
      items.forEach(function(item){
        item.style.display = (filter === 'all' || item.getAttribute('data-cat') === filter) ? '' : 'none';
      });
    });
  });
})();
</script>
@endsection
