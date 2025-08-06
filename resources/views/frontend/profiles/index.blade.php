@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">

                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>Profiles</h5>
                        <a href="#" class="btn btn-primary btn-sm position-relative" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                            <span class="button-text">+ Add Profile</span>
                        </a>
                    </div>
                    @foreach (Auth::user()->profiles as $profile)
                        <div class="profile-item d-flex align-items-center justify-content-between mb-3 p-3 border rounded">
                            <div class="d-flex align-items-center gap-3">
                                @if ($profile->avatar)
                                    <img src="{{ asset('storage/' . $profile->avatar) }}" class="img-fluid" width="40"
                                        height="40" alt="Profile Avatar" style="border-radius: 5px">
                                @else
                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <span class="fs-6">
                                            @foreach (explode(' ', $profile->name) as $word)
                                                {{ strtoupper($word[0]) }}
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                                <span class="font-size-14 fw-500 text-capitalize text-white">{{ $profile->name }}</span>
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#pinModal-{{ $profile->id }}">PIN</a>
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editModal-{{ $profile->id }}">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#editModal-{{ $profile->id }}">Delete</a>
                            </div>
                        </div>
                        <div class="modal fade" id="pinModal-{{ $profile->id }}" tabindex="-1"
                            aria-labelledby="pinModalLabel-{{ $profile->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pinModalLabel-{{ $profile->id }}">Set PIN for:
                                            {{ $profile->name }}</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('user.profile.update.pin', $profile->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label for="pin-{{ $profile->id }}" class="form-label">New PIN (4
                                                    Digits)</label>
                                                <input type="password" class="form-control" id="pin-{{ $profile->id }}"
                                                    name="pin" required maxlength="4" pattern="\d{4}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="pin_confirmation-{{ $profile->id }}"
                                                    class="form-label">Confirm PIN</label>
                                                <input type="password" class="form-control"
                                                    id="pin_confirmation-{{ $profile->id }}" name="pin_confirmation"
                                                    required maxlength="4">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary me-2"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save PIN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="editModal-{{ $profile->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel-{{ $profile->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-{{ $profile->id }}">Edit Profile:
                                            {{ $profile->name }}</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('user.profile.update', $profile->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label for="name-{{ $profile->id }}" class="form-label">Profile
                                                    Name</label>
                                                <input type="text" class="form-control" id="name-{{ $profile->id }}"
                                                    name="name" value="{{ $profile->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Current Avatar</label>
                                                <div>
                                                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar"
                                                        width="80">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="avatar-{{ $profile->id }}" class="form-label">New Avatar
                                                    (Optional)</label>
                                                <input type="file" class="form-control" id="avatar-{{ $profile->id }}"
                                                    name="avatar" accept="image/*">
                                                <small class="form-text text-muted">Leave blank to keep the current
                                                    avatar.</small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary me-2"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 pt-4">
                                    <label for="profile_name" class="form-label">Profile Name</label>
                                    <input type="text" class="form-control" id="profile_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_avatar" class="form-label">Avatar</label>
                                    <input type="file" class="form-control" id="profile_avatar" name="avatar" accept="image/*" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
