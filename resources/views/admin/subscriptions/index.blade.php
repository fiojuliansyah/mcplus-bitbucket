@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Subscription List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Subscription
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded py-4 table-space">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Subscription -->
    <!-- Modal Create Subscription -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Subscription</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- User Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">User</label>
                                <select class="form-control" name="user_id" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Profile Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profile</label>
                                <select class="form-control" name="profile_id">
                                    @foreach ($profiles as $profile)
                                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Plan Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plan</label>
                                <select class="form-control" name="plan_id">
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" required>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Method</label>
                                <input type="text" class="form-control" name="payment_method" required>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date" required>
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date" required>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" required>
                            </div>

                            <!-- Coupon Discount -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Discount</label>
                                <input type="text" class="form-control" name="coupon_discount">
                            </div>

                            <!-- Tax -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax</label>
                                <input type="text" class="form-control" name="tax">
                            </div>

                            <!-- Total Amount -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Amount</label>
                                <input type="text" class="form-control" name="total_amount" required>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Subscription</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
@endpush
