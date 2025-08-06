@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">

                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="mb-3">
                        <h5>Settings</h5>
                    </div>				
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">Name&nbsp; <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">Email address&nbsp; <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label class="mb-2">Phone&nbsp; <span class="text-danger">*</span></label>
                                        <input type="email" name="phone" value="{{ $user->phone }}" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <h4 class="mb-3">Password change</h4>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">New password (leave blank to leave unchanged)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">Confirm new password</label>
                                        <input type="password" name="password" class="form-control">  
                                    </div>
                                    <div class="form-group">
                                        <div class="iq-button">
                                            <a href="javascript:void(0)" class="btn btn-secondary text-uppercase position-relative">
                                                <span class="button-text">save changes</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-5">
                        <div class="card-body">	
                            <h5 class="fs-18 mb-3">Delete Account</h5>								
                            <h6 class="mb-1">Are you sure you want to delete your account?</h6>
                            <p class="mb-3">Refers to the action of permanently removing a user's account and associated data from a system, service and platform.</p>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#delete_account">Delete Account</a>	
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @endsection