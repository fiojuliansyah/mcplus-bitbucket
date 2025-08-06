@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">{{ $grade->name }}-{{ $subject->name }}-{{ $topic->name }} Quizz</h4>
                        <div class="d-flex">
                            <a href="{{ 
                                        route('admin.topics.index', [
                                        'formSlug' => $grade->slug,
                                        'subjectSlug' => $subject->slug,
                                        ]) 
                                    }}" 
                            class="btn btn-secondary me-2">
                                Back
                            </a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fa fa-plus"></i> Add Quizz
                            </button>
                        </div>
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

    <!-- Modal Create Quizz -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.quizzes.store', ['formSlug' => $grade->slug, 'subjectSlug' => $subject->slug, 'topicSlug' => $topic->slug]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Quizz</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="grade_id" value="{{ $subject->grade_id }}">
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">

                        <div class="mb-3">
                            <label class="form-label">Tutor</label>
                            <select class="form-select" id="gradeDropdown" name="user_id" required>
                                @if($tutors->isEmpty())
                                    <option value="">No tutor available</option>
                                @else
                                    <option value="">Select Tutor</option>
                                    @foreach($tutors as $tutor)
                                        <option value="{{ $tutor->user_id }}">{{ $tutor->user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" class="form-control" name="question" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Options & Correct Answer</label>
                            <small class="text-muted d-block mb-2">Mark the correct answer using the radio button.</small>
                            <div id="options-wrapper">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">A</span>
                                    <input type="text" name="options[]" class="form-control" required>
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="radio" name="correct_option" value="0" required>
                                        <label class="ms-1 mb-0 small">Correct</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success" id="add-option-btn">+ Add Option</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Quizz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{ asset('admin/assets/js/quizz-form.js') }}"></script>
    <script>
        // Re-bind dropdowns every time DataTable redraws
        $(document).on('draw.dt', function () {
            if (typeof bindUpdateQuizz === 'function') {
                bindUpdateQuizz();
            }
        });
    </script>
@endpush
