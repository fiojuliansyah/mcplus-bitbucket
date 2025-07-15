@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="py-5 d-flex justify-content-between align-items-center mb-4">
        {{-- <h2>{{ $topic->grades->name }} - {{ $topic->subjects->name }} - {{ $topic->name }} - Manage Quizzes</h2> --}}
        <h3>{{ $topic->grade->name }} - {{ $topic->subject->name }} - {{ $topic->name }} - Manage Quizzes</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createQuizModal">
            + Create Quiz
        </button>
    </div>

    @if($quizzes->isEmpty())
        <div class="alert alert-info">No quizzes created yet.</div>
    @else
        <div class="list-group">
            @foreach($quizzes as $index => $quiz)
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        {{-- Number the quizzes --}}
                        <strong>{{ $index + 1 }}. {{ $quiz->question }}</strong>
                        <ul class="mb-0 mt-2 mx-3 list-unstyled">
                            @php
                                $choices = json_decode($quiz->multiple_choice, true);
                                $letters = range('A', 'Z');
                            @endphp

                            @foreach ($choices as $i => $choice)
                                <li>
                                    <strong>{{ $letters[$i] }}.</strong> {{ $choice['answer'] }}
                                    @if($choice['is_correct']) <span class="badge bg-success">Correct</span> @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editQuizModal-{{ $quiz->id }}">Edit</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuizzModal-{{ $quiz->id }}">Delete</button>
                    </div>
                </div>

                {{-- Include Edit & Delete Modals --}}
                @include('tutor.courses.modals.edit-quizz', ['quiz' => $quiz, 'topic' => $topic])
                @include('tutor.courses.modals.delete-quizz', ['quizz' => $quiz, 'topic' => $topic])
            @endforeach

        </div>
    @endif
</div>

{{-- Include Create Modal --}}
@include('tutor.courses.modals.add-quizz', ['topic' => $topic])

<script src="{{ asset('frontend/assets/js/quizz.js') }}"></script>
<script>
    // Re-bind dropdowns every time DataTable redraws
    $(document).on('draw.dt', function () {
        if (typeof bindUpdateQuizz === 'function') {
            bindUpdateQuizz();
        }
    });
</script>

@endsection
