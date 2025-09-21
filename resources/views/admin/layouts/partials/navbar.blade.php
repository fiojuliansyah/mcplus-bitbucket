<div class="position-relative">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-xl header-hover-menu navbar-light iq-navbar" style="background-color: white">
                <div class="container-fluid navbar-inner">
                    <a href="./index.html" class="navbar-brand">

                        <!--Logo start-->
                        <img class="logo-normal" src="/frontend/assets/images/main-logo.png" alt="#">
                        <img class="logo-normal logo-white" src="/frontend/assets/images/main-logo.png"
                            alt="#">
                        <img class="logo-full" src="/frontend/assets/images/main-logo.png" alt="#">
                        <img class="logo-full logo-full-white" src="/frontend/assets/images/main-logo.png"
                            alt="#">
                        <!--logo End--> </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon d-flex">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <div class="d-flex align-items-center">
                        <button id="navbar-toggle" class="navbar-toggler" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <span class="navbar-toggler-bar bar1 mt-1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0 ">
                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center ps-3" href="#"
                                    id="profile-setting" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    @if(Auth::user()->profiles->first()->avatar)
                                    <img src="{{ asset('storage/'.Auth::user()->profiles->first()->avatar) }}" alt="User-Profile"
                                        class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded"
                                        loading="lazy">
                                    @else
                                        <div class="text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: black;">
                                            <span class="fs-6">
                                                @foreach(explode(' ', Auth::user()->profiles->first()->name) as $word)
                                                    {{ strtoupper($word[0]) }}
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                    <div class="caption ms-3 d-none d-md-block">
                                        <h6 class="mb-0 caption-title" style="color: black">{{ Auth::user()->name }}</h6>
                                        <p class="mb-0 caption-sub-title">
                                            @if (!empty(Auth::user()->getRoleNames()))
                                                @foreach (Auth::user()->getRoleNames() as $v)
                                                    {{ $v }}
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile-setting">
                                    <li><a class="dropdown-item" href="./app/user-profile.html">Profile</a></li>
                                    <li><a class="dropdown-item" href="./app/user-privacy-setting.html">Privacy
                                            Setting</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav> <!--Nav End-->
        </div>
        