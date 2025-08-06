<div class="col-lg-3">
    <div class="settings-sidebar">
        <div>
            <h6 class="mb-3">Main Menu</h6>
            <ul class="mb-3 pb-1">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="d-inline-flex align-items-center {{ Route::is(['user.dashboard']) ? 'active' : '' }}"><i
                            class="isax isax-grid-35 me-2"></i>Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}" class="d-inline-flex align-items-center {{ Route::is(['user.profile']) ? 'active' : '' }}"><i
                            class="fa-solid fa-user me-2"></i>My Profile</a>
                </li>
                <li>
                    <a href="{{ route('user.enrolled-subjects') }}" class="d-inline-flex align-items-center {{ Route::is(['user.enrolled-subjects']) ? 'active' : '' }}"><i class="isax isax-teacher5 me-2"></i>Enrolled Subjects</a>
                </li>
                <li>
                    <a href="{{ route('user.my-assignment') }}" class="d-inline-flex align-items-center {{ Route::is(['user.my-assignment']) ? 'active' : '' }}"><i
                            class="isax isax-award5 me-2"></i>My Assignment</a>
                </li>
                <li>
                    <a href="{{ route('user.my-quiz') }}" class="d-inline-flex align-items-center {{ Route::is(['user.my-quiz']) ? 'active' : '' }}"><i
                            class="isax isax-award5 me-2"></i>My Quiz</a>
                </li>
                <li>
                    <a href="{{ route('user.order-history') }}" class="d-inline-flex align-items-center {{ Route::is(['user.order-history']) ? 'active' : '' }}"><i
                            class="isax isax-shopping-cart5 me-2"></i>Order History</a>
                </li>
                <li>
                    <a href="student-tickets.html" class="d-inline-flex align-items-center"><i
                            class="isax isax-ticket5 me-2"></i>Support Tickets</a>
                </li>
            </ul>
            <hr>
            <h6 class="mb-3">Account Settings</h6>
            <ul>
                <li>
                    <a href="{{ route('user.settings') }}" class="d-inline-flex align-items-center {{ Route::is(['user.settings']) ? 'active' : '' }}"><i
                            class="isax isax-setting-25 me-2"></i>Settings</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="d-inline-flex align-items-center"><i
                            class="isax isax-logout5 me-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>Logout</a>

                    <form id="logout-form" action="{{ route('logout-user') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
