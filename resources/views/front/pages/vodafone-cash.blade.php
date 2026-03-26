@extends('front.layouts.front', ['title' => 'الدفع عبر فودافون كاش'])

@section('content')
    @php
        $numbers = collect(preg_split('/[\r\n,]+/', (string) setting('vodafone_cash_numbers')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values();
        if ($numbers->isEmpty() && setting('vodafone_cash_number')) {
            $numbers = collect([setting('vodafone_cash_number')]);
        }
    @endphp
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
                        <li>
                            حوّل قيمة الاشتراك إلى أحد الأرقام التالية:
                            @if($numbers->isNotEmpty())
                                <ul style="margin-top:8px">
                                    @foreach($numbers as $num)
                                        <li><strong>{{ $num }}</strong></li>
                                    @endforeach
                                </ul>
                            @else
                                <strong>01xxxxxxxxx</strong>
                            @endif
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

