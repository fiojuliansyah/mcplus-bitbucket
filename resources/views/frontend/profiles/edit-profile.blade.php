@extends('frontend.layouts.page')

@section('content')
<div class="section-padding vh-100">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-12">
            <h4 class="fw-semibold mb-4 text-center">Manage Profile :</h4>
            <div class="row">
                @foreach ($user->profiles as $profile)
                    <div class="col-6 col-sm-4 col-md-3 mb-4">
                        <div class="card shadow-sm border-0" style="cursor: pointer;">
                            <div class="d-flex justify-content-center mt-4 position-relative">
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

                                <a href="{{ route('user.edit-profile', $profile->id) }}" class="position-absolute top-50 start-50 translate-middle p-2" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 50%; color: white; font-size: 12px;">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $profile->name }}</h5>
                            </div>
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
                <a href="{{ route('user.select-profile') }}" class="btn btn-light btn-sm">Finish</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2"></div>
    </div>
  </div>
</div>
<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
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
