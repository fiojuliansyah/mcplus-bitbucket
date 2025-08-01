@extends('frontend.layouts.app')

@section('content')

<!-- Breadcrumb -->
{{-- <div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/subjects.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $test->name }}</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.subject.tests', [$grade->slug, $subject->slug]) }}">{{ $subject->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Start Test</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div> --}}

<!-- Test Section -->
<section class="section-padding">
    <div class="container">

        <form method="POST" action="{{ route('user.test.submit', $test->id) }}">
            @csrf

            <div class="card p-4 shadow-sm mb-4">
                <h4 class="mb-3">{{ $test->name }}</h4>
                <p><strong>Grade:</strong> {{ $grade->name }}</p>
                <p><strong>Subject:</strong> {{ $subject->name }}</p>
                <p><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
                <p><strong>Time:</strong> {{ $test->start_time }} - {{ $test->end_time }}</p>
            </div>

            <div class="row">
                <!-- Question display -->
                <div class="col-md-9 position-relative">
                    <!-- Overlay Spinner -->
                    <div id="loadingOverlay" class="d-none position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background-color: rgba(255, 255, 255, 0.7); z-index: 10;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    @if($questions && $questions->count())
                        @foreach($questions as $index => $question)
                            <div class="question-card card mb-4 shadow-sm" id="question-{{ $index }}" style="{{ $index !== 0 ? 'display:none;' : '' }}">
                                <div class="card-body">
                                    <h6 class="mb-2">{{ $question->question }}</h6>
                                    <input type="hidden" name="questions[{{ $question->id }}][type]" value="{{ $question->type }}">

                                    @if ($question->type === 'multiple')
                                        @php $answers = json_decode($question->answer, true); @endphp
                                        @foreach ($answers as $i => $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="questions[{{ $question->id }}][answer]"
                                                    value="{{ $option['answer'] }}" id="q{{ $question->id }}_{{ $i }}">
                                                <label class="form-check-label" for="q{{ $question->id }}_{{ $i }}">
                                                    {{ $option['answer'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <textarea name="questions[{{ $question->id }}][answer]" class="form-control mt-2" rows="3" placeholder="Write your answer here..."></textarea>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center">
                            <button id="submitBtn" type="submit" class="btn btn-success d-none">Submit Test</button>
                        </div>
                    @else
                        <p class="text-muted fst-italic">No questions available for this test.</p>
                    @endif
                </div>


                <!-- Numbered navigation -->
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h6>Navigate</h6>
                            @foreach($questions as $index => $q)
                                <button type="button" class="btn btn-outline-primary btn-sm m-1 question-nav" data-index="{{ $index }}">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('js')
<script>
    // Prevent back navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    const totalQuestions = {{ count($questions) }};
    const submitBtn = document.getElementById('submitBtn');
    const overlay = document.getElementById('loadingOverlay');

    document.querySelectorAll('.question-nav').forEach(button => {
        button.addEventListener('click', () => {
            const index = parseInt(button.dataset.index);

            // Show loading overlay
            overlay.classList.remove('d-none');

            setTimeout(() => {
                // Hide all questions
                document.querySelectorAll('.question-card').forEach(q => q.style.display = 'none');

                // Show selected question
                document.getElementById(`question-${index}`).style.display = 'block';

                // Toggle submit button
                if (index === totalQuestions - 1) {
                    submitBtn.classList.remove('d-none');
                } else {
                    submitBtn.classList.add('d-none');
                }

                // Hide loading overlay
                overlay.classList.add('d-none');
            }, 1000); // Delay for 1 second
        });
    });
</script>
@endpush
