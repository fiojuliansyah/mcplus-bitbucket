<div class="profile-card overflow-hidden bg-blue-gradient2 mb-5 p-5">
    <div class="profile-card-bg">
        <img src="/frontpage/assets/img/bg/card-bg-01.png" class="profile-card-bg-1" alt="">
    </div>
    <div class="row align-items-center row-gap-3">
        <div class="col-lg-6">
            <div class="d-flex align-items-center">
                <span
                    class="avatar avatar-xxl avatar-rounded me-3 border border-white border-2 position-relative">
                    @if($user->current_profile && $user->current_profile->avatar)
                        <img src="{{ asset('storage/' . $user->current_profile->avatar) }}" alt="{{ $user->current_profile->name }}">
                    @else
                        <img src="/frontpage/assets/img/user/user-02.jpg" alt="">
                    @endif
                    <span class="verify-tick"><i class="isax isax-verify5"></i></span>
                </span>
                <div>
                    <h5 class="mb-1 text-white d-inline-flex align-items-center"><a
                            href="student-details.html">{{ $user->current_profile->name }}</a><a href="{{ route('user.settings') }}"
                            class="link-light fs-16 ms-2"><i class="isax isax-edit-2"></i></a></h5>
                    <p class="text-light">Student</p>
                </div>
            </div>
        </div>
    </div>
</div>