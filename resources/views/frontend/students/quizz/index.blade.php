@extends('frontend.layouts.app2')

@push('styles')
<style>
    .quiz-nav .nav-link {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin: 0 4px 8px;
        color: var(--bs-secondary);
        transition: all 0.2s ease-in-out;
        font-size: 0.8rem;
    }
    .quiz-nav .nav-link.active {
        font-weight: bold;
        background-color: var(--bs-primary) !important;
        color: white !important;
        border-color: var(--bs-primary) !important;
    }
    .quiz-nav .nav-link.unanswered {
        border-color: var(--bs-danger);
        color: var(--bs-danger);
    }
    .quiz-nav .nav-link.active.unanswered {
        border-color: var(--bs-danger);
        border-width: 2px;
    }
    .quiz-nav .nav-link.answered {
        border-color: var(--bs-success);
        color: var(--bs-success);
        font-weight: bold;
    }
    .quiz-nav .nav-link.active.answered {
        border-color: var(--bs-success);
        border-width: 2px;
    }
</style>
@endpush


@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="mb-4">
                    <a href="{{ route('user.my-quiz') }}" class="back-to-course"><i class="isax isax-arrow-left me-1"></i>Back to Course</a>
                </div>
                <div class="col-lg-3">
                    @if(count($quizzes) > 0)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Question Navigation</h6>
                            <p class="card-subtitle text-muted mb-2 small">
                                <span style="color: var(--bs-danger);">Red</span>: unanswered. 
                                <span style="color: var(--bs-success);">Green</span>: answered.
                            </p>
                            <nav>
                                <ul class="nav nav-pills flex-wrap quiz-nav">
                                    @foreach ($quizzes as $index => $quiz)
                                    <li class="nav-item">
                                        <a class="nav-link unanswered" href="#" data-question-index="{{ $index }}">
                                            {{ $index + 1 }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-9 quiz-wizard">

                    <form action="{{ route('user.quizzes.submit', $topic->slug) }}" method="POST" id="quizForm">
                    @csrf
                        @forelse ($quizzes as $index => $quiz)
                            @php
                                $options = json_decode($quiz->multiple_choice, true);
                            @endphp
                            
                            <fieldset data-fieldset-index="{{ $index }}" style="{{ !$loop->first ? 'display: none;' : '' }}">
                                <div class="page-title d-flex align-items-center justify-content-between">
                                    <h5>My Quiz Attempts</h5>
                                </div>
                                <div class="quiz-attempt-card border-0">
                                    <div class="quiz-attempt-body p-0">
                                        <div class="border p-3 mb-3 rounded-2">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span class="fw-semibold text-gray-9">Quiz Progress</span>
                                                    
                                                    <span>Question {{ $loop->iteration }} out of {{ $loop->count }}</span>
                                                </div>
                                                <div class="progress progress-xs flex-grow-1 mb-1">
                                                    <div class="progress-bar bg-success rounded" role="progressbar" 
                                                        style="width: {{ ($loop->iteration / $loop->count) * 100 }}%;" 
                                                        aria-valuenow="{{ ($loop->iteration / $loop->count) * 100 }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <h6 class="mb-3">{{ $index + 1 }}. {{ $quiz->question }}</h6>
                                                @foreach ($options as $optIndex => $option)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $quiz->id }}]"
                                                            id="quiz_{{ $quiz->id }}_option_{{ $optIndex }}"
                                                            value="{{ $optIndex }}">
                                                        <label class="form-check-label" for="quiz_{{ $quiz->id }}_option_{{ $optIndex }}">
                                                            {{ $option['answer'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="text-end mt-4">
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-light rounded-pill prev_btn">Previous</button>
                                            @endif

                                            @if($loop->last)
                                                <button type="submit" class="btn btn-primary rounded-pill">Submit Quiz</button>
                                            @else
                                                <button type="button" class="btn btn-secondary rounded-pill next_btn">Next<i class="isax isax-arrow-right-3 ms-1 fs-10"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        @empty
                            <p>No quiz questions available for this topic.</p>
                        @endforelse
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quizForm');
    if (!quizForm) return;

    const fieldsets = quizForm.querySelectorAll('fieldset');
    const navLinks = document.querySelectorAll('.quiz-nav .nav-link');
    const radioButtons = quizForm.querySelectorAll('input[type="radio"]');
    
    if (fieldsets.length === 0) return;

    let currentQuestionIndex = 0;

    function showQuestion(index) {
        if (index < 0 || index >= fieldsets.length) {
            return;
        }

        fieldsets.forEach(fs => {
            fs.style.display = 'none';
        });
        fieldsets[index].style.display = 'block';

        navLinks.forEach(link => {
            link.classList.remove('active');
        });
        if (navLinks[index]) {
            navLinks[index].classList.add('active');
        }
        
        currentQuestionIndex = index;
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetIndex = parseInt(this.dataset.questionIndex, 10);
            showQuestion(targetIndex);
        });
    });

    document.querySelectorAll('.next_btn').forEach(button => {
        button.addEventListener('click', function() {
            showQuestion(currentQuestionIndex + 1);
        });
    });

    document.querySelectorAll('.prev_btn').forEach(button => {
        button.addEventListener('click', function() {
            showQuestion(currentQuestionIndex - 1);
        });
    });

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const parentFieldset = this.closest('fieldset');
            if (parentFieldset) {
                const answeredIndex = parseInt(parentFieldset.dataset.fieldsetIndex, 10);
                const correspondingNavLink = navLinks[answeredIndex];
                if (correspondingNavLink) {
                    correspondingNavLink.classList.remove('unanswered');
                    correspondingNavLink.classList.add('answered');
                }
            }
        });
    });

    showQuestion(0);
});
</script>
@endpush