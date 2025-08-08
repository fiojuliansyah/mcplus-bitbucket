@extends('frontend.layouts.app2')

@section('content')
@include('frontend.layouts.partials.tutor-breadcrumb')

<div class="content">
    <div class="container">
        @include('frontend.layouts.partials.tutor-header')

        <div class="row">
            @include('frontend.layouts.partials.tutor-navbar')

            <div class="col-lg-9">
                <div class="page-title d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold">Live Classes</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="isax isax-add-circle me-1"></i>Add Live Class
                        </a>
                    </div>
                </div>

                <form action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle text-gray-6 btn rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                        Status: {{ ucfirst(request('status', 'All')) }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-start p-3">
                                        <li><a href="{{ route('tutor.assignments.index', ['search' => request('search')]) }}" class="dropdown-item rounded-1">All</a></li>
                                        <li><a href="{{ route('tutor.assignments.index', ['status' => 'publish', 'search' => request('search')]) }}" class="dropdown-item rounded-1">Published</a></li>
                                        <li><a href="{{ route('tutor.assignments.index', ['status' => 'draft', 'search' => request('search')]) }}" class="dropdown-item rounded-1">Draft</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon"><i class="isax isax-search-normal-14"></i></span>
                                <input type="text" name="search" class="form-control form-control-md" placeholder="Search by name..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Class</th>
                                <th>Schedule</th>
                                <th>Zoom</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($liveClasses as $class)
                                <tr>
                                    <td>
                                        <h6 class="mb-1">{{ $class->topic->name }}</h6>
                                        <div class="text-muted small"><i class="fas fa-file-alt me-1"></i>
                                            {{ $class->subject->name }} - {{ $class->grade->name }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($class->start_time)->format('d M Y H:i') }}
                                    </td>
                                    <td>
                                        <div>
                                            <div><strong>ID:</strong> {{ $class->zoom_meeting_id }}</div>
                                            <div><strong>Password:</strong> {{ $class->password }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $class->status }}</td>
                                    <td><a href="{{ route('live-classes.join', $class->id) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-sign-in"></i>&nbsp; Join Class</a></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($class->status === 'draft')   
                                                <a href="#" class="d-inline-flex fs-14 me-2 action-icon" data-bs-toggle="modal" data-bs-target="#editModal-{{ $class->id }}"><i class="isax isax-edit-2"></i></a>
                                                <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $class->id }}"><i class="isax isax-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @if ($class->status === 'draft')   
                                    @include('frontend.tutors.live-classes.modals.edit', ['class' => $class, 'subjects' => $subjects])
                                @endif
                                @include('frontend.tutors.live-classes.modals.delete', ['class' => $class])
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{-- {{ $tests->withQueryString()->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.tutors.live-classes.modals.create', ['subjects' => $subjects])

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const subjectDropdown = document.getElementById('subjectDropdown');
    const topicDropdown = document.getElementById('topicDropdown');

    subjectDropdown.addEventListener('change', function () {
        const subjectId = this.value;

        topicDropdown.innerHTML = '<option value="">Loading...</option>';

        if (subjectId) {
            fetch(`/tutor/get-topics?subject_id=${subjectId}`)
                .then(response => response.json())
                .then(data => {
                    topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                    data.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicDropdown.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading topics:', error);
                    topicDropdown.innerHTML = '<option value="">Error loading topics</option>';
                });
        } else {
            topicDropdown.innerHTML = '<option value="">Select Topic</option>';
        }
    });
});

</script>
@endpush