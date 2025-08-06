@extends('frontend.layouts.app2')

@section('content')
    @include('frontend.layouts.partials.student-breadcrumb')

    <div class="content">
        <div class="container">
            @include('frontend.layouts.partials.student-header')
            <div class="row">

                @include('frontend.layouts.partials.student-navbar')

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>Order History</h5>
                    </div>

                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);"
                                            class="dropdown-toggle btn rounded border d-inline-flex align-items-center"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Status: {{ ucfirst(request('status', 'All')) }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-start p-3">
                                            <li>
                                                <a href="{{ route('user.order-history', ['search' => request('search')]) }}" class="dropdown-item rounded-1">All</a>
                                            </li>
                                            {{-- Link untuk setiap status --}}
                                            <li>
                                                <a href="{{ route('user.order-history', ['status' => 'success', 'search' => request('search')]) }}" class="dropdown-item rounded-1">Completed</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.order-history', ['status' => 'pending', 'search' => request('search')]) }}" class="dropdown-item rounded-1">Pending</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.order-history', ['status' => 'canceled', 'search' => request('search')]) }}" class="dropdown-item rounded-1">Canceled</a>
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
                                    {{-- Tambahkan name="search" dan value --}}
                                    <input type="text" name="search" class="form-control form-control-md" placeholder="Search by Order ID" value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Profile Name</th>
                                    <th>Plan</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subscriptions as $subscription)
                                    <tr>
                                        <td><a href="#" class="text-primary">#{{ $subscription->transaction_code }}</a></td>
                                        <td>{{ $subscription->created_at->format('d M Y') }}</td>
                                        <td>{{ $subscription->profile->name }}</td>
                                        <td>{{ $subscription->plan->name }}</td>
                                        <td>{{ $subscription->subject->name }} ({{ $subscription->subject->grade->name }})</td>
                                        <td>
                                            @if ($subscription->status == 'success')
                                                <span class="badge bg-success d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Completed</span>
                                            @elseif ($subscription->status == 'canceled')
                                                <span class="badge bg-danger d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Canceled</span>
                                            @else
                                                <span class="badge bg-warning d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Pending</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal" data-bs-target="#view_invoice_{{ $subscription->id }}"><i class="isax isax-eye"></i></a>
                                                <a href="#" class="d-inline-flex fs-14 action-icon"><i class="isax isax-import"></i></a>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No order history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $subscriptions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
