@extends('frontend.layouts.app')

@section('content')
<section class="section-padding">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0">Quiz Result - {{ $result->topic->name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Score:</strong> {{ number_format($result->score) }} / 100</p>
                <p><strong>Correct:</strong> {{ $result->correct_answers }} / {{ $result->total_questions }}</p>

                <ul class="list-group mt-4">
                    @foreach ($answers as $answer)
                        @php
                            $options = json_decode($answer->quizz->multiple_choice, true);
                            $correctIndex = collect($options)->search(fn($opt) => $opt['is_correct']);
                        @endphp
                        <li class="list-group-item">
                            <strong>Q:</strong> {{ $answer->quizz->question }}<br>
                            <strong>Your Answer:</strong> {{ $answer->answer !== null ? $answer->answer : 'No Answer' }}<br>
                            <strong>Correct Answer:</strong> {{ $options[$correctIndex]['answer'] ?? 'N/A' }}<br>
                            <span class="badge bg-{{ $answer->is_correct ? 'success' : 'danger' }}">
                                {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
