@php
    $parsedAnswers = json_decode($answers, true);
@endphp

@if (!empty($parsedAnswers))
    <ul class="list-unstyled mb-0">
        @foreach ($parsedAnswers as $index => $answer)
            <li>
                {{ chr(65 + $index) }}. {{ $answer['answer'] ?? '' }}
                @if (!empty($answer['is_correct']))
                    <span class="badge bg-success ms-2">
                        <i class="bi bi-check-circle"></i> Correct Answer
                    </span>
                @endif
            </li>
        @endforeach
    </ul>
@else
    <em class="text-muted">No answers</em>
@endif
