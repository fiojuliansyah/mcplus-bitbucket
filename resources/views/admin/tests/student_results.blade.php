<a href="{{ route('admin.tests.results', [
    'formSlug' => $row->grade->slug,
    'subjectSlug' => $row->subject->slug,
    'testSlug' => $row->slug
]) }}" class="badge bg-info" style="color: white;">
    <i class="fas fa-chart-bar"></i> See Result
</a>
