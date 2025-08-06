<!-- Add Topic Modal -->
<div class="modal fade" id="addClassModal-{{ $subject->id }}" tabindex="-1" aria-labelledby="addClassModalLabel-{{ $subject->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('tutor.subjects.store') }}">
      @csrf
      <input type="hidden" name="subject_id" value="{{ $subject->id }}">
      <input type="hidden" name="grade_id" value="{{ $subject->grade_id }}">
      <input type="hidden" name="type" value="2">
      <input type="hidden" name="settings" value="tbd">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addClassModalLabel-{{ $subject->id }}">Add Class to {{ $subject->name }}</h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="isax isax-close-circle5"></i>
            </button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Topic</label>
            <input type="text" class="form-control" name="topic" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Agenda</label>
            <textarea class="form-control" name="agenda" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Duration</label>
            <input type="text" class="form-control" name="duration" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Timezone</label>
            <select class="form-select" name="timezone" required>
              <option value="Asia/Jakarta">Asia/Jakarta</option>
              <option value="Asia/Bangkok">Asia/Bangkok</option>
              <option value="UTC">UTC</option>
              <!-- Add more as needed -->
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" class="form-control" name="password" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" name="start_time" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Zoom Meeting ID</label>
            <input type="text" class="form-control" name="zoom_meeting_id" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Zoom Join URL</label>
            <input type="url" class="form-control" name="zoom_join_url" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
              <option value="">Select Option</option>
              <option value="Coming Soon">Coming Soon</option>
              <option value="On Going">On Going</option>
              <option value="Done">Done</option>
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
