
<a href="#" class="badge bg-light" style="color: #333;" data-bs-toggle="modal" data-bs-target="#subjectModal-{{ $row->id }}">
    <i class="fas fa-book" style="color: #333;"></i>
    Subjects
</a>
<a href="#" class="badge bg-light" style="color: #333;" data-bs-toggle="modal" data-bs-target="#subjectModal-{{ $row->id }}">
    <i class="fas fa-circle" style="color: red;"></i>
    Live class
</a>

<div class="modal fade" id="subjectModal-{{ $row->id }}" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="subjectModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @foreach ($subjects->groupBy('grade_id') as $gradeId => $subjectGroup)
                            <div class="pb-5">
                                <strong>{{ $subjectGroup->first()->grade->name }}</strong>
                                <div class="pt-3">
                                    @foreach ($subjectGroup as $subject)
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}">
                                            <span class="form-check-label">{{ $subject->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
