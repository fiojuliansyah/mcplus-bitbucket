<div class="modal fade" id="editQuizModal-{{ $quiz->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('tutor.topic.quizzes.update', [$topic->id, $quiz->id]) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Quiz</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" value="{{ $quiz->question }}">
                    </div>

                    @php
                        $choices = json_decode($quiz->multiple_choice, true);
                        $letters = range('A', 'Z');
                    @endphp

                    {{-- 🟢 Add wrapper div below --}}
                    <div id="edit-options-wrapper-{{ $quiz->id }}">
                        @foreach ($choices as $index => $choice)
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-secondary">{{ chr(65 + $index) }}</span>
                                <input type="text" name="options[]" class="form-control" value="{{ $choice['answer'] ?? '' }}" required>
                                <div class="input-group-text bg-secondary">
                                    <input type="radio" name="correct_option" value="{{ $index }}"
                                        class="form-check-input mt-0"
                                        {{ !empty($choice['is_correct']) ? 'checked' : '' }} required>
                                    <label class="ms-1 mb-0 small">Correct</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button"
                            class="btn btn-sm btn-outline-success edit-add-option-btn"
                            id="edit-add-option-btn-{{ $topic->id }}">
                        + Add Option
                    </button>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Update Quiz</button>
                </div>
            </div>
        </form>
    </div>
</div>
