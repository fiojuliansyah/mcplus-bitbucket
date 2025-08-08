<div class="col-lg-3">
    <div class="settings-sidebar mb-lg-0">
        <div>
            <h6 class="mb-3">Main Menu</h6>
            <ul class="mb-3 pb-1">
                <li>
                    <a href="{{ route('tutor.dashboard') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.dashboard']) ? 'active' : '' }}"><i
                            class="isax isax-grid-35 me-2"></i>Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('tutor.subjects.index') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.subjects.index']) ? 'active' : '' }}"><i
                            class="isax isax-teacher5 me-2"></i>Subjects</a>
                </li>
                <li>
                    <a href="{{ route('tutor.live-classes.index') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.live-classes.index']) ? 'active' : '' }}"><i
                            class="isax isax-monitor5 me-2"></i>Live Classes</a>
                </li>
                <li>
                    <a href="{{ route('tutor.assignments.index') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.assignments.index']) ? 'active' : '' }}"><i
                            class="isax isax-clipboard-text5 me-2"></i>Assignments</a>
                </li>
                <li>
                    <a href="#" class="d-inline-flex align-items-center {{ Route::is(['#']) ? 'active' : '' }}"><i
                            class="isax isax-clipboard-text5 me-2"></i>Quizzes</a>
                </li>
                <li>
                    <a href="{{ route('tutor.students') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.students']) ? 'active' : '' }}"><i
                            class="isax isax-profile-2user5 me-2"></i>Students</a>
                </li>
                <li>
                    <a href="instructor-tickets.html" class="d-inline-flex align-items-center"><i
                            class="isax isax-ticket5 me-2"></i>Support Tickets</a>
                </li>
            </ul>
            <hr>
            <h6 class="mb-3">Account Settings</h6>
            <ul>
                <li>
                    <a href="{{ route('tutor.settings') }}" class="d-inline-flex align-items-center {{ Route::is(['tutor.settings']) ? 'active' : '' }}"><i
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
