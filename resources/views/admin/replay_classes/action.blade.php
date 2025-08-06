<!-- Action Buttons for Each Replay Class -->
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

<!-- Modal Edit Replay Class -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.replay-classes.update', $row->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Replay Class</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">

                    <!-- Grade -->
                    <div class="mb-3">
                        <label class="form-label">Grade</label>
                        <select class="form-select" id="editGradeDropdown-{{ $row->id }}" name="grade_id" required>
                            <option value="">Select Grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}" {{ $row->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <select class="form-select" id="editSubjectDropdown-{{ $row->id }}" name="subject_id" required>
                            @if($row->subject)
                                <option value="{{ $row->subject->id }}">{{ $row->subject->name }}</option>
                            @else
                                <option value="">Select Subject</option>
                            @endif
                        </select>
                    </div>

                    <!-- Topic -->
                    <div class="mb-3">
                        <label class="form-label">Topic</label>
                        <select class="form-select" id="editTopicDropdown-{{ $row->id }}" name="topic_id" required>
                            @if($row->topic)
                                <option value="{{ $row->topic->id }}">{{ $row->topic->name }}</option>
                            @else
                                <option value="">Select Topic</option>
                            @endif
                        </select>
                    </div>

                    <!-- Tutor -->
                    <div class="mb-3">
                        <label class="form-label">Tutor</label>
                        <select class="form-select" id="editTutorDropdown-{{ $row->id }}" name="user_id" required>
                            @if($row->user)
                                <option value="{{ $row->user->id }}">{{ $row->user->name }}</option>
                            @else
                                <option value="">Select Tutor</option>
                            @endif
                        </select>
                    </div>

                    <!-- File Upload (Image/Video) -->
                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="1" id="updateMediaCheck-{{ $row->id }}" name="update_media">
                            <label class="form-check-label" for="updateMediaCheck-{{ $row->id }}">
                                Check to update replay video
                            </label>
                        </div>
                        <input type="file" class="form-control" name="upload_file" accept="image/*,video/*" id="mediaInput-{{ $row->id }}">
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
            <form action="{{ route('admin.replay-classes.destroy', $row->id) }}" method="POST">
            {{-- <form action="" method="POST"> --}}
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Replay Class</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the replay class <strong>{{ $row->topic->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

