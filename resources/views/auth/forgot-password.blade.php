
@extends('layouts.auth')

@section('content')
   <div class="vh-100"
        style="background: url('/frontend/assets/images/pages/bg-auth.jpg'); background-size: cover; background-repeat: no-repeat; position: relative;min-height:500px">
        <div class="container">
            <div class="row justify-content-center align-items-center height-self-center vh-100">
                <div class="col-lg-5 col-md-12 align-self-center">
                    <div class="user-login-card bg-body">
                        <div class="text-center">
                            <!--Logo -->
                            <div class="logo-default">
                                <a class="navbar-brand text-primary" href="./index.html">
                                    <img class="img-fluid logo" src="/frontend/assets/images/logo-example.png"
                                        loading="lazy" alt="Mcplus Premium" />
                                </a>
                            </div>
                        </div>

                        <!-- Form -->
                        <form id="email-login-form" action="{{ route('password.email') }}" method="POST">
                            @csrf
                           <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                            <div id="email-login-form">
                                <div class="mb-3">
                                    <input type="text" name="email" placeholder="Email" class="form-control rounded-0" :value="old('login')" required autofocus>
                                </div>
                                <label
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


