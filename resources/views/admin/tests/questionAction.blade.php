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

<!-- Edit Quizz Modal -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tests.update-question', ['id' => $row->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Question</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="test_id" value="{{ $row->test_id }}">
                    <input type="hidden" name="type" value="{{ $row->type }}">

                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input name="question" type="text" class="form-control" value="{{ $row->question }}" required>
                    </div>

                    @php
                        $answers = json_decode($row->answer, true);
                    @endphp

                    @if ($row->type === 'multiple')
                        <label class="form-label">Options</label>
                        @foreach ($answers as $index => $answer)
                            <div class="input-group mb-2">
                                <span class="input-group-text">{{ chr(65 + $index) }}</span>
                                <input type="text" name="options[]" class="form-control" value="{{ $answer['answer'] ?? '' }}" required>
                                <span class="input-group-text">
                                    <input type="radio" name="correct_option" value="{{ $index }}" {{ !empty($answer['is_correct']) ? 'checked' : '' }}>
                                </span>
                            </div>
                        @endforeach

                    @elseif ($row->type === 'essay')
                        <div class="mb-3">
                            <label for="essay_answer" class="form-label">Essay Answer</label>
                            <textarea name="essay_answer" class="form-control" required>{{ $answers['essay_answer'] ?? '' }}</textarea>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>


<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteModal-{{ $row->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tests.destroy-question', $row->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Question</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the Question <strong>{{ $row->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>