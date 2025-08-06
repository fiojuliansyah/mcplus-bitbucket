@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Replay Class List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Replay Class
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded py-4 table-space">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Replay Class -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.replay-classes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Replay Class</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <!-- Grade -->
                        <div class="mb-3">
                            <label class="form-label">Grade</label>
                            <select class="form-select" id="gradeDropdown" name="grade_id" required>
                                <option value="">Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select class="form-select" id="subjectDropdown" name="subject_id" required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>

                        <!-- Topic -->
                        <div class="mb-3">
                            <label class="form-label">Topic</label>
                            <select class="form-select" id="topicDropdown" name="topic_id" required>
                                <option value="">Select Topic</option>
                            </select>
                        </div>

                        <!-- Tutor -->
                        <div class="mb-3">
                            <label class="form-label">Tutor</label>
                            <select class="form-select" id="tutorDropdown" name="user_id" required>
                                <option value="">Select Tutor</option>
                            </select>
                        </div>

                        <!-- File Upload (Image/Video) -->
                        <div class="mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" class="form-control" name="upload_file" accept="image/*,video/*" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Replay Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{ asset('admin/assets/js/replay-class-form.js') }}"></script>
    <script>
        // Re-bind dropdowns every time DataTable redraws
        $(document).on('draw.dt', function () {
            if (typeof bindEditDropdowns === 'function') {
                bindEditDropdowns();
            }
        });
    </script>

    
@endpush

