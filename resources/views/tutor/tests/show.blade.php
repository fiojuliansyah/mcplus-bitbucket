@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url('/frontend/assets/images/pages/my-account.png');">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $test->name }} - Detail</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tutor.my-course') }}">My Courses</a></li>
                        <li class="breadcrumb-item active">{{ $test->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="card p-4">
            <div>
                <h4 class="mb-1">Test: {{ $test->name }}</h4>
                <p class="mb-0"><strong>Grade:</strong> {{ $test->grade->name ?? '-' }}</p>
                <p class="mb-0"><strong>Subject:</strong> {{ $test->subject->name ?? '-' }}</p>
                <p class="mb-0"><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
                <p class="mb-0"><strong>Time:</strong> {{ $test->start_time }} - {{ $test->end_time }}</p>
            </div>
            <div class="mt-3">
                <button class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#createModal">
                    + Add Question
                </button>
            </div>
            <hr>
            <h5>Questions ({{ $questions->count() }})</h5>
            @forelse($questions as $question)
                <div class="mb-4 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1"><strong>Q{{ $loop->iteration }}:</strong> {{ $question->question }}</p>
                            <span class="badge bg-secondary">{{ ucfirst($question->type) }}</span>
                        </div>
                        <div>
                            <!-- Edit and Delete triggers (optional) -->
                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editQuestionModal{{ $question->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal{{ $question->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    @if($question->type === 'multiple')
                        @php
                            $answers = json_decode($question->answer, true);
                        @endphp
                        <ul class="mt-2">
                            @foreach($answers as $index => $option)
                                <li>
                                    {{ $option['answer'] }}
                                    @if(!empty($option['is_correct']))
                                        <span class="badge bg-success ms-2">Correct</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        @php
                            $essay = json_decode($question->answer);
                        @endphp
                        <p class="mt-2"><strong>Expected Answer:</strong> <em>{{ $essay->essay_answer ?? '—' }}</em></p>
                    @endif
                </div>
            @empty
                <p class="text-muted fst-italic">No questions available for this test.</p>
            @endforelse

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
                        <form action="{{ route('tutor.test-questions.store', ['formSlug' => $grade->slug, 'subjectSlug' => $subject->slug, 'testSlug' => $test->slug]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="test_id" value="{{ $test->id }}">
                            <input type="hidden" name="type" value="multiple">

                            <div class="modal-header">
                                <h5 class="modal-title">Create Multiple Choice Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                            <span class="input-group-text" style="background-color: #424242">A</span>
                                            <input type="text" name="options[]" class="form-control" required>
                                            <div class="input-group-text" style="background-color: #424242">
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<script src="{{ asset('frontend/assets/js/test-form.js') }}"></script>
<script>
    // Re-bind dropdowns every time DataTable redraws
    $(document).on('draw.dt', function () {
        if (typeof bindUpdateQuizz === 'function') {
            bindUpdateQuizz();
        }
    });
</script>