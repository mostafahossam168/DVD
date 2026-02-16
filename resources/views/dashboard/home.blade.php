@extends('dashboard.layouts.backend')

@section('contant')
    {{-- <style>
        .box-online {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            /* width: -moz-fit-content; */
            width: fit-content;
            padding: 6px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .box-online .user-holder {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .box-online .user-holder .img-holder {
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }

        .box-online .user-holder .img-holder img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }

        .box-online .user-holder .title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        .box-online .icon-holder i,
        .box-online .icon-holder svg {
            font-size: 11px;
            color: rgb(3, 173, 3);
        }
    </style> --}}
    <div class="main-side">
        <div class="d-flex align-items-center flex-warp gap-4 mb-3">
            <div class="main-title mb-0">
                <div class="small">
                    الرئيسية </div>/
                <div class="large">
                    لوحة التحكم </div>
            </div>
        </div>


        {{-- @endcan --}}
        @can('read_statistics_home')
            <div class="row g-3 mb-2">
                @can('read_admins')
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="box-statistic blue">
                            <div class="right-side">
                                <h6 class="name">المشرفين</h6>
                                <h3 class="amount"><span class="num-stat"
                                        data-goal="{{ \App\Models\User::admins()->count() }}">0</span></h3>
                                <a href="{{ route('dashboard.admins.index') }}" class="link-view">عرض جميع المشرفين</a>
                            </div>
                            <div class="left-side">
                                <p class="status-number down"></i></p>
                                <div class="icon-holder blue">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('read_teachers')
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="box-statistic">
                            <div class="right-side">
                                <h6 class="name">المعلمين</h6>
                                <h3 class="amount"><span class="num-stat"
                                        data-goal="{{ \App\Models\User::teachers()->count() }}">0</span></h3>
                                <a href="{{ route('dashboard.teachers.index') }}" class="link-view">عرض جميع المعلمين</a>
                            </div>
                            <div class="left-side">
                                <p class="status-number up"> </i></p>
                                <div class="icon-holder green">
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('read_students')
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="box-statistic yellow">
                            <div class="right-side">
                                <h6 class="name">الطلاب</h6>
                                <h3 class="amount"><span class="num-stat"
                                        data-goal="{{ \App\Models\User::students()->count() }}">0</span></h3>
                                <a href="{{ route('dashboard.students.index') }}" class="link-view">عرض جميع الطلاب</a>
                            </div>
                            <div class="left-side">
                                <p class="status-number up"> </i></p>
                                <div class="icon-holder green">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('read_stages')
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="box-statistic purple">
                            <div class="right-side">
                                <h6 class="name">المراحل الدراسيه</h6>
                                <h3 class="amount num-stat" data-goal="{{ \App\Models\Stage::count() }}">0</h3>
                                <a href="{{ route('dashboard.stages.index') }}" class="link-view">عرض جميع المراحل الدراسيه</a>
                            </div>
                            <div class="left-side">
                                <p class="status-number up"> </i></p>
                                <div class="icon-holder yellow">
                                    <i class="fa-solid fa-sitemap"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="col-12 col-md-12">
                    <div class="row g-3">
                        {{-- <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header bg-white">
                                    📊 إحصائيات التسجيل في الكورسات </div>
                                <div class="card-body">
                                    <canvas id="enrollmentsChart" height="200"></canvas>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-6">
                            <div class="row g-3">
                                @can('read_subjects')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic green">
                                            <div class="right-side">
                                                <h6 class="name">المواد</h6>
                                                <h3 class="amount"><span class="num-stat"
                                                        data-goal="{{ \App\Models\Subject::count() }}">0</span>
                                                </h3>
                                                <a href="{{ route('dashboard.subjects.index') }}" class="link-view">عرض جميع
                                                    المواد</a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number"></p>
                                                <div class="icon-holder">
                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('read_lectuers')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic ">
                                            <div class="right-side">
                                                <h6 class="name">الدروس</h6>
                                                <h3 class="amount num-stat" data-goal="{{ App\Models\Lecture::count() }}">0</h3>
                                                <a href="{{ route('dashboard.lectuers.index') }}" class="link-view">عرض جميع
                                                    الدروس</a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number up"></p>
                                                <div class="icon-holder blue">
                                                    <i class="fa-solid fa-chalkboard-teacher"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('read_roles')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic yellow">
                                            <div class="right-side">
                                                <h6 class="name">الصلاحيات</h6>
                                                <h3 class="amount num-stat"
                                                    data-goal="{{ Spatie\Permission\Models\Role::count() }}">0
                                                </h3>
                                                <a href="{{ route('dashboard.roles.index') }}" class="link-view">عرض جميع
                                                    الصلاحيات</a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number up"> </p>
                                                <div class="icon-holder green">
                                                    <i class="fa-solid fa-user-shield"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                {{-- @can('read_coupones')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic purple">
                                            <div class="right-side">
                                                <h6 class="name"> العروض</h6>
                                                <h3 class="amount num-stat" data-goal="{{ App\Models\Coupone::count() }}">0
                                                </h3>
                                                <a href="{{ route('dashboard.coupones.index') }}" class="link-view">عرض جميع
                                                    العروض </a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number up"></p>
                                                <div class="icon-holder yellow">
                                                    <i class="fa-solid fa-gift"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan --}}
                                {{-- @can('read_contacts')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic purple">
                                            <div class="right-side">
                                                <h6 class="name"> تواصل معنا</h6>
                                                <h3 class="amount num-stat" data-goal="{{ App\Models\Contact::count() }}">0
                                                </h3>
                                                <a href="{{ route('dashboard.contacts.index') }}" class="link-view">عرض جميع
                                                    الرسائل </a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number up"></p>
                                                <div class="icon-holder yellow">
                                                    <i class="fa-solid fa-comments"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan --}}
                                @can('read_settings')
                                    <div class="col-12 col-md-6">
                                        <div class="box-statistic blue">
                                            <div class="right-side">
                                                <h6 class="name">الاعدادات</h6>
                                                <a href="{{ route('dashboard.settings') }}" class="link-view">عرض
                                                    الاعدادات</a>
                                            </div>
                                            <div class="left-side">
                                                <p class="status-number"> </p>
                                                <div class="icon-holder">
                                                    <i class="fa-solid fa-gear icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
@push('scripts')
    <script>
        if (document.querySelectorAll(".num-stat")) {
            let numStats = document.querySelectorAll(".num-stat");
            let started = false;
            document.addEventListener("DOMContentLoaded", function() {
                numStats.forEach((num) => startCount(num));
            });

            function startCount(el) {
                let goal = el.dataset.goal;
                let duration = 1000; // تحديد المدة الزمنية
                let start = null;

                function updateCount(timestamp) {
                    if (!start) start = timestamp;
                    let progress = timestamp - start;
                    let increment = Math.floor((progress / duration) * goal);
                    el.textContent = increment > goal ? goal : increment;
                    if (progress < duration) {
                        requestAnimationFrame(updateCount);
                    }
                }
                requestAnimationFrame(updateCount);
            }
        }
    </script>
@endpush
{{-- @push('scripts')
    <script>
        if (document.querySelectorAll(".num-stat")) {
            let numStats = document.querySelectorAll(".num-stat");
            let started = false;
            document.addEventListener("DOMContentLoaded", function() {
                numStats.forEach((num) => startCount(num));
            });

            function startCount(el) {
                let goal = el.dataset.goal;
                let duration = 2000; // تحديد المدة الزمنية
                let start = null;

                function updateCount(timestamp) {
                    if (!start) start = timestamp;
                    let progress = timestamp - start;
                    let increment = Math.floor((progress / duration) * goal);
                    el.textContent = increment > goal ? goal : increment;
                    if (progress < duration) {
                        requestAnimationFrame(updateCount);
                    }
                }
                requestAnimationFrame(updateCount);
            }
        }
    </script>

    @php
        $courses = App\Models\Course::withCount('students')->get();

        $labels = $courses->pluck('title'); // أسماء الكورسات
        $data = $courses->pluck('students_count'); // عدد المسجلين
    @endphp
    <script>
        const ctx = document.getElementById('enrollmentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'عدد المسجلين',
                    data: @json($data),
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush --}}
