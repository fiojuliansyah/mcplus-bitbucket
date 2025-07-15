@extends('frontend.layouts.page')

@section('content')
<div class="section-padding vh-100">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-12">
            <h4 class="fw-semibold mb-4 text-center">Select Your Profile</h4>
            <div class="row">
                @foreach ($user->profiles as $profile)
                    <div class="col-6 col-sm-4 col-md-3 mb-4">
                        <div class="card shadow-sm border-0" style="cursor: pointer;" 
                            @if ($profile->pin != null) 
                                data-bs-toggle="modal" 
                                data-bs-target="#pinModal-{{ $profile->id }}"
                            @else 
                                onclick="document.getElementById('change-profile-{{ $profile->id }}').submit();"
                            @endif
                        >
                            <div class="d-flex justify-content-center mt-4">
                                @if($profile->avatar)
                                    <img src="{{ asset('storage/' . $profile->avatar) }}" class="card-img-top" alt="Profile Avatar" style="width: 200px; height: 200px; object-fit: cover; border-radius: 10px">
                                @else
                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; border-radius: 10px">
                                        <span class="fs-5">
                                            @foreach(explode(' ', $profile->name) as $word)
                                                {{ strtoupper($word[0]) }}
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $profile->name }}</h5>
                            </div>
                            <form action="{{ route('user.change-profile', $profile->id) }}" method="POST" id="change-profile-{{ $profile->id }}" style="display: none;">
                                @csrf
                                <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Card untuk menambah profil baru -->
                <div class="col-6 col-sm-4 col-md-3 mb-4">
                    <div class="card shadow-sm border-0" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                        <div class="d-flex justify-content-center mt-4">
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; border-radius: 10px">
                                <span class="fs-3">+</span>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">Add New Profile</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <a href="{{ route('user.edit-profile') }}" class="btn btn-light btn-sm">Manage Profile</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2"></div>
    </div>
  </div>
</div>

<!-- Modal for Entering PIN -->
@foreach ($user->profiles as $profile)
    @if ($profile->pin != null)
        <div class="modal fade" id="pinModal-{{ $profile->id }}" tabindex="-1" aria-labelledby="pinModalLabel-{{ $profile->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pinModalLabel-{{ $profile->id }}">Enter PIN to Access Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.change-profile', $profile->id) }}">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                                <label for="pin" class="form-label">PIN</label>
                                <input type="password" class="form-control" id="pin" name="pin" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- Modal Add Profile -->
<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profile_name" class="form-label">Profile Name</label>
                        <input type="text" class="form-control" id="profile_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_avatar" class="form-label">Avatar</label>
                        <input type="file" class="form-control" id="profile_avatar" name="avatar" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
