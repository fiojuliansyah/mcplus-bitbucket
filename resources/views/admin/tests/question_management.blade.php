<a href="{{ route('admin.tests.manage', [
    'formSlug' => $row->grade->slug,
    'subjectSlug' => $row->subject->slug,
    'testSlug' => $row->slug
]) }}" class="badge bg-light" style="color: #333;">
    <i class="fas fa-play" style="color: #333;"></i>
    Test
</a>
