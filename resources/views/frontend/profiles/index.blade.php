@extends('frontend.layouts.app')

@section('content')
      <div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/my-account.png);">
         <div class="container-fluid">
            <div class="row align-items-center">
                  <div class="col-sm-12">
                      <nav aria-label="breadcrumb" class="text-center">
                          <h2 class="title">My Account</h2>
                          <ol class="breadcrumb justify-content-center">
                              <li class="breadcrumb-item"><a href="../index.html">Home</a></li> 
                              <li class="breadcrumb-item active">My Account</li>
                          </ol>
                      </nav>
                  </div>
              </div> 
         </div>
      </div>      <!--bread-crumb-->

    <div class="section-padding service-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="acc-left-menu p-4 mb-5 mb-lg-0 mb-md-0">
                        <div class="product-menu">
                            <ul class="list-inline m-0 nav nav-tabs flex-column bg-transparent border-0" role="tablist">
                                <li class="pb-3 nav-item">
                                    <button class="nav-link active p-0 bg-transparent" data-bs-toggle="tab"
                                        data-bs-target="#dashboard" type="button" role="tab" aria-selected="true"><i
                                            class="fas fa-tachometer-alt"></i><span class="ms-2">Dashboard</span></button>
                                </li>
                                <li class="py-3 nav-item">
                                    <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                                        data-bs-target="#profiles" type="button" role="tab" aria-selected="true"><i
                                            class="fas fa-users"></i><span class="ms-2">Profiles</span></button>
                                </li>
                                <li class="py-3 nav-item">
                                    <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                                        data-bs-target="#subscriptions" type="button" role="tab" aria-selected="true"><i
                                            class="fas fa-list"></i><span class="ms-2">Subscriptions</span></button>
                                </li>
                                <li class="py-3 nav-item">
                                    <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                                        data-bs-target="#account-details" type="button" role="tab" aria-selected="true"><i
                                            class="fas fa-user"></i><span class="ms-2">Account details</span></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="tab-content" id="product-menu-content">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                            <div class="myaccount-content text-body p-4">
                                <p>Hello {{ $user->current_profile->name }} (not {{ $user->current_profile->name }}? <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>)</p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <p>From your account dashboard you can view your <a href="javascript:void(0)">recent subscriptions</a>,
                                    manage your <a href="javascript:void(0)" data-bs-toggle="tab"
                                        data-bs-target="#profiles" type="button" role="tab" aria-selected="true">profiles</a>, and <a href="javascript:void(0)">edit your password and account details</a>.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="subscriptions" role="tabpanel">
                            <div class="subscriptions-table text-body p-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr class="border-bottom">
                                                <th class="fw-bolder p-3">Order</th>
                                                <th class="fw-bolder p-3">Date</th>
                                                <th class="fw-bolder p-3">User</th>
                                                <th class="fw-bolder p-3">Plan</th>
                                                <th class="fw-bolder p-3">Subject</th>
                                                <th class="fw-bolder p-3">Status</th>
                                                <th class="fw-bolder p-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscriptions as $index => $subscription)
                                                <tr class="border-bottom">
                                                    <td class="text-primary fs-6">#{{ $subscription->transaction_code }}</td>
                                                    <td>{{ $subscription->created_at->format('d M Y') }}</td>
                                                    <td>{{ $subscription->profile->name  }}</td>
                                                    <td>{{ $subscription->plan->name }}</td>
                                                    <td>{{ $subscription->subject->name }}</td>
                                                    <td>
                                                        @if ($subscription->status == 'success')
                                                            <span class="badge rounded-pill bg-primary">Success</span>
                                                        @elseif ($subscription->status == 'canceled')
                                                            <span class="badge rounded-pill bg-danger">Canceled</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-warning">pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="badge bg-primary text-uppercase position-relative">
                                                            <span class="button-text">pay</span>
                                                        </a>
                                                        <a href="javascript:void(0)" class="badge bg-danger text-uppercase position-relative">
                                                            <span class="button-text">cancel</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profiles" role="tabpanel">
                            <div class="text-body p-4">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <h4 class="mb-0">Profiles</h4>
                                    <a href="#" class="badge bg-primary position-relative" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                                        <span class="button-text">+ Add Profile</span>
                                    </a>
                                </div>
                                <div class="profiles-list mt-4">
                                    @foreach (Auth::user()->profiles as $profile)
                                        <div class="profile-item d-flex align-items-center justify-content-between mb-3 p-3 border rounded">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($profile->avatar)
                                                <img src="{{ asset('storage/' . $profile->avatar) }}" class="img-fluid" width="40" height="40" alt="Profile Avatar" style="border-radius: 5px">
                                                @else
                                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <span class="fs-6">
                                                            @foreach(explode(' ', $profile->name) as $word)
                                                                {{ strtoupper($word[0]) }}
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="font-size-14 fw-500 text-capitalize text-white">{{ $profile->name }}</span>
                                            </div>
                                            <div>
                                                <a href="#" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#pinModal-{{ $profile->id }}">PIN</a>
                                                <a href="#" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $profile->id }}">Edit</a>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="editModal-{{ $profile->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $profile->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel-{{ $profile->id }}">Edit Profile: {{ $profile->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('user.profile.update', $profile->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PATCH')

                                                            <div class="mb-3">
                                                                <label for="name-{{ $profile->id }}" class="form-label">Profile Name</label>
                                                                <input type="text" class="form-control" id="name-{{ $profile->id }}" name="name" value="{{ $profile->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Current Avatar</label>
                                                                <div>
                                                                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" width="80">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="avatar-{{ $profile->id }}" class="form-label">New Avatar (Optional)</label>
                                                                <input type="file" class="form-control" id="avatar-{{ $profile->id }}" name="avatar" accept="image/*">
                                                                <small class="form-text text-muted">Leave blank to keep the current avatar.</small>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="pinModal-{{ $profile->id }}" tabindex="-1" aria-labelledby="pinModalLabel-{{ $profile->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pinModalLabel-{{ $profile->id }}">Set PIN for: {{ $profile->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('user.profile.update.pin', $profile->id) }}">
                                                            @csrf
                                                            @method('PATCH')

                                                            <div class="mb-3">
                                                                <label for="pin-{{ $profile->id }}" class="form-label">New PIN (4 Digits)</label>
                                                                <input type="password" class="form-control" id="pin-{{ $profile->id }}" name="pin" required maxlength="4" pattern="\d{4}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="pin_confirmation-{{ $profile->id }}" class="form-label">Confirm PIN</label>
                                                                <input type="password" class="form-control" id="pin_confirmation-{{ $profile->id }}" name="pin_confirmation" required maxlength="4">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save PIN</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

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
                                                    <div class="mb-3 pt-4">
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
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-details" role="tabpanel">
                            <div class=" p-4 text-body">
                                <form>
                                    <div class="form-group mb-5">
                                        <label class="mb-2">Name&nbsp; <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                    </div>
                                    <em class="d-block mb-5">This will be how your name will be displayed in the account
                                        section and in reviews</em>
                                    <div class="form-group mb-5">
                                        <label class="mb-2">Email address&nbsp; <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                    </div>
                                    <div class="form-group mb-5">
                                        <label class="mb-2">Phone&nbsp; <span class="text-danger">*</span></label>
                                        <input type="email" name="phone" value="{{ $user->phone }}" class="form-control" disabled>
                                    </div>
                                    <h4 class="fw-normal mb-5">Password change</h4>
                                    <div class="form-group mb-5">
                                        <label class="mb-2">New password (leave blank to leave unchanged)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="form-group mb-5">
                                        <label class="mb-2">Confirm new password</label>
                                        <input type="password" name="password" class="form-control">  
                                    </div>
                                    <div class="form-group">
                                        <div class="iq-button">
                                            <a href="javascript:void(0)" class="btn text-uppercase position-relative">
                                                <span class="button-text">save changes</span>
                                                <i class="fa-solid fa-play"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
