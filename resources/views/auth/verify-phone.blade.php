@extends('layouts.auth')

@section('content')
<div class="vh-100" style="background: url('/frontend/assets/images/pages/01.webp'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
  <div class="container">
    <div class="row justify-content-center align-items-center height-self-center vh-100">
        <div class="col-lg-8 col-md-12 align-self-center">
            <form method="POST" action="{{ route('verify.otp') }}">
            @csrf
                <div class="user-login-card bg-body">
                    <h4 class="text-center mb-5">Verify Your Phone Number</h4>
                    <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-5">
                        <div class="col">
                            <label for="otp" class="form-label text-white">Enter OTP sent to your phone</label>
                            <input type="text" name="otp" id="otp" class="form-control rounded-0" required>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <label class="list-group-item d-flex align-items-center mt-5 mb-3 text-white"><input class="form-check-input m-0 me-2" type="checkbox">I've read and accept the <a href="terms-of-use.html" class="ms-1">terms & conditions*</a></label>
                    <div class="row text-center">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <div class="full-button">
                                <div class="iq-button">
                                    <button type="submit" class="btn text-uppercase position-relative">
                                        <span class="button-text">Verify OTP</span>
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
