<footer class="pt-5" style="background-color:#1B2A49; color:#fff; position:relative; z-index:10;">
    <div class="container">

        <div class="row text-start g-4">

            <!-- القسم الأول: روابط سريعة -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h5 class="fw mb-3">الروابط السريعة</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('front.page.about') }}">عن المنصة</a></li>
                    <li><a href="{{ route('front.page.vision') }}">رؤيتنا</a></li>
                    <li><a href="{{ route('front.page.team') }}">فريق العمل</a></li>
                    <li><a href="{{ route('front.page.faq') }}">الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('front.contact') }}">تواصل معنا</a></li>
                </ul>
            </div>

            <!-- القسم الثاني: التعلم -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h5 class="fw mb-3">التعلّم</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">دروس إعدادي</a></li>
                    <li><a href="#">دروس ثانوي</a></li>
                    <li><a href="#">كورسات البرمجة والذكاء الاصطناعي</a></li>
                    <li><a href="#">كورسات لغات</a></li>
                    <li><a href="#">المسارات التعليمية</a></li>
                </ul>
            </div>

            <!-- القسم الثالث: الدعم -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h5 class="fw mb-3">الدعم</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('front.page.privacy') }}">سياسة الخصوصية</a></li>
                    <li><a href="{{ route('front.page.terms') }}">الشروط والأحكام</a></li>
                    <li><a href="{{ route('front.page.usage') }}">سياسة الاستخدام</a></li>
                    <li><a href="{{ route('front.contact') }}">الدعم الفني</a></li>
                    <li><a href="{{ route('front.contact') }}">الإبلاغ عن مشكلة</a></li>
                </ul>
            </div>

            <!-- القسم الرابع: الاشتراك -->
            <div class="col-lg-3 col-md-6 footer-col">
                <h5 class="fw-bold mb-3">للإشتراك في منصتنا</h5>
                <div class="d-flex mb-2">
                    <input type="email" class="form-control me-2" placeholder="ادخل بريدك الإلكتروني">
                    <button class="btn btn-warning subscribe-btn">اشترك</button>
                </div>

                <!-- Social Icons -->
                <div class="d-flex gap-2 mt-3 social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>

        <!-- خط سفلي -->
        <hr class="footer-divider">

        <!-- حقوق الملكية -->
        <div class="text-center pb-3" style="font-size:14px;">
            &copy; 2026 NextLevel. جميع الحقوق محفوظة.
        </div>

    </div>
</footer>
