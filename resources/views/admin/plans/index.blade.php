@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Plan List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Plan
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

    <!-- Modal Create Plan -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Plan Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plan Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" required>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration</label>
                                <select class="form-control" name="duration" required>
                                    <option value="week">Week</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>

                            <!-- Duration Value -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration Value</label>
                                <input type="text" class="form-control" name="duration_value" required>
                            </div>

                            <!-- Device Limit Toggle -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Device Limit</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="deviceLimitToggle">
                                    <label class="form-check-label" for="deviceLimitToggle">Enable Device Limit</label>
                                </div>
                            </div>

                            <!-- Device Limit Form (hidden by default) -->
                            <div class="col-md-6 mb-3" id="deviceLimitField" style="display: none;">
                                <label class="form-label">Device Limit</label>
                                <input type="text" class="form-control" name="device_limit">
                            </div>

                            <!-- Profile Limit Toggle -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profile Limit</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="profileLimitToggle">
                                    <label class="form-check-label" for="profileLimitToggle">Enable Profile Limit</label>
                                </div>
                            </div>

                            <!-- Profile Limit Form (hidden by default) -->
                            <div class="col-md-6 mb-3" id="profileLimitField" style="display: none;">
                                <label class="form-label">Profile Limit</label>
                                <input type="text" class="form-control" name="profile_limit">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}

    <script>
        document.getElementById('deviceLimitToggle').addEventListener('change', function () {
            var deviceLimitField = document.getElementById('deviceLimitField');
            deviceLimitField.style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('profileLimitToggle').addEventListener('change', function () {
            var profileLimitField = document.getElementById('profileLimitField');
            profileLimitField.style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endpush
