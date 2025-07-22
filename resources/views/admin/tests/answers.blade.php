@php
    $parsedAnswers = json_decode($answer, true);
@endphp

@if ($type === 'multiple' && is_array($parsedAnswers))
    @if (!empty($parsedAnswers))
        <ul class="list-unstyled mb-0">
            @foreach ($parsedAnswers as $index => $option)
                <li>
                    {{ chr(65 + $index) }}. {{ $option['answer'] ?? '' }}
                    @if (!empty($option['is_correct']))
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
@elseif ($type === 'essay')
    <div>{{ $parsedAnswers['essay_answer'] }}</div>
@else
    <em class="text-muted">Invalid answer type</em>
@endif
