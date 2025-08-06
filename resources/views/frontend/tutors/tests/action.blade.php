<!-- Edit Test Modal -->
<div class="modal fade" id="editTestModal-{{ $test->id }}" tabindex="-1" aria-labelledby="editTestModalLabel-{{ $test->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('tutor.tests.update', $test->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editTestModalLabel-{{ $test->id }}">Edit Test</h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="isax isax-close-circle5"></i>
            </button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">Test Name</label>
              <input type="text" name="name" value="{{ $test->name }}" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Start Time</label>
              <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($test->start_time)->format('Y-m-d\TH:i') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">End Time</label>
              <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($test->end_time)->format('Y-m-d\TH:i') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="draft" @selected($test->status == 'draft')>Draft</option>
                    <option value="publish" @selected($test->status == 'publish')>Publish</option>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Delete Test Modal -->
<div class="modal fade" id="deleteTestModal-{{ $test->id }}" tabindex="-1" aria-labelledby="deleteTestModalLabel-{{ $test->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tutor.tests.destroy', $test->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="deleteTestModalLabel-{{ $test->id }}">Delete Test</h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="isax isax-close-circle5"></i>
            </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong>{{ $test->name }}</strong>?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
