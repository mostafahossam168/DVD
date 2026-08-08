@extends('front.layouts.front', ['title' => 'فاهم — متابعة أبنائي'])

@section('content')
<div class="hero-band hero-courses">
    <div class="hero-inner">
        <div class="hero-eyebrow">👨‍👩‍👧 بوابة ولي الأمر</div>
        <h1>متابعة <em>أبنائك</em></h1>
        <p>تابع تقييمات ومحاضرات أبنائك من مكان واحد.</p>
    </div>
</div>

<div class="page-content courses-page-content" style="padding:32px 5% 80px">
    @if($children->count())
        <div class="courses-grid">
            @foreach($children as $child)
                <a href="{{ route('front.parent.child', $child) }}" class="course-card" style="align-items:flex-start;padding:20px">
                    <div class="d-flex align-items-center gap-3" style="display:flex;align-items:center;gap:12px;width:100%">
                        <div style="width:52px;height:52px;border-radius:50%;background:var(--blue-light,#eff6ff);color:var(--blue,#1a56db);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:1.2rem;flex-shrink:0">
                            {{ mb_substr($child->full_name ?? $child->email, 0, 1) }}
                        </div>
                        <div>
                            <div class="card-title" style="margin-bottom:2px">{{ $child->full_name }}</div>
                            <div class="card-meta">{{ $child->email }}</div>
                        </div>
                    </div>
                    <div class="card-footer" style="margin-top:16px">
                        <span class="btn-card">عرض المتابعة ←</span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state show">
            <div class="empty-icon">👨‍👩‍👧</div>
            <div class="empty-title">لا يوجد أبناء مرتبطين بحسابك بعد</div>
            <div class="empty-sub">تواصل مع إدارة المنصة لربط حساب ابنك بحسابك.</div>
        </div>
    @endif
</div>
@endsection
