<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'لوحة التحكم' }}</title>
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/normalize.css') }}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.rtl.min.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/all.min.css') }}" />
    <!-- Main File Css  -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/main.css') }}" />
    <!-- Dashboard V2 (التصميم الجديد) -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard-v2.css') }}" />
    <!-- نظام التصميم الشامل (جداول • موديلات • فورمز • بروفايل) -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard-design-system.css') }}" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" type="image/jpg" href="{{ display_file(setting('fav')) }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('css')

</head>

<body class="dashboard-v2">
    @include('dashboard.layouts.sidebar-v2')
    <div class="main-v2">
        @include('dashboard.layouts.topbar-v2')
        <div class="content-v2">
            <x-alert-component></x-alert-component>
            @yield('contant')
        </div>
        {{-- الموديلات تُعرض هنا خارج منطقة التمرير حتى تظهر وتستجيب للنقر بشكل صحيح --}}
        @stack('modals')
    </div>
    <!-- Js Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('dashboard/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/all.min.js') }}"></script>
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
    {{-- <script>
        Pusher.logToConsole = true;
        window.userId = {{ auth()->id() }};
        var pusher = new Pusher("2f781955a5e3c4f265c4", {
            cluster: "mt1"
        });

        var channel = pusher.subscribe('private-chat-message.' + window.userId);
        channel.bind('message-sent', function(data) {
            console.log('New Message');
            Livewire.dispatch('refreshChat');
            //Update Icon
            fetch("{{ route('dashboard.unread-count') }}")
                .then(res => res.json())
                .then(data => {
                    const el = document.getElementById('count-converstion-icon');
                    if (el) {
                        el.textContent = data.count;
                    }
                });
        });
    </script> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('dashboardSidebar');
            if (btn && sidebar) {
                btn.addEventListener('click', function() { sidebar.classList.toggle('open'); });
            }
            document.addEventListener('click', function(e) {
                if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && !(e.target.closest('#sidebarToggle'))) {
                    sidebar.classList.remove('open');
                }
                var userMenu = document.getElementById('userMenuV2');
                var userBtn = document.getElementById('userBtnV2');
                var userDd = document.getElementById('userDropdownV2');
                if (userMenu && userDd && !userMenu.contains(e.target)) {
                    userDd.classList.remove('show');
                    userDd.setAttribute('aria-hidden', 'true');
                    if (userBtn) { userBtn.classList.remove('open'); userBtn.setAttribute('aria-expanded', 'false'); }
                }
            });
            var userBtnV2 = document.getElementById('userBtnV2');
            var userDropdownV2 = document.getElementById('userDropdownV2');
            if (userBtnV2 && userDropdownV2) {
                userBtnV2.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var isOpen = userDropdownV2.classList.toggle('show');
                    userDropdownV2.setAttribute('aria-hidden', !isOpen);
                    userBtnV2.classList.toggle('open', isOpen);
                    userBtnV2.setAttribute('aria-expanded', isOpen);
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
