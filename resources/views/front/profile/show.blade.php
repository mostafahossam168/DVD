@extends('front.layouts.front', ['title' => 'الملف الشخصي'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">الملف الشخصي</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST" action="{{ route('front.profile.update') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">الاسم الأول</label>
                                    <input type="text" name="f_name" class="form-control"
                                        value="{{ old('f_name', $user->f_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الاسم الأخير</label>
                                    <input type="text" name="l_name" class="form-control"
                                        value="{{ old('l_name', $user->l_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الإيميل</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور الجديدة (اختياري)</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="اتركها فارغة إذا لم ترغب في التغيير">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    حفظ التعديلات
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">معلومات الحساب</h5>
                            <p class="mb-1"><strong>الاسم:</strong> {{ $user->full_name }}</p>
                            <p class="mb-1"><strong>الإيميل:</strong> {{ $user->email }}</p>
                            <p class="mb-1"><strong>الهاتف:</strong> {{ $user->phone }}</p>
                            <p class="mb-1"><strong>الحالة:</strong> {{ $user->status ? 'مفعل' : 'غير مفعل' }}</p>

                            <hr>
                            <a href="{{ route('front.courses.my') }}" class="btn btn-outline-primary btn-sm">
                                الذهاب إلى كورساتي
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

