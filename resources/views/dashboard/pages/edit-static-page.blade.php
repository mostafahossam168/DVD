@extends('dashboard.layouts.backend', ['title' => $page['title'] ?? 'صفحة ثابتة'])

@section('css')
    {{-- محرر نص من نوع Summernote --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" />
@endsection

@section('contant')
    <div class="main-side">
        <form action="{{ route('dashboard.pages.update', $page['slug']) }}" method="post">
            @csrf
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="main-title">
                    <div class="small">
                        الرئيسية / الإعدادات / صفحات الموقع
                    </div>
                    <div class="large">
                        {{ $page['title'] }}
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="main-btn btn-main-color">حفظ التعديلات</button>
                </div>
            </div>

            <x-alert-component></x-alert-component>

            <div class="row g-4">
                <div class="col-12">
                    <label class="special-label" for="pageContent">محتوى الصفحة</label>
                    <textarea name="content" id="pageContent" rows="12" class="form-control">{{ old('content', $content) }}</textarea>
                    <p class="text-muted mt-2" style="font-size: 13px;">
                        يمكنك تنسيق النص (عناوين، ألوان، روابط، صور ...) وسيتم عرضه في واجهة الموقع كما هو.
                    </p>
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
                    // [groupName, [list of button]]
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


