<div class="modal fade" id="deleteModal-{{ $class->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $class->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tutor.live-classes.destroy', $class->id) }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel-{{ $class->id }}">Confirm Deletion</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the Live Class: <br><strong>{{ $class->topic->name }} ({{ $class->subject->name }}) - {{ $class->subject->grade->name }}</strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>