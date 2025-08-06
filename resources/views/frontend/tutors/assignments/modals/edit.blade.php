<div class="modal fade" id="editTestModal-{{ $test->id }}" tabindex="-1" aria-labelledby="editTestModalLabel-{{ $test->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('tutor.tests.update', $test->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestModalLabel-{{ $test->id }}">Edit Test</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Subject</label>
                            <select class="form-select" name="subject_id" required>
                                <option value="">Select a Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" @selected($test->subject_id == $subject->id)>
                                        {{ $subject->name }} ({{ $subject->grade->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Test Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $test->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" name="start_time" value="{{ \Carbon\Carbon::parse($test->start_time)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" name="end_time" value="{{ \Carbon\Carbon::parse($test->end_time)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="draft" @selected($test->status == 'draft')>Draft</option>
                                <option value="publish" @selected($test->status == 'publish')>Publish</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Test</button>
                </div>
            </div>
        </form>
    </div>
</div>