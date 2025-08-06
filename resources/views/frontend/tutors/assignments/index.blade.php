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
                    <h5 class="fw-bold">Assignments</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTestModal">
                            <i class="isax isax-add-circle me-1"></i>Add Assignment
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
                                <th>Assignment Name</th>
                                <th>Grade</th>
                                <th>Total Questions</th>
                                <th>Total Submissions</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                                <tr>
                                    <td>
                                        <h6 class="mb-1"><a href="#">{{ $test->name }} - {{ $test->subject->name }}</a></h6>
                                        <div class="text-muted small"><i class="fas fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($test->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($test->end_time)->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td>{{ $test->subject->grade->name }}</td>
                                    <td>{{ $test->testQuestions->count() }}</td>
                                    <td>0</td>
                                    <td>
                                        @if ($test->status === 'publish')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="d-inline-flex fs-14 me-2 action-icon" data-bs-toggle="modal" data-bs-target="#editTestModal-{{ $test->id }}"><i class="isax isax-edit-2"></i></a>
                                            <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteTestModal-{{ $test->id }}"><i class="isax isax-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @include('frontend.tutors.assignments.modals.edit', ['test' => $test, 'subjects' => $subjects])
                                @include('frontend.tutors.assignments.modals.delete', ['test' => $test])
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.tutors.assignments.modals.create', ['subjects' => $subjects])

@endsection