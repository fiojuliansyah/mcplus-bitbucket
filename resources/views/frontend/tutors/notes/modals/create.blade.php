<div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('tutor.topic.notes.store', ['slug' => $topic->slug]) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNoteModalLabel">Create New Note</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <div class="col-md-12">
                            <label class="form-label">Note Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Note File</label>
                            <input type="file" class="form-control" name="file">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Answer Key File (Optional)</label>
                            <input type="file" class="form-control" name="key_file">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" @selected(old('status', 'draft') == 'draft')>Draft</option>
                                <option value="publish" @selected(old('status', 'draft') == 'publish')>Publish</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Note</button>
                </div>
            </div>
        </form>
    </div>
</div>