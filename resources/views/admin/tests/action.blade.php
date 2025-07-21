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

<!-- Modal Edit Test -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tests.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Test Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $row->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" name="start_time" value="{{ $row->start_time }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" name="end_time" value="{{ $row->end_time }}" required>
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
            <form action="{{ route('admin.tests.destroy', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the Test <strong>{{ $row->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>