@extends('frontend.layouts.app2')

@section('content')
<div class="content pt-0">
    <div class="container-fluid">
        <div class="course-watch-section">
            <div class="row">
                <div class="col-lg-4  border-end">
                    <div class="progress-overview-section">
                        <div class="mb-4">
                            <a href="javascript:void(0);" class="back-to-course"><i class="isax isax-arrow-left me-1"></i>Back to Course</a>
                        </div>
                        <h3>
                            {{ $subject->name }}
                        </h3>
                        <div class="mb-4">
                            <p class="mb-1">46% Complete</p>
                            <div class="progress progress-xs mb-2" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 70%"></div>
                            </div>
                            <span class="fw-medium">Last activity on April 20, 2025</span>
                        </div>

                        <div class="accordions-items-seperate" id="accordionSpacingExample">
                            @foreach ($topics as $topic)  
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingSpacingOne3">
                                        <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#Spacing{{ $topic->slug }}" aria-expanded="false" aria-controls="SpacingOne">
                                            <div>
                                                <span class="d-block mb-1">Topic {{ $loop->iteration }}</span>
                                                <h6 class="mb-0">{{ $topic->name }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="Spacing{{ $topic->slug }}" class="accordion-collapse collapse show" aria-labelledby="headingSpacingOne3" data-bs-parent="#accordionSpacingExample">
                                        <div class="accordion-body">
                                            @forelse ($topic->replayClasses as $replay)
                                                <a href="{{ route('user.classes.index', ['subjectSlug' => $subject->slug, 'replayId' => $replay->id]) }}"
                                                    class="d-flex align-items-center justify-content-between mb-3 {{ ($activeReplay && $activeReplay->id == $replay->id) ? 'active-replay' : '' }}">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-flex">
                                                            @if($activeReplay && $activeReplay->id == $replay->id)
                                                                <i class="isax isax-play-circle5 text-primary fs-24 me-1"></i>
                                                            @else
                                                                <i class="isax isax-play-circle5 text-success fs-24 me-1"></i>
                                                            @endif
                                                        </span>
                                                        <p class="accordian-content mb-0">{{ $replay->name }}</p>
                                                    </div>
                                                    
                                                    <span>
                                                        @php
                                                            $totalMinutes = $replay->duration;
                                                            $hours = floor($totalMinutes / 60);
                                                            $minutes = $totalMinutes % 60;
                                                        @endphp
                                                        
                                                        {{ $hours }}H {{ $minutes }}m
                                                    </span>

                                                </a>
                                            @empty
                                                <p>Replay Class not ready</p>
                                            @endforelse
                                            @if ($topic->quizzes->isNotEmpty())
                                                <a href="{{ route('user.quizzes.show', $topic->slug) }}" target="_blank"
                                                    class="d-flex align-items-center justify-content-between mb-3">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-flex">
                                                            <i class="isax isax-document5 text-primary fs-24 me-1"></i>
                                                        </span>
                                                        <p class="accordian-content mb-0">Quiz</p>
                                                    </div>
                                                </a>
                                            @endif
                                            @foreach ($topic->notes as $note)
                                                <a href="#" target="_blank"
                                                    class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <span class="d-flex">
                                                            <i class="isax isax-document5 text-primary fs-24 me-1"></i>
                                                        </span>
                                                        <p class="accordian-content mb-0">{{ $note->name }}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="course-watch-content">
                        @if($activeReplay)
                            <div class="video-player-container mb-4">
                                <iframe id="video-player" width="100%" height="500" 
                                        src="{{ $activeReplay->replay_url }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                            <ul class="nav-tabs mb-4 nav-justified border-0 nav-style-1 d-sm-flex d-block" role="tablist">
                            <li class="nav-item active">
                            <a class="btn nav-link active" data-bs-toggle="tab" role="tab" href="#overview"
                                aria-selected="false">Overview</a>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="btn nav-link" data-bs-toggle="tab" role="tab" href="#notes"
                                aria-selected="false">Notes</a>
                            </li> --}}
                            <li class="nav-item">
                            <a class="btn nav-link" data-bs-toggle="tab" role="tab"
                                href="#faq" aria-selected="true">FAQ</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="overview" role="tabpanel">
                                {!! $activeReplay->description !!}
                            </div>
                            {{-- <div class="tab-pane" id="notes" role="tabpanel">
                                <div class="mb-0">
                                    <h6 class="fs-18 fw-semibold mb-1">Notes</h6>
                                    <ul>
                                        @forelse ($topic->notes as $note)
                                             <p class="mb-0">{{ $note->description }}</p>
                                            <li><a href="{{ $note->file_url }}" target="_blank">{{ $note->name }}</a></li>
                                        @empty
                                            <li>No notes available for this topic.</li>
                                        @endforelse
                                    </ul>                                
                                </div>
                            </div> --}}
                            <div class="tab-pane" id="faq" role="tabpanel">
                                <div class="faq-accordion">
                                    <div class="accordions-items-seperate" id="accordionSpacingExample2">
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="headingSpacingOne2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                                                    How do I enroll in a course?
                                                </button>
                                            </div>
                                            <div id="accordionOne" class="accordion-collapse collapse" aria-labelledby="headingSpacingOne2" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSpacingTwo2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                                    How long do I have access to a course?
                                                </button>
                                            </h2>
                                            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingSpacingTwo2" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSpacingTwo3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionThree" aria-expanded="false" aria-controls="accordionThree">
                                                    What payment methods are accepted?
                                                </button>
                                            </h2>
                                            <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingSpacingTwo3" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSpacingTwo4">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionFour" aria-expanded="false" aria-controls="accordionFour">
                                                    Will I receive a certificate after completing a course?
                                                </button>
                                            </h2>
                                            <div id="accordionFour" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo4" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSpacingTwo5">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionFive" aria-expanded="false" aria-controls="accordionFive">
                                                    What is the purpose of this MCPlus ?
                                                </button>
                                            </h2>
                                            <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingSpacingTwo5" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSpacingTwo6">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionSix" aria-expanded="false" aria-controls="accordionSix">
                                                    What can I do with my certificate?
                                                </button>
                                            </h2>
                                            <div id="accordionSix" class="accordion-collapse collapse" aria-labelledby="headingSpacingTwo6" data-bs-parent="#accordionSpacingExample2">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        Many websites offer a Certificate of Completion for paid courses. Free courses may or may not include a certificate, depending on the platform’s policies.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="text-center p-5">
                                <h5>No video selected or available.</h5>
                                <p>Please select a class from the list on the left.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div >
@endsection

@push('styles')
<style>
    .active-replay {
        background-color: #eef2ff;
        font-weight: bold;
        border-radius: 5px;
        padding: 8px;
        margin: -8px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('video-player');
    const replayLinks = document.querySelectorAll('.replay-link');

    replayLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            const videoUrl = this.dataset.videoUrl;

            if (videoUrl) {
                videoPlayer.src = videoUrl;
            }
        });
    });
});
</script>
@endpush