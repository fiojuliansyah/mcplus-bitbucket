@extends('frontend.layouts.app')

@section('content')
      <div class="iq-breadcrumb" style="background-image: url(../assets/images/pages/01.webp);">
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
                                <p>Hello Jenny (not Jenny? <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>)</p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <p>From your account dashboard you can view your <a href="javascript:void(0)">recent subscriptions</a>,
                                    manage your <a href="javascript:void(0)">shipping and billing addresses</a>, and <a href="javascript:void(0)">edit your password and account details</a>.
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
                                                <th class="fw-bolder p-3">Status</th>
                                                <th class="fw-bolder p-3">Total</th>
                                                <th class="fw-bolder p-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-primary fs-6">#32604</td>
                                                <td>October 28, 2022</td>
                                                <td>Cancelled</td>
                                                <td>$215.00 For 0 Items</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="iq-button">
                                                            <a href="javascript:void(0)" class="btn text-uppercase position-relative">
                                                                <span class="button-text">pay</span>
                                                                <i class="fa-solid fa-play"></i>
                                                            </a>
                                                        </div>
                                                        <div class="iq-button">
                                                            <a href="javascript:void(0)" class="btn text-uppercase position-relative">
                                                                <span class="button-text">view</span>
                                                                <i class="fa-solid fa-play"></i>
                                                            </a>
                                                        </div>
                                                        <div class="iq-button">
                                                            <a href="javascript:void(0)" class="btn text-uppercase position-relative">
                                                                <span class="button-text">cancel</span>
                                                                <i class="fa-solid fa-play"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profiles" role="tabpanel">
                            <div class="text-body p-4">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <h4 class="mb-0">Profiles</h4>
                                    <div class="iq-button">
                                        <a href="#" class="btn text-uppercase position-relative" data-bs-toggle="collapse"
                                        data-bs-target="#edit-address-1" aria-expanded="false">
                                            <span class="button-text">Add Profile</span>
                                            <i class="fa-solid fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse p-4" id="edit-address-1">
                                    <form action="{{ route('user.profile.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Avatar</label>
                                            <input type="file" class="form-control" id="avatar" name="avatar">
                                        </div>
                                        <div class="mb-3">
                                            <label for="pin" class="form-label">Pin</label>
                                            <input type="text" class="form-control" id="pin" name="pin">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Profile</button>
                                    </form>
                                </div>
                                <div class="subscriptions-table text-body p-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th class="fw-bolder p-3">No</th>
                                                    <th class="fw-bolder p-3">Image</th>
                                                    <th class="fw-bolder p-3">Name</th>
                                                    <th class="fw-bolder p-3">PIN</th>
                                                    <th class="fw-bolder p-3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($profiles as $index => $profile)
                                                    <tr class="border-bottom">
                                                        <td class="text-primary fs-6">{{ $index + 1 }}</td>
                                                        <td>
                                                            @if($profile->avatar)
                                                                <img src="{{ asset('storage/'.$profile->avatar) }}" alt="avatar" class="rounded-circle" width="40" height="40">
                                                            @else
                                                                <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    <span class="fs-6">
                                                                        @foreach(explode(' ', $profile->name) as $word)
                                                                            {{ strtoupper($word[0]) }}
                                                                        @endforeach
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="text-primary fs-6">{{ $profile->name }}</td>
                                                        <td>{{ $profile->pin }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <!-- Edit Button -->
                                                                <a href="" class="text-primary iq-view-all text-decoration-none flex-none" data-bs-toggle="modal" data-bs-target="#editProfileModal{{ $profile->id }}">
                                                                    Edit
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal for editing the profile -->
                                                    <div class="modal fade" id="editProfileModal{{ $profile->id }}" tabindex="-1" aria-labelledby="editProfileModalLabel{{ $profile->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <form action="{{ route('user.profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editProfileModalLabel{{ $profile->id }}">Edit Profile</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="name" class="form-label">Name</label>
                                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $profile->name }}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="pin" class="form-label">PIN</label>
                                                                            <input type="text" class="form-control" id="pin" name="pin" value="{{ $profile->pin }}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="avatar" class="form-label">Avatar</label>
                                                                            <input type="file" class="form-control" id="avatar" name="avatar">
                                                                            @if($profile->avatar)
                                                                                <img src="{{ asset('storage/'.$profile->avatar) }}" alt="avatar" class="mt-2 rounded-circle" width="50" height="50">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
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
