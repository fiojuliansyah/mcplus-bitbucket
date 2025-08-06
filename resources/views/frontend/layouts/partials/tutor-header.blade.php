<div class="instructor-profile">
    <div class="instructor-profile-bg">
        <img src="assets/img/bg/card-bg-01.png" class="instructor-profile-bg-1" alt="">
    </div>
    <div class="row align-items-center row-gap-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <span
                    class="avatar flex-shrink-0 avatar-xxl avatar-rounded me-3 border border-white border-3 position-relative">
                    @if($user->current_profile && $user->current_profile->avatar)
                        <img src="{{ asset('storage/' . $user->current_profile->avatar) }}" alt="{{ $user->current_profile->name }}">
                    @else
                        <img src="/frontpage/assets/img/user/user-02.jpg" alt="">
                    @endif
                    <span class="verify-tick"><i class="isax isax-verify5"></i></span>
                </span>
                <div>
                    <h5 class="mb-1 text-white d-inline-flex align-items-center">{{ Auth::user()->name }}<a
                            href="instructor-profile.html" class="link-light fs-16 ms-2"><i
                                class="isax isax-edit-2"></i></a></h5>
                    <p class="text-light">{{ Auth::user()->account_type }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center flex-wrap gap-3 justify-content-md-end">
                <a href="add-course.html" class="btn btn-white rounded-pill">Add New Course</a>
                <a href="student-dashboard.html" class="btn btn-secondary rounded-pill">Add Live Class</a>
            </div>
        </div>
    </div>
</div>
