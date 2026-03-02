@extends('front.layouts.front', ['title' => $title ?? 'سياسة الخصوصية'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">{{ $title }}</h1>
            <div class="static-page-content">
                @php($content = setting('page_privacy'))
                @if ($content)
                    {!! $content !!}
                @else
                    <p class="text-muted">يمكنك ضبط محتوى هذه الصفحة من لوحة التحكم &raquo; الإعدادات &raquo; سياسة الخصوصية.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
