@extends('frontend.layouts.app')

@section('content')
<div class="profile-page section-padding-top">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="main-title text-capitalize">Profile</h2>
      <p class="text-muted">Update your personal information and preferences.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card border-0 shadow-lg rounded-lg">
          <div class="card-body p-4">
            <form action="" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" value="{{ $tutor->name }}" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" value="{{ $tutor->email }}" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" value="{{ $tutor->phone }}" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" value="{{ $tutor->password }}" class="form-control">
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Phone Verified:</label>
                <span class="{{ $tutor->phone_verified ? 'text-success' : 'text-danger' }}">
                  {{ $tutor->phone_verified ? 'Yes' : 'No' }}
                </span>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary px-5">
                  Update Profile
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
