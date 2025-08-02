@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Live Class List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Live Class
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

    <!-- Modal Create Live Class -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.live-classes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Live Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Grade</label>
                            <select class="form-select" id="gradeDropdown" name="grade_id" required>
                                <option value="">Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select class="form-select" id="subjectDropdown" name="subject_id" required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Topic</label>
                            <select class="form-select" id="topicDropdown" name="topic_id" required>
                                <option value="">Select Topic</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tutor</label>
                            <select class="form-select" id="tutorDropdown" name="user_id" required>
                                <option value="">Select Tutor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agenda</label>
                            <textarea class="form-control" name="agenda" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" class="form-control" name="duration" required>
                        </div>

                        <!-- Zoom Settings -->
                        <div class="mb-3">
                            <label class="form-label">Zoom Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="settings[join_before_host]" value="1">
                                <label class="form-check-label">Join Before Host</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="settings[host_video]" value="1">
                                <label class="form-check-label">Host Video</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="settings[participant_video]" value="1">
                                <label class="form-check-label">Participant Video</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="settings[mute_upon_entry]" value="1">
                                <label class="form-check-label">Mute Upon Entry</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="settings[waiting_room]" value="1">
                                <label class="form-check-label">Waiting Room</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Audio</label>
                                <select class="form-select" name="settings[audio]">
                                    <option value="both">Both</option>
                                    <option value="telephony">Telephony</option>
                                    <option value="voip">VoIP</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Auto Recording</label>
                                <select class="form-select" name="settings[auto_recording]">
                                    <option value="none">None</option>
                                    <option value="local">Local</option>
                                    <option value="cloud">Cloud</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Approval Type</label>
                                <select class="form-select" name="settings[approval_type]">
                                    <option value="0">Automatically Approve</option>
                                    <option value="1">Manually Approve</option>
                                    <option value="2">No Registration Required</option>
                                </select>
                            </div>
                            <input type="hidden" name="type" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Live Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{ asset('admin/assets/js/live-class-form.js') }}"></script>
<<<<<<< HEAD
    <script>
        // Re-bind dropdowns every time DataTable redraws
        $(document).on('draw.dt', function () {
            if (typeof bindEditDropdowns === 'function') {
                bindEditDropdowns();
            }
        });
    </script>
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
@endpush

