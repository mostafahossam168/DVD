@extends('dashboard.layouts.backend', ['title' => $page['title'] ?? 'صفحة ثابتة'])

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" />
@endsection

@section('contant')
<div class="dash-page">
    <div class="page-breadcrumb fade-up-ds">
        <a href="{{ route('dashboard.home') }}">الرئيسية</a>
        <span class="sep">/</span>
        <a href="{{ route('dashboard.home') }}">الإعدادات</a>
        <span class="sep">/</span>
        <span class="current">{{ $page['title'] ?? 'تعديل' }}</span>
    </div>
    <div class="page-header-ds fade-up-ds">
        <h1>{{ $page['title'] ?? 'صفحة ثابتة' }}</h1>
    </div>
    <a href="{{ route('dashboard.home') }}" class="btn-back-ds fade-up-ds">رجوع</a>
    <x-alert-component></x-alert-component>

    <form action="{{ route('dashboard.pages.update', $page['slug']) }}" method="post" class="fade-up-ds delay-1-ds">
        @csrf
        <div class="form-card-ds">
            <div class="form-card-header-ds">
                <div class="fch-icon-ds" style="background:#e0e7ff">📄</div>
                <div>
                    <h2>محتوى الصفحة</h2>
                    <p>يمكنك تنسيق النص (عناوين، ألوان، روابط، صور ...) وسيتم عرضه في واجهة الموقع كما هو.</p>
                </div>
            </div>
            <div class="form-card-body-ds">
                <div class="form-group-ds">
                    <label class="form-label-ds" for="pageContent">محتوى الصفحة</label>
                    <textarea name="content" id="pageContent" rows="12" class="form-control-ds">{{ old('content', $content) }}</textarea>
                </div>
            </div>
            <div class="form-card-footer-ds">
                <button type="submit" class="btn-ds btn-success-ds">حفظ التعديلات</button>
                <a href="{{ route('dashboard.home') }}" class="btn-ds btn-secondary-ds">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#pageContent').summernote({
                height: 350,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['font2', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                placeholder: 'اكتب محتوى الصفحة هنا...',
            });
        });
    </script>
@endpush
