<!-- Edit Modal -->
<div class="modal fade" id="editQuestionModal-{{ $question->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tutor.test-questions.update', ['testQuestionId'=>$question->id]) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="test_id" value="{{ $test->id }}">
        <input type="hidden" name="type" value="{{ $question->type }}">

        <div class="modal-header">
          <h5 class="modal-title">Edit Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>Question</label>
            <textarea class="form-control" name="question" required>{{ $question->question }}</textarea>
          </div>

          @if($question->type === 'multiple')
            @php $decoded = json_decode($question->answer, true); @endphp
            <label>Options</label>
            <small class="text-muted d-block mb-2">Mark the correct answer using the radio button.</small>
            <div id="edit-options-wrapper-{{ $question->id }}">
                @foreach($decoded as $i => $option)
                <div class="input-group mb-2">
                    <span class="input-group-text bg-secondary">{{ chr(65 + $i) }}</span>
                    <input type="text" name="options[]" class="form-control" value="{{ $option['answer'] }}">
                    <div class="input-group-text" style="background-color: #424242">
                        <input type="radio" name="correct_option" value="{{ $i }}" {{ $option['is_correct'] ? 'checked' : '' }} class="form-check-input mt-0">
                        <label class="ms-1 mb-0 small">Correct</label>
                    </div>
                  </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-success edit-add-option-btn" id="edit-add-option-btn-{{ $question->id }}">+ Add Option</button>
          @else
            <label>Essay Answer</label>
            <textarea class="form-control" name="essay_answer">{{ json_decode($question->answer, true)['essay_answer'] ?? '' }}</textarea>
          @endif
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
