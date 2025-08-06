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

<!-- Modal Edit Subscription -->
<!-- Modal Edit Subscription -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.subscriptions.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Subscription</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- User Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User</label>
                            <select class="form-control" name="user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $row->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Profile Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile</label>
                            <select class="form-control" name="profile_id" required>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}" {{ $profile->id == $row->profile_id ? 'selected' : '' }}>{{ $profile->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Plan Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan</label>
                            <select class="form-control" name="plan_id" required>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ $plan->id == $row->plan_id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Duration</label>
                            <input type="text" class="form-control" name="duration" value="{{ $row->duration }}" required>
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Method</label>
                            <input type="text" class="form-control" name="payment_method" value="{{ $row->payment_method }}" required>
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

                        <!-- Price -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" class="form-control" name="price" value="{{ $row->price }}" required>
                        </div>

                        <!-- Coupon Discount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Discount</label>
                            <input type="text" class="form-control" name="coupon_discount" value="{{ $row->coupon_discount }}">
                        </div>

                        <!-- Tax -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tax</label>
                            <input type="text" class="form-control" name="tax" value="{{ $row->tax }}">
                        </div>

                        <!-- Total Amount -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="text" class="form-control" name="total_amount" value="{{ $row->total_amount }}" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status" required>
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
            <form action="{{ route('admin.subscriptions.destroy', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Subscription</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the subscription <strong>{{ $row->id }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
