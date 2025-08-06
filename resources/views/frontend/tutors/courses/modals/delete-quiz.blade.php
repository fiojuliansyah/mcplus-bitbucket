<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteQuizModal-{{ $quiz->id }}" tabindex="-1" aria-labelledby="deleteQuizzModalLabel-{{ $quiz->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tutor.topic.quizzes.destroy', $quiz->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteQuizzModalLabel-{{ $quiz->id }}">Delete Quizz</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
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