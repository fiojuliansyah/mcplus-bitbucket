    <div class="flex align-items-center list-user-action">
        <!-- Edit Button -->
        <a class="btn btn-sm btn-icon btn-success rounded" data-bs-toggle="modal"
            data-bs-target="#editModal-{{ $row->id }}">
            <span class="btn-inner">
                <i class="fa-solid fa-pencil fa-xs"></i>
            </span>
        </a>

        <!-- Delete Button -->
        <a class="btn btn-sm btn-icon btn-danger rounded" data-bs-toggle="modal"
            data-bs-target="#deleteModal-{{ $row->id }}">
            <span class="btn-inner">
                <i class="fa-solid fa-trash fa-xs"></i>
            </span>
        </a>
    </div>

    <!-- Modal Edit Plan -->
    <div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1"
        aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.plans.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Plan</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Plan Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plan Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $row->name }}"
                                    required>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" value="{{ $row->price }}"
                                    required>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration</label>
                                <select class="form-control" name="duration" required>
                                    <option value="week" {{ $row->duration == 'week' ? 'selected' : '' }}>Week
                                    </option>
                                    <option value="month" {{ $row->duration == 'month' ? 'selected' : '' }}>Month
                                    </option>
                                    <option value="year" {{ $row->duration == 'year' ? 'selected' : '' }}>Year
                                    </option>
                                </select>
                            </div>

                            <!-- Duration Value -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration Value</label>
                                <input type="text" class="form-control" name="duration_value"
                                    value="{{ $row->duration_value }}" required>
                            </div>

                            <!-- Device Limit Toggle -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Device Limit</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        id="deviceLimitToggle-{{ $row->id }}"
                                        {{ $row->device_limit ? 'checked' : '' }}>
                                    <label class="form-check-label" for="deviceLimitToggle-{{ $row->id }}">Enable
                                        Device Limit</label>
                                </div>
                            </div>

                            <!-- Device Limit Form (hidden by default) -->
                            <div class="col-md-6 mb-3" id="deviceLimitField-{{ $row->id }}"
                                style="display: {{ $row->device_limit ? 'block' : 'none' }};">
                                <label class="form-label">Device Limit</label>
                                <input type="text" class="form-control" name="device_limit"
                                    value="{{ $row->device_limit }}">
                            </div>

                            <!-- Profile Limit Toggle -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profile Limit</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        id="profileLimitToggle-{{ $row->id }}"
                                        {{ $row->profile_limit ? 'checked' : '' }}>
                                    <label class="form-check-label" for="profileLimitToggle-{{ $row->id }}">Enable
                                        Profile Limit</label>
                                </div>
                            </div>

                            <!-- Profile Limit Form (hidden by default) -->
                            <div class="col-md-6 mb-3" id="profileLimitField-{{ $row->id }}"
                                style="display: {{ $row->profile_limit ? 'block' : 'none' }};">
                                <label class="form-label">Profile Limit</label>
                                <input type="text" class="form-control" name="profile_limit"
                                    value="{{ $row->profile_limit }}">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="active" {{ $row->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $row->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required>{{ $row->description }}</textarea>
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
    <div class="modal fade" id="deleteModal-{{ $row->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel-{{ $row->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.plans.destroy', $row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the plan <strong>{{ $row->name }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
            <script>
                document.getElementById('deviceLimitToggle-{{ $row->id }}').addEventListener('change', function () {
                    var deviceLimitField = document.getElementById('deviceLimitField-{{ $row->id }}');
                    deviceLimitField.style.display = this.checked ? 'block' : 'none';
                });

                document.getElementById('profileLimitToggle-{{ $row->id }}').addEventListener('change', function () {
                    var profileLimitField = document.getElementById('profileLimitField-{{ $row->id }}');
                    profileLimitField.style.display = this.checked ? 'block' : 'none';
                });
            </script>
    @endpush
