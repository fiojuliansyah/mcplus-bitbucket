<a href="{{ route('admin.quizzes.index', [
    'formSlug' => $row->grade->slug,
    'subjectSlug' => $row->subject->slug,
    'topicSlug' => $row->slug
]) }}" class="badge bg-light" style="color: #333;">
    <i class="fas fa-play" style="color: #333;"></i>
    Quizz
</a>
