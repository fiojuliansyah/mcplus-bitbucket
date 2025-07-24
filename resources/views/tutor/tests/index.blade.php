@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url('/frontend/assets/images/pages/my-account.png');">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">{{ $subject->name }} Tests</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tutor.my-course') }}">My Courses</a></li>
                        <li class="breadcrumb-item active">{{ $subject->name }} Tests</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-4">Tests for {{ $subject->name }} ({{ $grade->name }})</h4>
                
                <div class="mb-4 text-end">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTestModal">
                        + Add New Test
                    </button>
                </div>
            </div>
            @if($tests->isNotEmpty())
                <div class="list-group">
                    @foreach($tests as $test)
                        <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h5 class="mb-1">{{ $test->name }}</h5>
                                <div class="text-muted small mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($test->start_time)->format('d M Y H:i') }} - 
                                    {{ \Carbon\Carbon::parse($test->end_time)->format('d M Y H:i') }}
                                </div>
                                <div class="text-muted small">
                                    Created by: <strong>{{ $test->user->name ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            {{-- <a href="{{ route('tutor.tests.show', $test->id) }}" class="btn btn-sm btn-outline-primary">
                                View Test
                            </a> --}}

                            <div class="d-flex gap-2">
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTestModal-{{ $test->id }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>

                                <!-- Delete Button -->
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTestModal-{{ $test->id }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        @include('tutor.tests.action', ['test' => $test])
                    @endforeach
                </div>
            @else
                <p class="text-muted fst-italic">No tests available for this subject.</p>
            @endif
        </div>
    </div>
</div>

<!-- Add Test Modal -->
<div class="modal fade" id="addTestModal" tabindex="-1" aria-labelledby="addTestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('tutor.tests.store', [$grade->slug, $subject->slug]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addTestModalLabel">Create New Test</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <input type="text" hidden value="{{ $grade->id }}" name="grade_id">
        <input type="text" hidden value="{{ $subject->id }}" name="subject_id">
        <input type="text" hidden value="{{ auth()->id() }}" name="user_id">
        <div class="modal-body">
          <div class="row g-3">
              <div class="col-md-12">
                  <label for="test-name" class="form-label">Test Name</label>
                  <input type="text" name="name" class="form-control" id="test-name" required>
              </div>

              <div class="col-md-6">
                  <label for="start-time" class="form-label">Start Time</label>
                  <input type="datetime-local" name="start_time" class="form-control" id="start-time" required>
              </div>

              <div class="col-md-6">
                  <label for="end-time" class="form-label">End Time</label>
                  <input type="datetime-local" name="end_time" class="form-control" id="end-time" required>
              </div>
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Create Test</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
