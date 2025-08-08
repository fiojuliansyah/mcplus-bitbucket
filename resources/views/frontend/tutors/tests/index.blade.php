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
                    <h5 class="fw-bold">Assignments - {{ $subject->name }} ({{ $subject->grade->name }})</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-secondary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTestModal">
                            <i class="isax isax-add-circle me-1"></i>Add Assignment
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle text-gray-6 btn  rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Published</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Draft</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="isax isax-search-normal-14"></i>
                            </span>
                            <input type="email" class="form-control form-control-md" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Assignment Name</th>
                                <th>Total Questions</th>
                                <th>Total Submit</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tests->isNotEmpty())
                                @foreach($tests as $test)
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="mb-1"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_assignment">{{ $test->name }}</a></h6>
                                                <div class="text-muted small mb-1">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($test->start_time)->format('d M Y H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($test->end_time)->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $test->testQuestions->count() }}</td>
                                        <td>0</td>
                                        <td>
                                            @if ($test->status === 'publish')
                                                <span class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Published</span>    
                                            @else
                                                <span class="badge badge-sm bg-skyblue d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Draft</span>    
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" class="d-inline-flex fs-14 me-1 action-icon"><i class="isax isax-eye"  data-bs-toggle="modal" data-bs-target="#editTestModal-{{ $test->id }}"></i></a>
                                                <a href="javascript:void(0);" class="d-inline-flex fs-14 me-1 action-icon"><i class="isax isax-edit-2"  data-bs-toggle="modal" data-bs-target="#editTestModal-{{ $test->id }}"></i></a>
                                                <a href="javascript:void(0);" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal" data-bs-target="#deleteTestModal-{{ $test->id }}"><i class="isax isax-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('frontend.tutors.tests.action')
                                @endforeach
                            @else
                                <p class="text-muted fst-italic">No tests available for this subject.</p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTestModal" tabindex="-1" aria-labelledby="addTestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('tutor.tests.store', [$grade->slug, $subject->slug]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addTestModalLabel">Create New Assignment</h5>
          <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
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
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Test</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection