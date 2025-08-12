@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">
                
                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <h5>My Live Classes</h5>
                    </div>

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
                                        <td>
                                            @if ($class->status === 'draft')
                                                <a href="#" class="btn btn-sm btn-warning">soon</a>
                                            @else  
                                                <a href="{{ route('live-classes.join', $class->id) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-sign-in"></i>&nbsp; Join Class</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Live Classes found.</td>
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
