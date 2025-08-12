@extends('frontend.layouts.app2')

@push('styles')
<style>
    .quiz-nav .nav-link {
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin: 0 4px 8px;
        color: var(--bs-secondary);
        transition: all 0.2s ease-in-out;
        font-size: 0.9rem;
    }
    .quiz-nav .nav-link.active {
        font-weight: bold;
        background-color: var(--bs-primary) !important;
        color: white !important;
        border-color: var(--bs-primary) !important;
        transform: scale(1.1);
    }
    .quiz-nav .nav-link.unanswered {
        border-color: var(--bs-danger);
        color: var(--bs-danger);
    }
    .quiz-nav .nav-link.active.unanswered {
        border-width: 2px;
    }
    .quiz-nav .nav-link.answered {
        border-color: var(--bs-success);
        color: var(--bs-success);
        font-weight: bold;
    }
    .quiz-nav .nav-link.active.answered {
        border-width: 2px;
    }
</style>
@endpush


@section('content')
<section class="section-padding">
    <div class="container">

        <div class="card p-4 shadow-sm mb-4">
            <h4 class="mb-3">{{ $test->name }}</h4>
            <p class="mb-1"><strong>Grade:</strong> {{ $grade->name }}</p>
            <p class="mb-1"><strong>Subject:</strong> {{ $subject->name }}</p>
            <p class="mb-1"><strong>Tutor:</strong> {{ $test->user->name ?? '-' }}</p>
            <p class="mb-0"><strong>Time:</strong> {{ $test->start_time }} - {{ $test->end_time }}</p>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @if($questions && $questions->count())
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Navigasi Soal</h6>
                        <p class="card-subtitle text-muted mb-3 small">
                            <span style="color: var(--bs-danger);">Merah</span>: belum dijawab.<br>
                            <span style="color: var(--bs-success);">Hijau</span>: sudah dijawab.
                        </p>
                        <nav>
                            <ul class="nav nav-pills flex-wrap quiz-nav">
                                @foreach ($questions as $index => $question)
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
                <form method="POST" action="{{ route('user.test.submit', $test->id) }}" id="testForm">
                    @csrf
                    @forelse ($questions as $index => $question)
                        <fieldset data-fieldset-index="{{ $index }}" style="{{ !$loop->first ? 'display: none;' : '' }}">
                            
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <div class="border p-3 mb-4 rounded-2">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fw-semibold">Progress Tes</span>
                                            <span>Soal {{ $loop->iteration }} dari {{ $loop->count }}</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success rounded" role="progressbar" 
                                                 style="width: {{ ($loop->iteration / $loop->count) * 100 }}%;" 
                                                 aria-valuenow="{{ ($loop->iteration / $loop->count) * 100 }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <h5 class="mb-3">{{ $loop->iteration }}. {{ $question->question }}</h5>
                                        <input type="hidden" name="questions[{{ $question->id }}][type]" value="{{ $question->type }}">

                                        @if ($question->type === 'multiple')
                                            @php $answers = json_decode($question->answer, true); @endphp
                                            @foreach ($answers as $i => $option)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio"
                                                           name="questions[{{ $question->id }}][answer]"
                                                           value="{{ $option['answer'] }}" id="q{{ $question->id }}_{{ $i }}">
                                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $i }}">
                                                        {{ $option['answer'] }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <textarea name="questions[{{ $question->id }}][answer]" class="form-control mt-2" rows="4" placeholder="Tulis jawabanmu di sini..."></textarea>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mt-4">
                                        <div>
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-light prev_btn">❮ Previous</button>
                                            @endif
                                        </div>
                                        <div>
                                            @if($loop->last)
                                                <button type="submit" class="btn btn-success">Selesaikan Tes</button>
                                            @else
                                                <button type="button" class="btn btn-primary next_btn">Next ❯</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    @empty
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="text-muted fst-italic">Tidak ada soal yang tersedia untuk tes ini.</p>
                            </div>
                        </div>
                    @endforelse
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    try {
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    } catch(e) {
        console.error("History API not supported.");
    }

document.addEventListener('DOMContentLoaded', function() {
    const testForm = document.getElementById('testForm');
    if (!testForm) return;

    const fieldsets = testForm.querySelectorAll('fieldset');
    const navLinks = document.querySelectorAll('.quiz-nav .nav-link');
    const answerInputs = testForm.querySelectorAll('input[type="radio"], textarea');
    
    if (fieldsets.length === 0) return;

    let currentQuestionIndex = 0;

    function showQuestion(index) {
        if (index < 0 || index >= fieldsets.length) {
            return;
        }

        fieldsets.forEach((fs, i) => {
            fs.style.display = (i === index) ? 'block' : 'none';
        });

        navLinks.forEach((link, i) => {
            if (i === index) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
        
        currentQuestionIndex = index;
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetIndex = parseInt(this.dataset.questionIndex, 10);
            showQuestion(targetIndex);
        });
    });

    testForm.addEventListener('click', function(e) {
        if (e.target.classList.contains('next_btn')) {
            showQuestion(currentQuestionIndex + 1);
        }
        if (e.target.classList.contains('prev_btn')) {
            showQuestion(currentQuestionIndex - 1);
        }
    });

    answerInputs.forEach(input => {
        const eventType = input.tagName === 'TEXTAREA' ? 'input' : 'change';
        input.addEventListener(eventType, function() {
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