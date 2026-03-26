@extends('dashboard.layouts.backend', ['title' => 'إضافة تقييم'])

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.assessments.index') }}">التقييمات</a>
        <span class="sep">/</span>
        <span class="current">إضافة تقييم</span>
    </div>
    <div class="page-header-ds fade-up-ds"><h1>إضافة تقييم</h1></div>
    <a href="{{ route('dashboard.assessments.index') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>

    <form action="{{ route('dashboard.assessments.store') }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        @include('dashboard.assessments.form', ['showQuestionSelector' => true])
    </form>
</div>
@endsection
