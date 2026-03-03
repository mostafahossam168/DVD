@extends('front.layouts.front', ['title' => 'الرئيسيه'])
@section('content')
    <section class="hero-section py-5">
        <div class="container">
            <div class="row g-4 align-items-center">

                <!-- Left Side - Text Content -->
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
                            <a href="{{ route('front.courses.index') }}"
                                class="btn-hero btn-primary-hero text-decoration-none d-inline-flex align-items-center justify-content-center">
                                استكشف الكورسات
                            </a>
                            <a href="{{ route('front.register') }}"
                                class="btn-hero btn-secondary-hero text-decoration-none d-inline-flex align-items-center justify-content-center">
                                ابدأ الانضمام
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Middle Side - Info Card -->
                <div class="col-lg-3 order-lg-3">
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
                            <span class="tag badge  me-1">طبيعي</span>
                            <span class="tag badge  me-1">يومية</span>
                            <span class="tag badge ">انجل</span>
                        </div>
                        <p class="info-footer text-muted small">
                            لو بتكتشف بين المداخيلو والمهاراته، عندنا الشوز!
                        </p>
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="col-lg-4 order-2 order-lg-2 text-center">
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=416&h=600&fit=crop"
                            alt="Students Learning" class="img-fluid rounded">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="paths-section">
        <div class="container">
            <h2 class="section-title">حدد مسارك التعليمي !</h2>

            <div class="row g-3 justify-content-center">

                <!-- الاعدادية -->
                <div class="col-lg-4 col-md-6">
                    <div class="path-card">
                        <div class="path-image">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=500&h=350&fit=crop">
                            <div class="path-overlay">
                                <h3 class="path-title">المرحلة الإعدادية</h3>
                                <p class="path-subtitle">عربي / لغات</p>
                                <button class="btn-path">
                                    <i class="fa-solid fa-book"></i>
                                    احجز مكانك دلوقتي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الثانوية -->
                <div class="col-lg-4 col-md-6">
                    <div class="path-card">
                        <div class="path-image">
                            <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=500&h=350&fit=crop">
                            <div class="path-overlay">
                                <h3 class="path-title">المرحلة الثانوية</h3>
                                <p class="path-subtitle">عربي / لغات</p>
                                <button class="btn-path">
                                    <i class="fa-solid fa-book"></i>
                                    احجز مكانك دلوقتي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- البكالوريا (مميزة) -->
                <div class="col-lg-4 col-md-6">
                    <div class="path-card bak-card">

                        <div class="path-image">
                            <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?w=500&h=350&fit=crop">
                            <div class="path-overlay">
                                <h3 class="path-title">البكالوريا</h3>
                                <p class="path-subtitle">عربي / لغات</p>
                                <button class="btn-path">
                                    <i class="fa-solid fa-book"></i>
                                    احجز مكانك دلوقتي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== Experts Section ===== -->
    <section class="experts-section py-5 bg-light">
        <div class="container">

            <!-- العنوان -->
            <h2 class="text-center mb-2" style="font-size:36px; font-weight:700;">
                تعرف على خبرائنا
            </h2>
            <p class="text-center mb-5" style="font-size:16px; color:#555;">
                كل مدرب متخصص في مجاله، مع خبرة حقيقية وتطبيق عملي لكل درس.
            </p>

            <div class="row g-3 justify-content-center">

                <!-- كارد 1 -->
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card text-center" style="width:250px; height:250px; padding:15px;">
                        <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e?w=200&h=200&fit=crop"
                            class="rounded-circle mx-auto" style="width:80px; height:80px; object-fit:cover;"
                            alt="خبير">
                        <div class="card-body p-2">
                            <h5 class="mb-1">د. أحمد علي</h5>
                            <p class="mb-1" style="font-size:14px;">مدرس رياضيات</p>
                            <p class="mb-0" style="font-size:12px; color:#555;">خبرة أكثر من 10 سنين</p>
                        </div>
                    </div>
                </div>

                <!-- كارد 2 -->
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card text-center" style="width:250px; height:250px; padding:15px;">
                        <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?w=200&h=200&fit=crop"
                            class="rounded-circle mx-auto" style="width:80px; height:80px; object-fit:cover;"
                            alt="خبير">
                        <div class="card-body p-2">
                            <h5 class="mb-1">د. سارة محمود</h5>
                            <p class="mb-1" style="font-size:14px;">علوم</p>
                            <p class="mb-0" style="font-size:12px; color:#555;">خبرة في التعليم التفاعلي</p>
                        </div>
                    </div>
                </div>

                <!-- كارد 3 -->
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card text-center" style="width:250px; height:250px; padding:15px;">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop"
                            class="rounded-circle mx-auto" style="width:80px; height:80px; object-fit:cover;"
                            alt="خبير">
                        <div class="card-body p-2">
                            <h5 class="mb-1">د. منى خالد</h5>
                            <p class="mb-1" style="font-size:14px;">لغة عربية</p>
                            <p class="mb-0" style="font-size:12px; color:#555;">خبرة طويلة في التدريس</p>
                        </div>
                    </div>
                </div>

                <!-- كارد 4 -->
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card text-center" style="width:250px; height:250px; padding:15px;">
                        <img src="https://images.unsplash.com/photo-1595152772835-219674b2a8a6?w=200&h=200&fit=crop"
                            class="rounded-circle mx-auto" style="width:80px; height:80px; object-fit:cover;"
                            alt="خبير">
                        <div class="card-body p-2">
                            <h5 class="mb-1">محمود قاسم</h5>
                            <p class="mb-1" style="font-size:14px;">مدرس رياضيات</p>
                            <p class="mb-0" style="font-size:12px; color:#555;">خبرة أكثر من 10 سنين</p>
                        </div>
                    </div>
                </div>

                <!-- كارد 5 -->
                <div class="col-lg-2 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card text-center" style="width:250px; height:250px; padding:15px;">
                        <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&h=200&fit=crop"
                            class="rounded-circle mx-auto" style="width:80px; height:80px; object-fit:cover;"
                            alt="خبير">
                        <div class="card-body p-2">
                            <h5 class="mb-1">يوسف خالد</h5>
                            <p class="mb-1" style="font-size:14px;">فيزياء</p>
                            <p class="mb-0" style="font-size:12px; color:#555;">شرح مبسط وتطبيقي</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== Testimonials Section ===== -->
    <section class="py-5" style="background-color:#3B81B7;">
        <div class="container">

            <!-- العنوان -->
            <h2 class="text-center text-white mb-2">
                ماذا يقول طلابنا!
            </h2>

            <p class="text-center text-white mb-4">
                آراء طلاب جرّبوا، اتعلموا، وحققوا فرق حقيقي
            </p>

            <div class="row g-3">
                @forelse ($reviews ?? [] as $review)
                    <div class="col-lg-4 col-md-6">
                        <div class="bg-white p-3 rounded h-100">
                            <div class="d-flex align-items-start gap-3 text-start">
                                @if($review->image)
                                    <img src="{{ display_file($review->image) }}" class="rounded-circle" style="width:80px; height:80px; object-fit:cover;" alt="{{ $review->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=200&h=200&fit=crop"
                                        class="rounded-circle" style="width:80px; height:80px; object-fit:cover;" alt="{{ $review->name }}">
                                @endif
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>{{ $review->name }}</strong>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="fw-bold">{{ $review->rating }}</span>
                                            <span style="color:#FFA500;">★</span>
                                        </div>
                                    </div>
                                    @if($review->subject_field || $review->subject)
                                        <p class="mb-1">{{ $review->subject_field ?? $review->subject?->name }}</p>
                                    @endif
                                    <p class="mb-2">{{ $review->review_text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-white text-center">لا توجد تقييمات حالياً</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- ===== Stats Section ===== -->
    <section class="py-5" style="margin-top:80px; background: linear-gradient(90deg, #3B81B7, #FFD166);">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center text-center flex-wrap flex-md-nowrap">

                <!-- عنصر 1 -->
                <div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">طالب</div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">+1000</div>
                </div>

                <!-- فاصل -->
                <div style="width:2px; height:100px; background:#fff;"></div>

                <!-- عنصر 2 -->
                <div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">دورة تدريبية</div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">+1500</div>
                </div>

                <!-- فاصل -->
                <div style="width:2px; height:100px; background:#fff;"></div>

                <!-- عنصر 3 -->
                <div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">تقييمات إيجابية</div>
                    <div style="font-size:48px; font-weight:400; color:#fff;">+95%</div>
                </div>

            </div>

        </div>
    </section>

    <!-- ===== CTA Section ===== -->
    <section class="py-5 text-center">
        <div class="container">

            <h2 style="font-size:32px; font-weight:700; margin-bottom:12px;">
                ابدأ رحلتك التعليمية الآن!
            </h2>

            <p style="font-size:18px; line-height:1.8; color:#555; margin-bottom:32px;">
                تعلّم بأسلوب حديث يواكب احتياجات الجيل الجديد<br>
                ويجمع بين الدراسة الأكاديمية وتنمية المهارات.
            </p>

            <button
                style="width:100px; height:48px; background-color:#3B81B7; color:#fff; border:none; border-radius:12px; font-size:18px; font-weight:600; cursor:pointer;">
                سجل الآن
            </button>

        </div>
    </section>
@endsection
