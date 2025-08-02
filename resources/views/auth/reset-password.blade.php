@extends('layouts.auth')

@section('content')
   <div class="vh-100"
        style="background: url('/frontend/assets/images/pages/bg-auth.jpg'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center vh-100">
                <div class="col-lg-5 col-md-12 align-self-center">
                    <div class="user-login-card bg-body">
                        <div class="text-center">
                            <div class="logo-default">
                                <a class="navbar-brand text-primary" href="./index.html">
                                    <img class="img-fluid logo" src="/frontend/assets/images/logo-example.png"
                                        loading="lazy" alt="Mcplus Premium" />
                                </a>
                            </div>
                        </div>

                        <form id="email-login-form" method="POST" action="{{ route('password.store') }}">
                        @csrf
                           <p>Enter new password and confirm password</p>
                            <div id="email-login-form">
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <input type="hidden" name="email" value="{{ $request->email }}">
                                <div class="mb-3">
                                    <input type="password" name="password" placeholder="password" class="form-control rounded-0">
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control rounded-0">
                                </div>
                                <div class="full-button">
                                    <div class="iq-button">
                                        <button type="submit" class="btn text-uppercase position-relative">
                                            <span class="button-text">Submit</span>
                                            <i class="fa-solid fa-play"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


