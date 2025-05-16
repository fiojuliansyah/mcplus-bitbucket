<aside class="sidebar sidebar-base sidebar-white sidebar-default navs-rounded-all " id="first-tour"
        data-toggle="main-sidebar" data-sidebar="responsive">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="./index.html" class="navbar-brand">

                <!--Logo start-->
                <img class="logo-normal" src="/frontend/assets/images/logo-example.png" alt="#">
                <img class="logo-normal logo-white" src="/admin/assets/images/logo-white.png" alt="#">
                <img class="logo-full" src="/frontend/assets/images/logo-example.png"" alt="#">
                <img class="logo-full logo-full-white" src="/admin/assets/images/logo-full-white.png" alt="#">
                <!--logo End--> </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="chevron-right">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.2rem" viewBox="0 0 512 512" fill="white">
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                </i>
                <i class="chevron-left">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1.2rem" viewBox="0 0 512 512" fill="white"
                        transform="rotate(180)">
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(['admin.dashboard']) ? 'active' : '' }}" aria-current="page" href="{{ route('admin.dashboard') }}">
                            <i class="icon" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Dashboard"
                                data-bs-original-title="Dashboard">
                                <svg width="20" class="icon" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(['admin.users.index']) ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users""></i>
                            <span class="item-name">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(['admin.tutors.index']) ? 'active' : '' }}" href="{{ route('admin.tutors.index') }}">
                            <i class="fas fa-chalkboard-teacher""></i>
                            <span class="item-name">Tutors</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is(['admin.grades.index','admin.subjects.index']) ? 'active' : '' }}" href="{{ route('admin.grades.index') }}">
                            <i class="fas fa-chalkboard-teacher""></i>
                            <span class="item-name">Grades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-Classes" role="button" aria-expanded="false"
                            aria-controls="sidebar-user">
                            <i class="icon"">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M13.7505 9.70303V7.68318C13.354 7.68318 13.0251 7.36377 13.0251 6.97859V4.57356C13.0251 4.2532 12.764 4.00049 12.4352 4.00049H5.7911C3.70213 4.00049 2 5.653 2 7.68318V10.1155C2 10.3043 2.07737 10.4828 2.21277 10.6143C2.34816 10.7449 2.53191 10.8201 2.72534 10.8201C3.46035 10.8201 4.02128 11.3274 4.02128 11.9944C4.02128 12.6905 3.45068 13.2448 2.73501 13.2533C2.33849 13.2533 2 13.5257 2 13.9203V16.3262C2 18.3555 3.70213 19.9995 5.78143 19.9995H12.4352C12.764 19.9995 13.0251 19.745 13.0251 19.4265V17.3963C13.0251 17.0027 13.354 16.6917 13.7505 16.6917V14.8701C13.354 14.8701 13.0251 14.5497 13.0251 14.1655V10.4076C13.0251 10.0224 13.354 9.70303 13.7505 9.70303Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M19.9787 11.9948C19.9787 12.69 20.559 13.2443 21.265 13.2537C21.6615 13.2537 22 13.5262 22 13.9113V16.3258C22 18.3559 20.3075 20 18.2186 20H15.0658C14.7466 20 14.4758 19.7454 14.4758 19.426V17.3967C14.4758 17.0022 14.1567 16.6921 13.7505 16.6921V14.8705C14.1567 14.8705 14.4758 14.5502 14.4758 14.1659V10.4081C14.4758 10.022 14.1567 9.70348 13.7505 9.70348V7.6827C14.1567 7.6827 14.4758 7.36328 14.4758 6.9781V4.57401C14.4758 4.25366 14.7466 4 15.0658 4H18.2186C20.3075 4 22 5.64406 22 7.6733V10.0407C22 10.2286 21.9226 10.4081 21.7872 10.5387C21.6518 10.6702 21.4681 10.7453 21.2747 10.7453C20.559 10.7453 19.9787 11.31 19.9787 11.9948Z"
                                        fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Finance</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="sidebar-Classes" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link " href="">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Transactions</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href=""">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Subscription Plan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href=""">
                                    <i class="fas fa-circle" style="font-size: 9px"></i>
                                    <span class="item-name">Coupon</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mb-4">
                        <a class="nav-link {{ Route::is(['admin.roles.index']) ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="Access Control"
                                data-bs-placement="right" aria-label="Access Control"
                                data-bs-original-title="Access Control">
                                <i class="fas fa-user-lock"></i>
                            </i>
                            <span class="item-name">Access Control</span>
                        </a>
                    </li>
                </ul>

                <!-- Sidebar Menu End -->
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>