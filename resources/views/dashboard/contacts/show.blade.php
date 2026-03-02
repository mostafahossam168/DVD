@extends('dashboard.layouts.backend', ['title' => 'عرض رسالة تواصل'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="small">رسائل تواصل معنا</div>/
            <div class="large">عرض رسالة</div>
        </div>

        <x-alert-component></x-alert-component>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">بيانات المرسل</h5>
                <p><strong>الاسم:</strong> {{ $contact->name }}</p>
                <p><strong>الهاتف:</strong> {{ $contact->phone }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ $contact->email }}</p>
                <p><strong>تاريخ الإرسال:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</p>

                <hr>
                <h5 class="card-title mb-3">الرسالة</h5>
                <p>{{ $contact->message }}</p>

                <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-secondary mt-3">رجوع لكل الرسائل</a>
            </div>
        </div>
    </div>
@endsection

