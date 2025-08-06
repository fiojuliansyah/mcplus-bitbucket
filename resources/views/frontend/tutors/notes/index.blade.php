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
                    <h5 class="fw-bold">Notes</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createNoteModal">
                            <i class="isax isax-add-circle me-1"></i>Add Note
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
                                        <li><a href="{{ route('tutor.topic.notes', ['search' => request('search'), $topic->slug]) }}" class="dropdown-item rounded-1">All</a></li>
                                        <li><a href="{{ route('tutor.topic.notes', ['status' => 'publish', 'search' => request('search'), $topic->slug]) }}" class="dropdown-item rounded-1">Published</a></li>
                                        <li><a href="{{ route('tutor.topic.notes', ['status' => 'draft', 'search' => request('search'), $topic->slug]) }}" class="dropdown-item rounded-1">Draft</a></li>
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
                                <th>Note Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notes as $note)
                                <tr>
                                    <td>
                                        <h6 class="mb-1"><a href="#">{{ $note->name }}</a></h6>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#descriptionModal-{{ $note->id }}">View</a>
                                    </td>
                                    <td>
                                        @if ($note->status === 'publish')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($note->created_at)->format('d M Y H:i') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($note->updated_at)->format('d M Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="d-inline-flex fs-14 me-2 action-icon" data-bs-toggle="modal" data-bs-target="#editNoteModal-{{ $note->id }}"><i class="isax isax-edit-2"></i></a>
                                            <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteNoteModal-{{ $note->id }}"><i class="isax isax-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @include('frontend.tutors.notes.modals.edit', ['note' => $note, 'topic' => $topic])
                                @include('frontend.tutors.notes.modals.delete', ['note' => $note])
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No notes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.tutors.notes.modals.create', ['topic' => $topic])

@endsection