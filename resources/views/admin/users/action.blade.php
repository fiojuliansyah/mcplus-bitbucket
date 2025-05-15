<div class="flex align-items-center list-user-action">
    <!-- Edit Button -->
    <a class="btn btn-sm btn-icon btn-success rounded" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
        <span class="btn-inner">
            <i class="fa-solid fa-pencil fa-xs"></i>
        </span>
    </a>

    <!-- Delete Button -->
    <a class="btn btn-sm btn-icon btn-danger rounded delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
        <span class="btn-inner">
            <i class="fa-solid fa-trash fa-xs"></i>
        </span>
    </a>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName-{{ $row->id }}" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName-{{ $row->id }}" name="name" value="{{ $row->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail-{{ $row->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail-{{ $row->id }}" name="email" value="{{ $row->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone-{{ $row->id }}" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone-{{ $row->id }}" name="phone" value="{{ $row->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAccountType-{{ $row->id }}" class="form-label">Account Type</label>
                        <select class="form-select" id="editAccountType-{{ $row->id }}" name="account_type" required>
                            <option value="student" {{ $row->account_type == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="parent" {{ $row->account_type == 'parent' ? 'selected' : '' }}>Parent</option>
                            <option value="tutor" {{ $row->account_type == 'tutor' ? 'selected' : '' }}>Tutor</option>
                            <option value="admin" {{ $row->account_type == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus-{{ $row->id }}" class="form-label">Status</label>
                        <select class="form-select" id="editStatus-{{ $row->id }}" name="status" required>
                            <option value="active" {{ $row->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="deactive" {{ $row->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Select Roles</label>
                        <select name="roles[]" id="roles" class="form-control" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $row->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
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
            <form action="{{ route('admin.users.destroy', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete user <strong>{{ $row->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
