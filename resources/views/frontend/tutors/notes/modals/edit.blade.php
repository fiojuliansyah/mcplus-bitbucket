<div class="modal fade" id="editNoteModal-{{ $note->id }}" tabindex="-1" aria-labelledby="editNoteModalLabel-{{ $note->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('tutor.topic.notes.update', ['slug' => $topic->slug, 'noteId' => $note->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel-{{ $note->id }}">Edit Note</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <div class="col-md-12">
                            <label class="form-label">Note Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $note->name }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ $note->description }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Note File (Optional)</label>
                            <input type="file" class="form-control" name="file">
                            @if($note->file_url)
                                <small class="form-text text-muted">Current file: <a href="{{ $note->file_url }}" target="_blank">{{ basename($note->file_url) }}</a></small>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Answer Key File (Optional)</label>
                            <input type="file" class="form-control" name="key_file">
                             @if($note->key_url)
                                <small class="form-text text-muted">Current key: <a href="{{ $note->key_url }}" target="_blank">{{ basename($note->key_url) }}</a></small>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" @selected($note->status == 'draft')>Draft</option>
                                <option value="publish" @selected($note->status == 'publish')>Publish</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </div>
        </form>
    </div>
</div>