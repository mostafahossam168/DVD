@extends('front.layouts.front', ['title' => 'فاهم — منصة التعليم الذكي'])
@section('content')
    <div class="home-nextlevel">
        <style>
            .home-nextlevel .container {
                margin-left: auto !important;
                margin-right: auto !important;
                padding-left: 12px;
                padding-right: 12px
            }

            .home-nextlevel .teachers-section {
                margin-left: auto !important;
                margin-right: auto !important;
                max-width: 1200px
            }

            .home-nextlevel .teachers-section .container {
                margin-left: auto !important;
                margin-right: auto !important
            }

            .home-nextlevel .teachers-grid {
                margin-left: auto;
                margin-right: auto;
                max-width: 1100px
            }

            .home-nextlevel .section-title {
                font-size: 36px !important;
                font-weight: 700 !important;
                color: #1e293b !important;
                text-align: center !important;
                margin-bottom: 48px !important
            }

            .home-nextlevel .btn-hero {
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center
            }

            .experts-section-title {
                font-size: 36px;
                font-weight: 700;
                text-align: center;
                margin-bottom: 8px;
                color: #1e293b
            }

            .experts-section-sub {
                font-size: 16px;
                color: #555;
                text-align: center;
                margin-bottom: 2rem
            }

            .experts-section .row > [class*="col-"] {
                margin-bottom: 1.5rem;
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
            .testimonials-section .row > [class*="col-"] {
                margin-bottom: 1.5rem;
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
            .expert-card {
                width: 250px;
                min-height: 250px;
                padding: 15px;
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
                transition: transform .3s, box-shadow .3s
            }

            .expert-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, .12)
            }

            .expert-avatar {
                width: 80px;
                height: 80px;
                object-fit: cover
            }

            .expert-spec {
                font-size: 14px;
                color: #333
            }

            .expert-desc {
                font-size: 12px;
                color: #555
            }

            .testimonials-section {
                background-color: #3E83C9
            }

            .testimonials-title {
                text-align: center;
                color: #fff;
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 8px
            }

            .testimonials-sub {
                text-align: center;
                color: #fff;
                margin-bottom: 2rem
            }

            .testimonial-card {
                box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
                transition: transform .3s
            }

            .testimonial-card:hover {
                transform: translateY(-3px)
            }

            .testimonial-avatar {
                width: 80px;
                height: 80px;
                object-fit: cover
            }

            .testimonial-rating .star {
                color: #FFA500
            }

            .stats-section {
                margin-top: 80px;
                background: linear-gradient(90deg, #3E83C9 0%, #5ba3d4 50%, #FFD166 100%)
            }

            .stats-inner {
                gap: 1rem
            }

            .stat-item {
                flex: 1;
                min-width: 120px
            }

            .stat-item .stat-label {
                font-size: 28px;
                font-weight: 400;
                color: #fff
            }

            .stat-item .stat-value {
                font-size: 42px;
                font-weight: 700;
                color: #fff
            }

            .stat-divider {
                width: 2px;
                min-height: 80px;
                background: #fff
            }

            .cta-title {
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 12px;
                color: #1e293b
            }

            .cta-sub {
                font-size: 18px;
                line-height: 1.8;
                color: #555;
                margin-bottom: 32px
            }

            .btn-cta {
                min-width: 140px;
                height: 48px;
                background-color: #3E83C9;
                color: #fff !important;
                border: none;
                border-radius: 12px;
                font-size: 18px;
                font-weight: 600;
                padding: 0 32px;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all .3s
            }

            .btn-cta:hover {
                background-color: #3270b3 !important;
                color: #fff !important;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(62, 131, 201, .35)
            }

            .home-nextlevel .hero-section {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
                padding: 80px 0 60px !important
            }

            .home-nextlevel .hero-title {
                font-size: 48px !important;
                font-weight: 700 !important;
                color: #1e293b !important
            }

            .home-nextlevel .hero-title .highlight {
                color: #F59E0B !important
            }

            .home-nextlevel .hero-description {
                font-size: 18px !important;
                color: #64748b !important
            }

            .home-nextlevel .paths-section {
                background-color: #fff !important;
                padding: 40px 0 80px !important
            }

            .home-nextlevel .hero-image img {
                border-radius: 20px;
                box-shadow: 0 20px 50px rgba(0, 0, 0, .15)
            }

            .home-nextlevel .path-card {
                color: inherit;
                border-radius: 20px !important;
                height: 350px !important;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
                transition: transform .3s, box-shadow .3s
            }

            .home-nextlevel .path-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, .15)
            }

            .home-nextlevel .path-image {
                position: relative;
                height: 100%;
                display: block
            }

            .home-nextlevel .path-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block
            }

            .home-nextlevel .path-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(to top, rgba(0, 0, 0, .85) 0%, transparent 100%);
                padding: 28px 24px;
                text-align: right;
                color: #fff
            }

            .home-nextlevel .path-title {
                font-size: 22px !important;
                font-weight: 700 !important;
                color: #fff !important;
                margin: 0 0 6px 0 !important;
                line-height: 1.3
            }

            .home-nextlevel .path-subtitle {
                font-size: 14px !important;
                color: rgba(255, 255, 255, .9) !important;
                margin: 0 0 16px 0 !important
            }

            .home-nextlevel .btn-path {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px;
                width: 100%;
                background-color: #3E83C9 !important;
                color: #fff !important;
                border: none;
                padding: 12px 20px;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                text-decoration: none
            }

            @media(max-width:991px) {
                .home-nextlevel .hero-text {
                    text-align: center;
                    padding: 0
                }

                .home-nextlevel .hero-buttons {
                    justify-content: center
                }

                .home-nextlevel .hero-image {
                    padding: 0;
                    margin-top: 24px;
                    text-align: center
                }

                .home-nextlevel .hero-image img {
                    width: 100%;
                    max-width: 416px;
                    height: auto
                }

                .experts-section-title {
                    font-size: 28px
                }

                .stat-item .stat-label {
                    font-size: 22px
                }

                .stat-item .stat-value {
                    font-size: 32px
                }
            }

            @media(max-width:768px) {
                .stats-inner {
                    flex-direction: column;
                    gap: 1.5rem
                }

                .stat-divider {
                    width: 80%;
                    min-height: 2px
                }

                .section-title {
                    font-size: 28px
                }
            }

            @media(max-width:576px) {
                .expert-card {
                    width: 100%;
                    max-width: 280px
                }

                .home-nextlevel .hero-title {
                    font-size: 28px
                }

                .home-nextlevel .hero-buttons {
                    flex-direction: column
                }

                .home-nextlevel .btn-hero {
                    width: 100%
                }
            }
        </style>
        <!-- ===== Hero Section ===== -->
        <section class="hero-section py-5">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5 order-1 order-lg-1">
                        <div class="hero-text">
                            <h1 class="hero-title">
                                من أول خطوة...
                                <br>
                                طريق <span class="highlight">نجاحك</span> الدراسي
                                <br>
                                يبدأ معانا
                            </h1>
                            <p class="hero-description">
                                منصة تعليمية متكاملة لطلاب الإعدادي والثانوي،<br>
                                كورسات منظمة، مدرسين متخصصين،<br>
                                وحصص مباشرة
                            </p>
                            <div class="hero-buttons mt-3">
                                <a href="{{ route('front.register') }}" class="btn-hero btn-secondary-hero">ابدأ
                                    الانضمام</a>
                                <a href="{{ route('front.courses.index') }}" class="btn-hero btn-primary-hero">استكشف
                                    الكورسات</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 order-3 order-lg-3">
                        <div class="info-card p-3 shadow-sm rounded">
                            <div class="info-icon mb-2" style="font-size: 2rem;">🎓</div>
                            <h3 class="info-title mb-2">انضم لـ 5000+ طالب</h3>
                            <p class="info-description mb-2">
                                يدوروا لنفسهم بكرة،<br>
                                متين حدود مداخيلو، في رحلة<br>
                                للاكتشاف، مواهبته وتحدياته<br>
                                الي دكتى
                            </p>
                            <div class="info-tags mb-2">
                                <span class="tag badge me-1">طبيعي</span>
                                <span class="tag badge me-1">يومية</span>
                                <span class="tag badge">انجل</span>
                            </div>
                            <p class="info-footer text-muted small mb-0">
                                لو بتكتشف بين المداخيلو والمهاراته، عندنا الشور!
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 order-2 order-lg-2 text-center">
                        <div class="hero-image">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=416&h=600&fit=crop"
                                alt="طلاب يتعلمون" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== المسارات التعليمية ===== -->
        <section class="paths-section">
            <div class="container">
                <h2 class="section-title">حدد مسارك التعليمي !</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('front.subjects.index', ['stage' => 'اعدادي']) }}" class="path-card text-decoration-none d-block">
                            <div class="path-image">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=500&h=350&fit=crop"
                                    alt="المرحلة الإعدادية">
                                <div class="path-overlay">
                                    <h3 class="path-title">المرحلة الإعدادية</h3>
                                    <p class="path-subtitle">عربي / لغات</p>
                                    <span class="btn-path"><i class="fa-solid fa-calendar-check"></i> احجز مكانك
                                        دلوقتي</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('front.subjects.index', ['stage' => 'ثانوي']) }}" class="path-card text-decoration-none d-block">
                            <div class="path-image">
                                <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=500&h=350&fit=crop"
                                    alt="المرحلة الثانوية">
                                <div class="path-overlay">
                                    <h3 class="path-title">المرحلة الثانوية</h3>
                                    <p class="path-subtitle">عربي / لغات</p>
                                    <span class="btn-path"><i class="fa-solid fa-calendar-check"></i> احجز مكانك
                                        دلوقتي</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('front.subjects.index', ['stage' => 'بكالوريا']) }}"
                            class="path-card bak-card text-decoration-none d-block">
                            <div class="path-image">
                                <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?w=500&h=350&fit=crop"
                                    alt="البكالوريا">
                                <div class="path-overlay">
                                    <h3 class="path-title">البكالوريا</h3>
                                    <p class="path-subtitle">عربي / لغات</p>
                                    <span class="btn-path"><i class="fa-solid fa-calendar-check"></i> احجز مكانك
                                        دلوقتي</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== أفضل المدرسين ===== -->
        <section class="teachers-section py-5" style="background:#f9fafb;">
            <div class="container">
                <h2 class="section-title">أفضل المدرسين</h2>
                <div class="teachers-grid">
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop"
                            alt="محمد اسماعيل" class="teacher-image">
                        <h3 class="teacher-name">محمد اسماعيل</h3>
                        <p class="teacher-subject">مدرس علوم</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop"
                            alt="مي الهادي" class="teacher-image">
                        <h3 class="teacher-name">مي الهادي</h3>
                        <p class="teacher-subject">مدرسة لغة انجليزية</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop"
                            alt="محمود قاسم" class="teacher-image">
                        <h3 class="teacher-name">محمود قاسم</h3>
                        <p class="teacher-subject">مدرس رياضيات</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop"
                            alt="محمد اسماعيل" class="teacher-image">
                        <h3 class="teacher-name">محمد اسماعيل</h3>
                        <p class="teacher-subject">مدرس علوم</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop"
                            alt="مي الهادي" class="teacher-image">
                        <h3 class="teacher-name">مي الهادي</h3>
                        <p class="teacher-subject">مدرسة لغة انجليزية</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                    <div class="teacher-card">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=300&fit=crop"
                            alt="محمود قاسم" class="teacher-image">
                        <h3 class="teacher-name">محمود قاسم</h3>
                        <p class="teacher-subject">مدرس رياضيات</p>
                        <p class="teacher-description">خبرة أكثر من 10 سنوات في التدريس، الأسلوب العلمي المبسط، شرح الأفكار
                            الصعبة</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== الخبراء (استاتيك) ===== -->
        <section class="experts-section py-5 bg-light">
            <div class="container">
                <h2 class="experts-section-title">تعرف على خبرائنا</h2>
                <p class="experts-section-sub">كل مدرب متخصص في مجاله، مع خبرة حقيقية وتطبيق عملي لكل درس.</p>
                <div class="row g-5 justify-content-center">
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="expert-card card text-center">
                            <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=200&h=200&fit=crop"
                                class="rounded-circle mx-auto expert-avatar" alt="خبير">
                            <div class="card-body p-2">
                                <h5 class="mb-1">د. أحمد علي</h5>
                                <p class="mb-1 expert-spec">مدرس رياضيات</p>
                                <p class="mb-0 expert-desc">خبرة أكثر من 10 سنين</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="expert-card card text-center">
                            <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?w=200&h=200&fit=crop"
                                class="rounded-circle mx-auto expert-avatar" alt="خبير">
                            <div class="card-body p-2">
                                <h5 class="mb-1">د. سارة محمود</h5>
                                <p class="mb-1 expert-spec">علوم</p>
                                <p class="mb-0 expert-desc">خبرة في التعليم التفاعلي</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="expert-card card text-center">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop"
                                class="rounded-circle mx-auto expert-avatar" alt="خبير">
                            <div class="card-body p-2">
                                <h5 class="mb-1">د. منى خالد</h5>
                                <p class="mb-1 expert-spec">لغة عربية</p>
                                <p class="mb-0 expert-desc">خبرة طويلة في التدريس</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="expert-card card text-center">
                            <img src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?w=200&h=200&fit=crop"
                                class="rounded-circle mx-auto expert-avatar" alt="خبير">
                            <div class="card-body p-2">
                                <h5 class="mb-1">محمود قاسم</h5>
                                <p class="mb-1 expert-spec">مدرس رياضيات</p>
                                <p class="mb-0 expert-desc">خبرة أكثر من 10 سنين</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="expert-card card text-center">
                            <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&h=200&fit=crop"
                                class="rounded-circle mx-auto expert-avatar" alt="خبير">
                            <div class="card-body p-2">
                                <h5 class="mb-1">يوسف خالد</h5>
                                <p class="mb-1 expert-spec">فيزياء</p>
                                <p class="mb-0 expert-desc">شرح مبسط وتطبيقي</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== آراء الطلاب (استاتيك) ===== -->
        <section class="testimonials-section py-5">
            <div class="container">
                <h2 class="testimonials-title">ماذا يقول طلابنا!</h2>
                <p class="testimonials-sub">آراء طلاب جرّبوا، اتعلموا، وحققوا فرق حقيقي</p>
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="testimonial-card bg-white p-3 rounded h-100">
                            <div class="d-flex align-items-start gap-3 text-start">
                                <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=200&h=200&fit=crop"
                                    class="rounded-circle testimonial-avatar" alt="طالب">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>أحمد محمد</strong>
                                        <span class="testimonial-rating"><span class="fw-bold">4.6</span> <span
                                                class="star">★</span></span>
                                    </div>
                                    <p class="mb-1 text-muted small">فيزياء</p>
                                    <p class="mb-0">المنصة فرقت معايا جدًا، الشرح بسيط ومفهوم وحسيت بتقدم حقيقي.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="testimonial-card bg-white p-3 rounded h-100">
                            <div class="d-flex align-items-start gap-3 text-start">
                                <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&h=200&fit=crop"
                                    class="rounded-circle testimonial-avatar" alt="طالب">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>مريم علي</strong>
                                        <span class="testimonial-rating"><span class="fw-bold">4.8</span> <span
                                                class="star">★</span></span>
                                    </div>
                                    <p class="mb-1 text-muted small">رياضيات</p>
                                    <p class="mb-0">المتابعة ممتازة والشرح منظم، حسيت إن مستوايا اتحسن فعلًا.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="testimonial-card bg-white p-3 rounded h-100">
                            <div class="d-flex align-items-start gap-3 text-start">
                                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop"
                                    class="rounded-circle testimonial-avatar" alt="طالب">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>يوسف خالد</strong>
                                        <span class="testimonial-rating"><span class="fw-bold">4.7</span> <span
                                                class="star">★</span></span>
                                    </div>
                                    <p class="mb-1 text-muted small">كيمياء</p>
                                    <p class="mb-0">أول مرة أفهم المادة بالطريقة دي، تجربة مختلفة فعلًا.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== الإحصائيات (استاتيك) ===== -->
        <section class="stats-section py-5">
            <div class="container">
                <div
                    class="d-flex justify-content-between align-items-center text-center flex-wrap flex-md-nowrap stats-inner">
                    <div class="stat-item">
                        <div class="stat-label">طالب</div>
                        <div class="stat-value">+1000</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-label">دورة تدريبية</div>
                        <div class="stat-value">+1500</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-label">تقييمات إيجابية</div>
                        <div class="stat-value">+95%</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CTA ===== -->
        <section class="cta-section py-5 text-center">
            <div class="container">
                <h2 class="cta-title">ابدأ رحلتك التعليمية الآن!</h2>
                <p class="cta-sub">تعلّم بأسلوب حديث يواكب احتياجات الجيل الجديد ويجمع بين الدراسة الأكاديمية وتنمية
                    المهارات.</p>
                <a href="{{ route('front.register') }}" class="btn btn-cta">سجل الآن</a>
            </div>
        </section>
    </div>
@endsection
