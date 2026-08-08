@extends('dashboard.layouts.backend', ['title' => 'تصدير قاعدة البيانات'])

@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/export-database.css') }}">
@endsection

@section('contant')
    <div class="dash-page">
        <div class="page-breadcrumb fade-up-ds">
            <a href="{{ route('dashboard.home') }}">الرئيسية</a>
            <span class="sep">/</span>
            <span class="current">تصدير قاعدة البيانات</span>
        </div>
        <div class="page-header-ds fade-up-ds">
            <h1>تصدير قاعدة البيانات</h1>
        </div>

        @if (!$isMysql)
            <div class="fade-up-ds" style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:12px;padding:14px 16px;font-weight:700">
                هذه الميزة تدعم قواعد بيانات MySQL فقط، وقاعدة البيانات الحالية ليست من نوع MySQL.
            </div>
        @else
            <div class="db-stats-ds fade-up-ds delay-1-ds">
                <div class="db-stat-ds">
                    <div class="label">اسم قاعدة البيانات</div>
                    <div class="value" style="font-size:.95rem">{{ $database }}</div>
                </div>
                <div class="db-stat-ds">
                    <div class="label">عدد الجداول</div>
                    <div class="value">{{ $tables->count() }}</div>
                </div>
                <div class="db-stat-ds">
                    <div class="label">الحجم التقريبي</div>
                    <div class="value">{{ number_format($totalSize / 1048576, 2) }} MB</div>
                </div>
            </div>

            <div class="fade-up-ds delay-1-ds">
                <div class="form-card-ds">
                    <div class="form-card-header-ds">
                        <div class="fch-icon-ds" style="background:#dcfce7">🗄️</div>
                        <div>
                            <h2>نسخة احتياطية كاملة</h2>
                            <p>تصدير كل بيانات وجداول قاعدة البيانات في ملف SQL واحد يمكن استيراده لاحقًا.</p>
                        </div>
                    </div>
                    <div class="form-card-body-ds">
                        <p style="color:var(--muted);font-size:.88rem;margin:0 0 12px">
                            قد تستغرق العملية بعض الوقت حسب حجم البيانات، سيبدأ التحميل تلقائيًا بمجرد اكتمال الملف.
                        </p>
                    </div>
                    <div class="form-card-footer-ds">
                        <a href="{{ route('dashboard.export-database.download') }}" class="btn-ds btn-success-ds">
                            تصدير قاعدة البيانات الآن
                        </a>
                    </div>
                </div>
            </div>

            @if ($tables->isNotEmpty())
                <div class="table-wrap-ds fade-up-ds delay-2-ds" style="margin-top:16px">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الجدول</th>
                                <th>عدد الصفوف (تقريبي)</th>
                                <th>الحجم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tables as $table)
                                <tr>
                                    <td class="td-num-ds">{{ $loop->iteration }}</td>
                                    <td style="font-weight:700">{{ $table->name }}</td>
                                    <td>{{ number_format($table->rows_count ?? 0) }}</td>
                                    <td>{{ number_format(($table->size_bytes ?? 0) / 1024, 1) }} KB</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
@endsection
