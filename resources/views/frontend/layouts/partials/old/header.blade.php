<div class="header-topbar text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                    <p class="d-flex align-items-center fw-medium fs-14 mb-2 me-3"><i
                            class="isax isax-location5 me-2"></i>1442 Crosswind Drive Madisonville</p>
                    <p class="d-flex align-items-center fw-medium fs-14 mb-2"><i
                            class="isax isax-call-calling5 me-2"></i>+1 45887 77874</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                    <ul class="social-icon d-flex align-items-center mb-2">
                        <li class="me-2">
                            <a href="javascript:void(0);"><i class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li class="me-2">
                            <a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li class="me-2">
                            <a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
                        </li>
                        <li class="me-2">
                            <a href="javascript:void(0);"><i class="fa-brands fa-youtube"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><i class="fa-brands fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Header Topbar-->

<!-- Header -->
<header class="header-two">
    <div class="container">
        <div class="header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <div class="navbar-logo">
                    <a class="logo-white header-logo" href="index.html">
                        <img src="/frontpage/assets/img/logo.svg" class="logo" alt="Logo">
                    </a>
                    <a class="logo-dark header-logo" href="index.html">
                        <img src="/frontpage/assets/img/logo-white.svg" class="logo" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="index.html" class="menu-logo">
                        <img src="/frontpage/assets/img/logo.svg" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav">
                    <li class="megamenu {{ Route::is(['home']) ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="megamenu {{ Route::is(['home.subjects', 'home.subjectDetail']) ? 'active' : '' }}">
                        <a href="{{ route('home.subjects') }}">Subjects</a>
                    </li>
                    <li class="megamenu {{ Route::is(['home.tutors']) ? 'active' : '' }}">
                        <a href="{{ route('home.tutors') }}">Tutors</a>
                    </li>
                    <li class="megamenu {{ Route::is(['pricing-plans']) ? 'active' : '' }}">
                        <a href="{{ route('pricing-plans') }}">Plans</a>
                    </li>
                    @auth
                        @if (auth()->user()->account_type === 'student')
                            <li class="megamenu {{ Route::is(['user.*']) ? 'active' : '' }}">
                                <a href="{{ route('user.dashboard') }}">My Dashboard</a>
                            </li>
                        @endif
                    @endauth
                    @auth
                        @if (auth()->user()->account_type === 'tutor')
                            <li class="megamenu {{ Route::is(['tutor.*']) ? 'active' : '' }}">
                                <a href="{{ route('tutor.dashboard') }}">My Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div class="header-btn d-flex align-items-center">
                <div class="header-icon-container me-3">
                    @auth  
                        <div class="icon-btn me-3">
                            <div class="dropdown notification-dropdown">
                                <a href="javascript:void(0);" class="position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="isax isax-notification5"></i>
                                    @if($unreadNotifications->count() > 0)
                                        <span class="count-icon bg-danger p-1 rounded-pill text-white fs-10 fw-bold">
                                            {{ $unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" style="width: 500px; max-width: none;">
                                    <div class="notification-header">
                                        <h6 class="mb-0">Notifications</h6>
                                    </div>
                                    <div class="notification-body">
                                        @forelse($notifications as $notification)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <span class="avatar avatar-sm bg-info-light">
                                                        <i class="isax isax-notification5 text-info"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <p class="mb-0 @if($notification->read_at === null) text-secondary @endif"><strong>{{ $notification->data['message'] ?? 'Notification message is missing.' }}</strong></p>
                                                    <span class="text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="mb-0 text-center text-muted">No new notifications</p>
                                        @endforelse
                                    </div>
                                    <div class="notification-footer">
                                        <a href="{{ route('notifications.markAsRead') }}" class="text-primary">Mark all as read</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth
                    <div class="icon-btn me-2">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle activate">
                            <i class="isax isax-sun-15"></i>
                        </a>
                        <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle">
                            <i class="isax isax-moon"></i>
                        </a>
                    </div>
                </div>
                 @guest
                    <a href="{{ route('login') }}" class="btn btn-primary d-inline-flex align-items-center me-2">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary me-0">
                        Register
                    </a>
                @endguest

                @auth
                    <div class="header-btn d-flex align-items-center">
                        <div class="dropdown profile-dropdown">
                            <a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
                                <span class="avatar">
                                    @if(Auth::user()->current_profile && Auth::user()->current_profile->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->current_profile->avatar) }}" alt="Img" class="img-fluid rounded-circle">
                                    @else
                                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 100px">
                                            <span class="fs-6">
                                                @foreach(explode(' ', Auth::user()->current_profile->name ?? Auth::user()->name) as $word)
                                                    {{ strtoupper($word[0]) }}
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach (Auth::user()->profiles as $profile)
                                    <a href="javascript:void(0);" 
                                        @if ($profile->pin)
                                            data-bs-toggle="modal" 
                                            data-bs-target="#enterPinModal-{{ $profile->id }}"
                                        @else
                                            onclick="event.preventDefault(); document.getElementById('change-profile-{{ $profile->id }}').submit();"
                                        @endif class="profile-header d-flex align-items-center">
                                        <div class="avatar">
                                            @if($profile->avatar)
                                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Img" class="img-fluid rounded-circle">
                                            @else
                                                <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; border-radius: 50px">
                                                    <span class="fs-6">
                                                        @foreach(explode(' ', $profile->name) as $word)
                                                            {{ strtoupper($word[0]) }}
                                                        @endforeach
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 @if ($profile->is(Auth::user()->current_profile))class="text-secondary" @endif>{{ $profile->name }}</h6>
                                            <p> 
                                                @if ($profile->is(Auth::user()->current_profile))
                                                    {{ Auth::user()->email }}
                                                @endif
                                            </p>
                                        </div>
                                        @if (!$profile->pin)
                                            <form id="change-profile-{{ $profile->id }}" action="{{ route('user.change-profile') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                                            </form>
                                        @endif
                                    </a>
                                @endforeach
                                <ul class="profile-body">
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{ route('user.profile') }}"><i class="isax isax-security-user me-2"></i>My Profile</a>
                                    </li>
                                    @if (auth()->user()->account_type === 'student')
                                        <li>
                                            <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{ route('user.learning-progress') }}"><i class="isax isax-teacher me-2"></i>Learning Progress</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->account_type === 'tutor')
                                        <li>
                                            <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="instructor-course.html"><i class="isax isax-teacher me-2"></i>Courses</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{ route('user.settings') }}"><i class="isax isax-setting-2 me-2"></i>Settings</a>
                                    </li>
                                </ul>
                                <div class="profile-footer">
                                    <a href="javascript:void(0);" class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="isax isax-logout me-2"></i>Logout</a>
                                    <form id="logout-form" action="{{ route('logout-user') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
