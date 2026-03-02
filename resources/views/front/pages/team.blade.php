@extends('front.layouts.front', ['title' => $title ?? 'فريق العمل'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h1 class="mb-4">{{ $title }}</h1>
            <div class="static-page-content">
                @php($content = setting('page_team'))
                @if ($content)
                    {!! $content !!}
                @else
                    <p class="text-muted">يمكنك ضبط محتوى هذه الصفحة من لوحة التحكم &raquo; الإعدادات &raquo; فريق العمل.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
