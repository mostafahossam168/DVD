@extends('front.layouts.front', ['title' => 'تواصل معنا'])
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">

                <!-- معلومات التواصل -->
                <div class="col-lg-4">
                    <h2 class="mb-3">تواصل معنا</h2>
                    <p class="text-muted mb-4">
                        يمكنك التواصل معنا في أي وقت من خلال بيانات الاتصال التالية أو من خلال نموذج التواصل.
                    </p>

                    <div class="mb-3 d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:40px;height:40px;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">البريد الإلكتروني</div>
                            <a href="mailto:support@fahem.com">support@fahem.com</a>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width:40px;height:40px;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">رقم الهاتف</div>
                            <a href="tel:+201000000000">+20 100 000 0000</a>
                        </div>
                    </div>
                </div>

                <!-- فورم التواصل -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-3">أرسل لنا رسالة</h4>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form id="contactForm" method="POST" action="{{ route('front.contact.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">الاسم الكامل</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">رقم التليفون</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">الرسالة</label>
                                        <textarea id="message" name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary custom-btn">
                                            إرسال الرسالة
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
