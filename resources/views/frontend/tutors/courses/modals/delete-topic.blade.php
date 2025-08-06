<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteTopicModal-{{ $topic->id }}" tabindex="-1" aria-labelledby="deleteTopicModalLabel-{{ $topic->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tutor.subjects.destroy', $topic->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTopicModalLabel-{{ $topic->id }}">Delete Topic</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the topic <strong>{{ $topic->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>