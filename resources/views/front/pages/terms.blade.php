@extends('front.layouts.front', ['title' => $title ?? 'الشروط والأحكام'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">{{ $title }}</h1>
            <div class="static-page-content">
                @php($content = setting('page_terms'))
                @if ($content)
                    {!! $content !!}
                @else
                    <p class="text-muted">يمكنك ضبط محتوى هذه الصفحة من لوحة التحكم &raquo; الإعدادات &raquo; الشروط والأحكام.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
