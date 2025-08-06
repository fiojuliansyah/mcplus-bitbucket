<div class="modal fade" id="createQuizModal" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('tutor.topic.quizzes.store', ['slug' => $topic->slug]) }}" method="POST">
        <form action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createQuizModalLabel">Create Quizz</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>

                <div class="modal-body">
                    {{-- Hidden IDs --}}
                    <input type="hidden" name="grade_id" value="{{ $topic->grade_id }}">
                    <input type="hidden" name="subject_id" value="{{ $topic->subject_id }}">
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">


                    {{-- Question Input --}}
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>

                    {{-- Multiple Choice Options --}}
                    <div class="mb-3">
                        <label class="form-label d-block">Options & Correct Answer</label>
                        <small class="text-muted d-block mb-2">Mark the correct answer using the radio button.</small>

                        <div id="options-wrapper">
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-secondary">A</span>
                                <input type="text" name="options[]" class="form-control" required>
                                <div class="input-group-text bg-secondary">
                                    <input class="form-check-input mt-0" type="radio" name="correct_option" value="0" required>
                                    <label class="ms-1 mb-0 small">Correct</label>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-success" id="add-option-btn">+ Add Option</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Quizz</button>
                </div>
            </div>
        </form>
    </div>
</div>
