<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteQuizzModal-{{ $quizz->id }}" tabindex="-1" aria-labelledby="deleteQuizzModalLabel-{{ $quizz->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tutor.topic.quizzes.destroy', $quizz->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteQuizzModalLabel-{{ $quizz->id }}">Delete Quizz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this quizz?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>