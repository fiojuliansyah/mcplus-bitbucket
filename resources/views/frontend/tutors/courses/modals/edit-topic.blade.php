<!-- resources/views/tutor/courses/modals/edit-topic.blade.php -->
<div class="modal fade" id="editTopicModal-{{ $topic->id }}" tabindex="-1" aria-labelledby="editTopicModalLabel-{{ $topic->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tutor.subjects.update', $topic->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTopicModalLabel-{{ $topic->id }}">Edit Topic</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="topic-name-{{ $topic->id }}" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="topic-name-{{ $topic->id }}" name="name" value="{{ $topic->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active" {{ $topic->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $topic->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>
