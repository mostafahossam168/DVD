<footer class="site-footer">
    <div class="footer-wave">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,0 L0,0 Z" fill="#F8FAFC" />
        </svg>
    </div>

    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand">
                <a href="{{ route('front.home') }}" class="footer-logo d-flex align-items-center text-decoration-none">
                    <div class="footer-logo-mark">ف</div>
                    <div>
                        <div class="footer-logo-name">فاهم</div>
                        <div class="footer-logo-sub">منصة فاهم للتعليم</div>
                    </div>
                </a>
                <p class="footer-tagline">نساعد الطلاب على التفوق من خلال كورسات تفاعلية عالية الجودة لجميع المراحل
                    الدراسية.</p>
                <div class="social-row">
                    <a href="#" class="social-btn facebook" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                        </svg>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="social-btn instagram" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none" />
                        </svg>
                        <span>Instagram</span>
                    </a>
                    <a href="#" class="social-btn whatsapp" aria-label="WhatsApp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">المراحل الدراسية</div>
                <ul class="footer-links">
                    <li><a href="{{ route('front.stages.index') }}">جميع المراحل</a></li>
                    @foreach ($navbarStages ?? [] as $stage)
                        <li><a href="{{ route('front.stages.show', $stage) }}">{{ $stage->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">المواد الدراسية</div>
                <ul class="footer-links">
                    <li><a href="{{ route('front.subjects.index') }}">جميع المواد</a></li>
                    @foreach ($navbarSubjects ?? [] as $subject)
                        <li><a
                                href="{{ route('front.subjects.index') }}#subject-{{ $subject->id }}">{{ $subject->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">روابط مهمة</div>
                <ul class="footer-links">
                    <li><a href="{{ route('front.home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('front.page.about') }}">من نحن</a></li>
                    <li><a href="{{ route('front.courses.index') }}">جميع الكورسات</a></li>
                    <li><a href="{{ route('front.page.faq') }}">الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('front.register') }}">إنشاء حساب</a></li>
                    <li><a href="{{ route('front.login') }}">تسجيل الدخول</a></li>
                    <li><a href="{{ route('front.contact') }}">تواصل معنا</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-newsletter">
            <div class="newsletter-text">
                <div class="newsletter-title">📬 اشترك في نشرتنا البريدية</div>
                <div class="newsletter-sub">احصل على أحدث الكورسات والعروض مباشرة في بريدك</div>
            </div>
            <div class="newsletter-form">
                <input type="email" placeholder="أدخل بريدك الإلكتروني..." class="newsletter-input"
                    aria-label="البريد الإلكتروني" />
                <button type="button" class="newsletter-btn">اشترك الآن</button>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copy">© {{ date('Y') }} فاهم — جميع الحقوق محفوظة</div>
            <div class="footer-bottom-links">
                <a href="{{ route('front.page.privacy') }}">سياسة الخصوصية</a>
                <span class="footer-dot">·</span>
                <a href="{{ route('front.page.terms') }}">الشروط والأحكام</a>
                <span class="footer-dot">·</span>
                <a href="{{ route('front.page.support') }}">الدعم الفني</a>
            </div>
            <div class="footer-made">صُنع بـ ❤️ لكل طالب مجتهد</div>
        </div>
    </div>
</footer>
