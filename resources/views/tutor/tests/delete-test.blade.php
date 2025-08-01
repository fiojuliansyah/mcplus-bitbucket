<!-- Delete Modal -->
<div class="modal fade" id="deleteQuestionModal-{{ $question->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tutor.test-questions.destroy', $question->id) }}" method="POST">
        @csrf @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title">Delete Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this question?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>