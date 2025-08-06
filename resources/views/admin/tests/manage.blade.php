@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">{{ $grade->name }} - {{ $subject->name }} - {{ $test->name }} <strong>Manage Test</strong></h4>
                        <div class="d-flex">
                            <a href="{{ route('admin.subjects.index', $grade->slug) }}" class="btn btn-secondary me-2">
                                Back
                            </a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fa fa-plus"></i> Add Question
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

    <!-- Modal Create Question -->
    <div class="modal fade mt-5" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Tabs for Question Type -->
                <ul class="nav nav-tabs mb-3 d-flex justify-between" id="questionTypeTabs" role="tablist">
                    <li class="nav-item w-50" role="presentation">
                        <button class="nav-link active w-100 text-center" id="multiple-tab" data-bs-toggle="tab" data-bs-target="#multiple" type="button" role="tab">Multiple Choice</button>
                    </li>
                    <li class="nav-item w-50" role="presentation">
                        <button class="nav-link w-100 text-center" id="essay-tab" data-bs-toggle="tab" data-bs-target="#essay" type="button" role="tab">Essay</button>
                    </li>
                </ul>

                <div class="tab-content px-3 pb-3" id="questionTypeTabsContent">
                    <!-- Multiple Choice Tab -->
                    <div class="tab-pane fade show active" id="multiple" role="tabpanel">
                        <form action="{{ route('admin.tests.store-question', ['formSlug' => $grade->slug, 'subjectSlug' => $subject->slug, 'testSlug' => $test->slug]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="test_id" value="{{ $test->id }}">
                            <input type="hidden" name="type" value="multiple">

                            <div class="modal-header">
                                <h5 class="modal-title">Create Multiple Choice Question</h5>
                                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="isax isax-close-circle5"></i>
            </button>
                            </div>

                            <div class="modal-body">
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
                                <button type="submit" class="btn btn-primary">Save Question</button>
                            </div>
                        </form>
                    </div>

                    <!-- Essay Tab -->
                    <div class="tab-pane fade" id="essay" role="tabpanel">
                        <form action="{{ route('admin.tests.store-question', ['formSlug' => $grade->slug, 'subjectSlug' => $subject->slug, 'testSlug' => $test->slug]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="test_id" value="{{ $test->id }}">
                            <input type="hidden" name="type" value="essay">

                            <div class="modal-header">
                                <h5 class="modal-title">Create Essay Question</h5>
                                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="isax isax-close-circle5"></i>
            </button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text" class="form-control" name="question" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Expected Answer</label>
                                    <textarea class="form-control" name="essay_answer" rows="4" required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Question</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{ asset('admin/assets/js/test-form.js') }}"></script>
    <script>
        // Re-bind dropdowns every time DataTable redraws
        $(document).on('draw.dt', function () {
            if (typeof bindUpdateQuizz === 'function') {
                bindUpdateQuizz();
            }
        });
    </script>
@endpush