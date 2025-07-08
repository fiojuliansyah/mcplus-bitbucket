@extends('frontend.layouts.app')

@section('content')
<div class="iq-breadcrumb" style="background-image: url(/frontend/assets/images/pages/my-account.png);">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb" class="text-center">
                    <h2 class="title">My Courses</h2>
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li> 
                        <li class="breadcrumb-item active">My Courses</li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
</div>

<div class="section-padding service-details">
    <div class="container">
        <div class="row">
            <!-- Sidebar - Grade Menu -->
            <div class="col-lg-3 col-md-4">
                <div class="acc-left-menu p-4 mb-5 mb-lg-0 mb-md-0">
                    <div class="product-menu">
                        <ul class="list-inline m-0 nav nav-tabs flex-column bg-transparent border-0" role="tablist">
                            @foreach($grades as $index => $grade)
                                <li class="nav-item mb-4">
                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }} p-0 bg-transparent text-start" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#grade-{{ $grade->id }}" 
                                            type="button" 
                                            role="tab" 
                                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                        <i class="fas fa-book-reader"></i><span class="ms-2">{{ $grade->name }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content - Subjects & Topics -->
            <div class="col-lg-9 col-md-8">
                <div class="tab-content" id="grade-tab-content">
                    @foreach($grades as $index => $grade)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="grade-{{ $grade->id }}" role="tabpanel">
                            <div class="card p-4 mb-4">
                                <h4 class="mb-4">{{ $grade->name }} - Subjects</h4>

                                @forelse($grade->subjects as $subject)
                                  <div class="mb-5">
                                      <div class="mb-3 d-flex justify-content-between align-items-center">
                                          <h6 class="fw-bold mb-0">{{ $subject->name }}</h6>

                                          <!-- Trigger Modal -->
                                          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal-{{ $subject->id }}">
                                              Add Class
                                          </button>
                                      </div>

                                      @include('tutor.courses.modals.add-class', ['subject' => $subject])

                                      @if($liveClasses->has($subject->id) && $liveClasses->get($subject->id)->isNotEmpty())
                                          <ul class="list-group">
                                              @foreach($liveClasses->get($subject->id) as $class)
                                                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                      <div class="col-md-4 fw-bold">
                                                          {{ $class->topic }}
                                                      </div>

                                                      <div class="col-md-4 text-muted text-center small">
                                                          {{ \Carbon\Carbon::parse($class->start_time)->format('D, M j, Y H:i') }}
                                                      </div>

                                                      <div class="col-md-4 text-end">
                                                          <a href="{{ $class->zoom_join_url }}" target="_blank" class="btn btn-sm btn-success">
                                                              Join Class
                                                          </a>
                                                      </div>
                                                  </li>
                                              @endforeach
                                          </ul>
                                      @else
                                          <p class="text-muted fst-italic">No classes available.</p>
                                      @endif
                                  </div>
                                @empty
                                  <p class="text-muted">No subjects found for this grade.</p>
                                @endforelse

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
