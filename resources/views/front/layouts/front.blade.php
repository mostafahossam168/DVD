<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'منصه تعليميه' }}</title>

    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('front/next.css') }}">
    <link rel="stylesheet" href="{{ asset('front/fahm.css') }}">
</head>

<body class="fahm-wrap">

    <!-- ================= Navbar ================= -->
    <!-- ================= Navbar ================= -->

    @include('front.layouts.navbar')

    <!-- ===== Hero Section ===== -->
    @yield('content')

    <!-- ===== Footer Section ===== -->
    @include('front.layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/script.js') }}"></script>
    @stack('scripts')

</body>

</html>
