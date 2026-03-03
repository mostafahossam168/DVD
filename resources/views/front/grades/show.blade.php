@extends('front.layouts.front', ['title' => 'المواد الدراسية'])

@section('content')
    <section class="py-5 grades-page">
        <div class="container">
            {{-- Breadcrumbs --}}
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('front.stages.index') }}">المراحل الدراسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('front.stages.show', $grade->stage) }}">{{ $grade->stage->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">المواد الدراسية</li>
                </ol>
            </nav>

            <h2 class="mb-4 text-center">المواد الدراسية</h2>

            <div class="row g-3">
                @forelse ($grade->subjects as $subject)
                    <div class="col-md-6 col-lg-4 position-relative">
                        <a href="{{ route('front.courses.subject', $subject) }}" class="subject-list-card card shadow-sm text-decoration-none h-100 overflow-hidden">
                            <div class="favorite-btn-wrap position-absolute top-0 end-0 m-2">
                                @include('front.components.favorite-btn', ['subject' => $subject, 'isFavorite' => in_array($subject->id, $favoriteSubjectIds ?? [])])
                            </div>
                            <div class="card-body d-flex align-items-center p-3">
                                <div class="subject-card-img-wrap flex-shrink-0 me-3">
                                    @if ($subject->image)
                                        <img src="{{ display_file($subject->image) }}" alt="{{ $subject->name }}" class="subject-card-img">
                                    @else
                                        <div class="subject-card-img-placeholder">
                                            <i class="fa-solid fa-book text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <h5 class="card-title mb-0">{{ $subject->name }}</h5>
                                    @auth
                                        @if (in_array($subject->id, $subscribedSubjectIds ?? []))
                                            <span class="badge bg-success mt-1">مشترك</span>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مواد لهذا الصف حالياً.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
