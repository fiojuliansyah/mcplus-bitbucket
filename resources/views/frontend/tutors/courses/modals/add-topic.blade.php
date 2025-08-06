<!-- Add Topic Modal -->
<div class="modal fade" id="addTopicModal-{{ $subject->id }}" tabindex="-1" aria-labelledby="addTopicModalLabel-{{ $subject->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('tutor.subjects.store') }}">
      @csrf
      <input type="hidden" name="subject_id" value="{{ $subject->id }}">
      <input type="hidden" name="grade_id" value="{{ $subject->grade_id }}">
      <input type="hidden" name="type" value="2">
      <input type="hidden" name="settings" value="tbd">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTopicModalLabel-{{ $subject->id }}">Add Topic to {{ $subject->name }}</h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="topic" required>
          </div>

          <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-select" name="status" required>
                  <option value="active"  >Active</option>
                  <option value="inactive">Inactive</option>
              </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create Topic</button>
        </div>
      </div>
    </form>
  </div>
</div>
