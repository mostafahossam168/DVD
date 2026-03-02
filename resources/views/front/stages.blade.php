@extends('front.layouts.front', ['title' => 'المراحل الدراسية'])

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">المراحل الدراسية</h2>
            <div class="row g-3">
                @forelse ($stages ?? [] as $stage)
                    <div class="col-md-6 col-lg-4" id="stage-{{ $stage->id }}">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $stage->name }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مراحل دراسية حالياً.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
