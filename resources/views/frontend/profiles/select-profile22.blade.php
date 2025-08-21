@extends('layouts.auth') {{-- Atau layouts.app, tergantung layout utama Anda setelah login --}}

@section('content')
<div class="main-wrapper">
    <div class="login-content-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">

                    <div class="text-center mb-5">
                        <a href="{{ url('/') }}">
                            <img src="/frontpage/assets/img/logo.svg" class="img-fluid mb-4" alt="Logo" style="max-width: 180px;">
                        </a>
                        <h1 class="fs-32 fw-bold topic">Select Your Profile</h1>
                        <p class="fs-16">Choose a profile to continue your learning journey.</p>
                    </div>

                    <div class="row justify-content-center">
                        @foreach ($user->profiles as $profile)
                            <div class="col-6 col-sm-4 col-md-3 mb-4 text-center">
                                <div class="profile-card"
                                    @if ($profile->pin != null) 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pinModal-{{ $profile->id }}"
                                    @else 
                                        onclick="document.getElementById('change-profile-{{ $profile->id }}').submit();"
                                    @endif
                                >
                                    @if($profile->avatar)
                                        <img src="{{ asset('storage/' . $profile->avatar) }}" class="profile-avatar" alt="Profile Avatar">
                                    @else
                                        <div class="profile-initials">
                                            <span>
                                                @foreach(explode(' ', $profile->name) as $word)
                                                    {{ strtoupper($word[0]) }}
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                    <h5 class="profile-name">{{ $profile->name }}</h5>
                                </div>
                                <form action="{{ route('user.change-profile', $profile->id) }}" method="POST" id="change-profile-{{ $profile->id }}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                                </form>
                            </div>
                        @endforeach

                        <div class="col-6 col-sm-4 col-md-3 mb-4 text-center">
                            <div class="profile-card" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                                <div class="profile-add">
                                    <span>+</span>
                                </div>
                                <h5 class="profile-name">Add Profile</h5>
                            </div>
                        </div>
                    </div>

                        {{-- <div class="text-center mt-4">
                            <a href="{{ route('user.edit-profile') }}" class="btn btn-secondary">Manage Profiles</a>
                        </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($user->profiles as $profile)
    @if ($profile->pin != null)
    <div class="modal fade" id="pinModal-{{ $profile->id }}" tabindex="-1" aria-labelledby="pinModalLabel-{{ $profile->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinModalLabel-{{ $profile->id }}">Enter PIN for {{ $profile->name }}</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('user.change-profile', $profile->id) }}">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                            <label for="pin-{{ $profile->id }}" class="form-label">Profile PIN</label>
                            <input type="password" class="form-control form-control-lg text-center" id="pin-{{ $profile->id }}" name="pin" required autofocus maxlength="4" pattern="[0-9]*">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary btn-lg">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProfileModalLabel">Add New Profile</h5>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle5"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profile_name" class="form-label">Profile Name</label>
                        <input type="text" class="form-control form-control-lg" id="profile_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_avatar" class="form-label">Avatar (Optional)</label>
                        <input type="file" class="form-control" id="profile_avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-secondary btn-lg">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .login-content-form {
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    .profile-card {
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .profile-card:hover {
        transform: translateY(-5px);
    }
    .profile-avatar, .profile-initials, .profile-add {
        width: 150px;
        height: 150px;
        border-radius: 12px;
        margin: 0 auto;
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .profile-initials {
        background: linear-gradient(45deg, #0d6efd, #6f42c1);
        color: white;
        font-size: 3rem;
        font-weight: bold;
    }
    .profile-add {
        background-color: #e9ecef;
        color: #6c757d;
        font-size: 4rem;
        line-height: 1;
    }
    .profile-name {
        margin-top: 1rem;
        font-weight: 600;
        color: #333;
    }
    .modal-content {
        border-radius: 12px;
    }
    .modal-header {
        border-bottom: 1px solid #eee;
    }
    .modal-footer {
        border-top: 1px solid #eee;
    }
</style>
@endpush