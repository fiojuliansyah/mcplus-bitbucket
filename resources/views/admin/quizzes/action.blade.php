<!-- Action Buttons for Each Quizz -->
<div class="flex align-items-center list-user-action">
    <!-- Edit Button -->
    <a class="btn btn-sm btn-icon btn-success rounded" data-bs-toggle="modal" data-bs-target="#editQuizzModal-{{ $row->id }}">
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

<!-- Edit Quizz Modal -->
<div class="modal fade" id="editQuizzModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editQuizzModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.quizzes.update', $row->id) }}" method="POST">
            {{-- <form action="" method="POST"> --}}
                @csrf
                @method('PUT')

                <input type="hidden" name="grade_id" value="{{ $row->grade_id }}">
                <input type="hidden" name="subject_id" value="{{ $row->subject_id }}">
                <input type="hidden" name="topic_id" value="{{ $row->topic_id }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="editQuizzModalLabel-{{ $row->id }}">Edit Quizz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <!-- Tutor -->
                    <div class="mb-3">
                        <label class="form-label">Tutor</label>
                        <select class="form-select" name="user_id" required>
                            @if($tutors->isEmpty())
                                <option value="">No tutor available</option>
                            @else
                                <option value="">Select Tutor</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->user_id }}"
                                        {{ $row->user_id == $tutor->user_id ? 'selected' : '' }}>
                                        {{ $tutor->user->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Question -->
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ $row->question }}" required>
                    </div>

                    <!-- Answers Section -->
                    <div class="mb-3">
                        <label class="form-label d-block">Answers</label>
                        <small class="text-muted d-block mb-2">Mark the correct answer using the radio button.</small>

                        <div id="edit-options-wrapper-{{ $row->id }}">
                            @php
                                $answers = json_decode($row->multiple_choice, true);
                            @endphp

                            @if (is_array($answers) && count($answers) > 0)
                                @foreach ($answers as $index => $answer)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">{{ chr(65 + $index) }}</span>
                                        <input type="text" name="options[]" class="form-control" value="{{ $answer['answer'] ?? '' }}" required>
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_option" value="{{ $index }}"
                                                class="form-check-input mt-0"
                                                {{ !empty($answer['is_correct']) ? 'checked' : '' }} required>
                                            <label class="ms-1 mb-0 small">Correct</label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Default one input (A) if no answers available --}}
                                <div class="input-group mb-2">
                                    <span class="input-group-text">A</span>
                                    <input type="text" name="options[]" class="form-control" required>
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_option" value="0" class="form-check-input mt-0" required>
                                        <label class="ms-1 mb-0 small">Correct</label>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <button type="button"
                                class="btn btn-sm btn-outline-success edit-add-option-btn"
                                id="edit-add-option-btn-{{ $row->id }}">
                            + Add Option
                        </button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Quizz</button>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteModal-{{ $row->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.quizzes.destroy', $row->id) }}" method="POST">
            {{-- <form action="" method="POST"> --}}
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Quizz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete question <strong>"{{ $row->question }}"</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

