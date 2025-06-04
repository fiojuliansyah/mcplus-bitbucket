@extends('layouts.auth')

@section('content')
    <div class="vh-100"
        style="background: url('/frontend/assets/images/pages/bg-auth.jpg'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center vh-100">
                <div class="col-lg-8 col-md-12 align-self-center">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="user-login-card bg-body">
                            <h4 class="text-center mb-5">Create Your Account</h4>
                            <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-5">
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Name</label>
                                    <input type="text" name="name" class="form-control rounded-0" required="">
                                </div>
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Email *</label>
                                    <input type="email" class="form-control rounded-0" required="">
                                </div>
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Phone</label>
                                    <input type="text" name="phone" class="form-control rounded-0" required="">
                                </div>
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Student/Parent</label>
                                    <select name="account_type" class="form-control">
                                        <option value="">Choose</option>
                                        <option value="student">Student</option>
                                        <option value="parent">Parent</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Password *</label>
                                    <input type="password" name="password" class="form-control rounded-0" required="">
                                </div>
                                <div class="col">
                                    <label class="text-white fw-500 mb-2">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" class="form-control rounded-0"
                                        required="">
                                </div>
                            </div>
                            <label class="list-group-item d-flex align-items-center mt-5 mb-3 text-white"><input
                                    class="form-check-input m-0 me-2" type="checkbox">I've read and accept the <a
                                    href="terms-of-use.html" class="ms-1">terms & conditions*</a></label>
                            <div class="row text-center">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="full-button">
                                        <div class="iq-button">
                                            <button type="submit" class="btn text-uppercase position-relative">
                                                <span class="button-text">Sign Up</span>
                                                <i class="fa-solid fa-play"></i>
                                            </button>
                                        </div>
                                        <p class="mt-2 mb-0 fw-normal">Already have an account?<a
                                                href="{{ route('login') }}" class="ms-1">Login</a></p>
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
