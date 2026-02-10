        <nav class="main-navbar">
            <div
                class="container-fluid d-flex align-items-lg-center align-items-stretch flex-column flex-xl-row gap-3 justify-content-between">
                <div class="logo">
                    <div class="tog-active d-block d-lg-none" data-tog="true" data-active=".app">
                        <i class="fas fa-bars"></i>
                    </div>
                    <img src="{{ asset('dashboard/img/logo.svg') }}" class="img" alt="" />
                    <div class="text d-none d-lg-block">
                        إيثاق لخدمات الأعمال
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2rem">
                    <div class="list-item d-none d-lg-flex">
                        {{-- <div class="main-btn btn-purple">
                            <span class="main-badge">3</span>
                            طلبات تفعيل الاستشارة
                            <img src="{{ asset('dashboard/img/icons/contract-white.svg') }}" alt=""
                                class="icon" />
                        </div>
                        <div class="main-btn btn-orange">
                            <span class="main-badge">3</span>
                            تراخيص وسجلات بانتظار التحقق
                            <img src="{{ asset('dashboard/img/icons/user-white.svg') }}" alt=""
                                class="icon" />
                        </div>
                        <div class="main-btn">
                            الطلبات الحديثة
                            <img src="{{ asset('dashboard/img/icons/bell-white.svg') }}" alt=""
                                class="icon" />
                        </div> --}}
                    </div>
                    {{-- <div class="d-flex align-items-center gap-2rem">
                        <div class="dropdown icon-nav">
                            @php
                                $conversation = App\Models\Conversation::where(function ($q) {
                                    $q->where('user_one_id', auth()->id())->orWhere('user_two_id', auth()->id());
                                })
                                    ->whereHas('messages', function ($q) {
                                        $q->where('is_read', false)->where('sender_id', '!=', auth()->id());
                                    })
                                    ->count();
                            @endphp
                            <div class="main-badge badge-info " id="count-converstion-icon">{{ $conversation }}</div>
                            <a class="dropdown-toggle icon-nav" t href="{{ route('dashboard.chats.index') }}">
                                <img src="{{ asset('dashboard/img/icons/msg.svg') }}" alt="" class="icon" />
                            </a>
                        </div>
                        <div class="dropdown icon-nav">
                            <div class="main-badge">0</div>
                            <button class="dropdown-toggle icon-nav" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('dashboard/img/icons/bell.svg') }}" alt="" class="icon" />
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#"></a></li>
                                <li></li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="dropdown info-user ms-auto">
                        <button class="dropdown-toggle d-flex align-items-center gap-2 content" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text">
                                <div class="name">
                                    <i class="fas fa-angle-down"></i>
                                    {{ auth()->user()->fullname }}
                                </div>
                                <div class="dic"> {{ auth()->user()->type }}</div>
                            </div>
                            <div class="img">
                                <img src="{{ asset('dashboard/img/icons/user-black.svg') }}" alt=""
                                    class="icon" />
                            </div>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard.profile') }}">
                                    الملف الشخصي
                                </a>
                            </li>
                            <li>
                                <form id="logoutForm" action="{{ route('dashboard.logout') }}" method="post">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="document.getElementById('logoutForm').submit()">
                                    تسجيل الخروج
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
