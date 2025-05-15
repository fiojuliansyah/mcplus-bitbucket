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

<!-- Modal Edit Subject -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.subjects.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Assign To Grade</label>
                        <input type="text" class="form-control" value="{{ $row->grade->name }}" disabled>
                        <input type="hidden" class="form-control" name="grade_id" value="{{ $row->grade->id }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $row->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image <small>(optional)</small></label>
                        <input type="file" class="form-control" name="image">
                        @if($row->image)
                            <img src="{{ Storage::disk('public')->url($row->image) }}" alt="Subject Image" class="img-thumbnail mt-2" width="100">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trailer <small>(optional)</small></label>
                        <input type="url" class="form-control" name="trailer" value="{{ $row->trailer }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active" {{ $row->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $row->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
            <form action="{{ route('admin.subjects.destroy', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the subject <strong>{{ $row->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>