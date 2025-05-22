<div class="flex align-items-center list-user-action">
    <!-- Edit Button -->
    <a class="btn btn-sm btn-icon btn-success rounded" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
        <span class="btn-inner">
            <i class="fa-solid fa-pencil fa-xs"></i>
        </span>
    </a>

    <!-- Delete Button -->
    <a class="btn btn-sm btn-icon btn-danger rounded" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
        <span class="btn-inner">
            <i class="fa-solid fa-trash fa-xs"></i>
        </span>
    </a>
</div>

<!-- Modal Edit Coupon -->
<!-- Modal Edit Coupon -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.coupons.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Coupon Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $row->name }}" required>
                        </div>

                        <!-- Coupon Code -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" name="code" value="{{ $row->code }}" required>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date" value="{{ $row->start_date }}" required>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date" value="{{ $row->end_date }}" required>
                        </div>

                        <!-- Coupon Type -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Type</label>
                            <select class="form-control" name="type" required>
                                <option value="percentage" {{ $row->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="amount" {{ $row->type == 'amount' ? 'selected' : '' }}>Amount</option>
                            </select>
                        </div>

                        <!-- Coupon Amount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control" name="amount" value="{{ $row->amount }}" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="active" {{ $row->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $row->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
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


<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteModal-{{ $row->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.coupons.destroy', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the coupon <strong>{{ $row->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
