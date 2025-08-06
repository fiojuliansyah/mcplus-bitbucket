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
                        <h5 class="fw-bold">Students</h5>
                        <div class="d-flex align-items-center list-icons">
                            <a href="student-list.html" class="active me-2"><i class="isax isax-task"></i></a>
                            <a href="students.html"><i class="isax isax-element-3"></i></a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
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
                                    <th>Student Name</th>
                                    <th>Enroll Date</th>
                                    <th>Plans</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $studentProfile)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                                    @if($studentProfile->avatar)
                                                        <img src="{{ asset('storage/' . $studentProfile->avatar) }}" alt="Avatar">
                                                    @else
                                                        <img src="/assets/img/user/user-placeholder.jpg" alt="Avatar">
                                                    @endif
                                                </a>
                                                <a href="#"><p class="fs-14 mb-0">{{ $studentProfile->name ?? 'Student Name' }}</p></a>
                                            </div>
                                        </td>

                                        <td>{{ $studentProfile->subscriptions->first()->created_at->format('d M Y') }}</td>

                                        <td>
                                            {{ $studentProfile->subscriptions->first()->plan->name }}
                                        </td>

                                        <td>{{ $studentProfile->subscriptions->first()->subject->name }}</td>
                                        <td>{{ $studentProfile->subscriptions->first()->subject->grade->name }}</td>

                                        <td>
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection
