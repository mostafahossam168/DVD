@extends('front.layouts.front', ['title' => 'الدفع عبر فودافون كاش'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-3">الدفع عبر فودافون كاش</h2>
            <p class="text-muted mb-4">
                يمكنك دفع اشتراك الكورسات عن طريق التحويل على رقم فودافون كاش ثم إدخال بيانات التحويل في صفحة الكورس عند
                الاشتراك.
            </p>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">خطوات الدفع</h5>
                    <ol class="mb-3">
                        <li>افتح فودافون كاش من الموبايل.</li>
                        <li>حوّل قيمة الاشتراك إلى الرقم:
                            <strong>{{ setting('vodafone_cash_number') ?? '01xxxxxxxxx' }}</strong>
                        </li>
                        <li>بعد التحويل، احتفظ برسالة فودافون كاش التي تحتوي على <strong>كود عملية التحويل</strong>.</li>
                        <li>ادخل إلى صفحة الكورس الذي تريد الاشتراك فيه واضغط <strong>اشترك الآن</strong>.</li>
                        <li>اكتب رقم الموبايل الذي حوّلت منه، وكود عملية التحويل في الحقول المطلوبة، ثم اضغط حفظ.</li>
                    </ol>

                    <p class="small text-muted mb-0">
                        بعد مراجعة التحويل من الإدارة، سيتم تفعيل اشتراكك في الكورس، ويمكنك عندها مشاهدة الدروس والاختبارات.
                    </p>
                </div>
            </div>

            <a href="{{ route('front.courses.index') }}" class="btn btn-primary">
                الذهاب إلى الكورسات
            </a>
        </div>
    </section>
@endsection

