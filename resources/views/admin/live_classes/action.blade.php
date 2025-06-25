<!-- Action Buttons for Each Live Class -->
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

<!-- Modal Edit Live Class -->
<!-- Modal Edit Live Class -->
<div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <form action="{{ route('admin.live_classes.update', $row->id) }}" method="POST"> --}}
            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel-{{ $row->id }}">Edit Live Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Topic</label>
                        <input type="text" class="form-control" name="topic" value="{{ $row->topic }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agenda</label>
                        <textarea class="form-control" name="agenda" rows="3" required>{{ $row->agenda }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" name="start_time" value="{{ \Carbon\Carbon::parse($row->start_time)->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration (Minutes)</label>
                        <input type="number" class="form-control" name="duration" value="{{ $row->duration }}" required>
                    </div>

                    <!-- Zoom Settings -->
                    <div class="mb-3">
                        <label class="form-label">Zoom Settings</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="settings[join_before_host]" value="1" {{ isset($row->settings['join_before_host']) && $row->settings['join_before_host'] ? 'checked' : '' }}>
                            <label class="form-check-label">Join Before Host</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="settings[host_video]" value="1" {{ isset($row->settings['host_video']) && $row->settings['host_video'] ? 'checked' : '' }}>
                            <label class="form-check-label">Host Video</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="settings[participant_video]" value="1" {{ isset($row->settings['participant_video']) && $row->settings['participant_video'] ? 'checked' : '' }}>
                            <label class="form-check-label">Participant Video</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="settings[mute_upon_entry]" value="1" {{ isset($row->settings['mute_upon_entry']) && $row->settings['mute_upon_entry'] ? 'checked' : '' }}>
                            <label class="form-check-label">Mute Upon Entry</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="settings[waiting_room]" value="1" {{ isset($row->settings['waiting_room']) && $row->settings['waiting_room'] ? 'checked' : '' }}>
                            <label class="form-check-label">Waiting Room</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Audio</label>
                            <select class="form-select" name="settings[audio]">
                                <option value="both" {{ isset($row->settings['audio']) && $row->settings['audio'] == 'both' ? 'selected' : '' }}>Both</option>
                                <option value="telephony" {{ isset($row->settings['audio']) && $row->settings['audio'] == 'telephony' ? 'selected' : '' }}>Telephony</option>
                                <option value="voip" {{ isset($row->settings['audio']) && $row->settings['audio'] == 'voip' ? 'selected' : '' }}>VoIP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto Recording</label>
                            <select class="form-select" name="settings[auto_recording]">
                                <option value="none" {{ isset($row->settings['auto_recording']) && $row->settings['auto_recording'] == 'none' ? 'selected' : '' }}>None</option>
                                <option value="local" {{ isset($row->settings['auto_recording']) && $row->settings['auto_recording'] == 'local' ? 'selected' : '' }}>Local</option>
                                <option value="cloud" {{ isset($row->settings['auto_recording']) && $row->settings['auto_recording'] == 'cloud' ? 'selected' : '' }}>Cloud</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Approval Type</label>
                            <select class="form-select" name="settings[approval_type]">
                                <option value="0" {{ isset($row->settings['approval_type']) && $row->settings['approval_type'] == 0 ? 'selected' : '' }}>Automatically Approve</option>
                                <option value="1" {{ isset($row->settings['approval_type']) && $row->settings['approval_type'] == 1 ? 'selected' : '' }}>Manually Approve</option>
                                <option value="2" {{ isset($row->settings['approval_type']) && $row->settings['approval_type'] == 2 ? 'selected' : '' }}>No Registration Required</option>
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


<!-- Modal Confirm Delete -->
<div class="modal fade" id="deleteModal-{{ $row->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <form action="{{ route('admin.live-classes.destroy', $row->id) }}" method="POST"> --}}
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $row->id }}">Delete Live Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the live class <strong>{{ $row->topic }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
