@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Coupon List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Coupon
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

    <!-- Modal Create Coupon -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Coupon</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Code</label>
                                <input type="text" class="form-control" name="code" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Coupon Type</label>
                                <select class="form-control" name="type" required>
                                    <option value="percentage">Percentage</option>
                                    <option value="amount">Amount</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Amount</label>
                                <input type="text" class="form-control" name="amount" required>
                            </div>

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
                        <button type="submit" class="btn btn-primary">Save Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
@endpush
