@extends('dashboard.layouts.backend', ['title' => 'تعديل سؤال بنك'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.question-bank.index') }}">أسئلة التقييمات</a>
        <span class="sep">/</span>
        <span class="current">تعديل سؤال</span>
    </div>
    <div class="page-header-ds fade-up-ds"><h1>تعديل سؤال</h1></div>
    <a href="{{ route('dashboard.question-bank.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>

    <form action="{{ route('dashboard.question-bank.update', $item->id) }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        @method('PUT')
        @include('dashboard.question-bank.form', ['item' => $item])
    </form>
</div>
@endsection
