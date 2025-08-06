@extends('frontend.layouts.app2')

@section('content')
    <div class="breadcrumb-bar text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Our Tutors</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tutors</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="course-content">
        <div class="container">
            <form id="filter-form" action="{{ url()->current() }}" method="GET">
                <div class="row align-items-baseline">

                    <div class="col-lg-3">
                        <div class="filter-clear">
                            <div class="clear-filter d-flex align-items-center justify-content-between mb-4 pb-lg-2">
                                <h5><i class="feather-filter me-2"></i>Filters</h5>
                                <div class="clear-text">
                                    <a href="{{ url()->current() }}">Clear All</a>
                                </div>
                            </div>
                            
                            <div class="accordion accordion-customicon1 accordions-items-seperate">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSubjects">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubjects" aria-expanded="true" aria-controls="collapseSubjects">
                                            Subjects <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseSubjects" class="accordion-collapse collapse show" aria-labelledby="headingSubjects">
                                        <div class="accordion-body">
                                            @isset($allSubjects)
                                                @foreach ($allSubjects as $subject)
                                                <div>
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="subjects[]" value="{{ $subject->name }}"
                                                            {{ in_array($subject->name, $selectedSubjects ?? []) ? 'checked' : '' }}>
                                                        <span class="checkmark"></span> {{ $subject->name }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingGrades">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGrades" aria-expanded="true" aria-controls="collapseGrades">
                                            Grades <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseGrades" class="accordion-collapse collapse show" aria-labelledby="headingGrades">
                                        <div class="accordion-body">
                                            @isset($allGrades)
                                                @foreach ($allGrades as $grade)
                                                <div>
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="grades[]" value="{{ $grade->id }}"
                                                            {{ in_array($grade->id, $selectedGrades ?? []) ? 'checked' : '' }}>
                                                        <span class="checkmark"></span> {{ $grade->name }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="showing-list mb-4">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="show-result text-center text-lg-start">
                                        <h6 class="fw-medium">
                                            @if ($tutors instanceof \Illuminate\Pagination\LengthAwarePaginator && $tutors->total() > 0)
                                                Showing {{ $tutors->firstItem() }}-{{ $tutors->lastItem() }} of {{ $tutors->total() }} results
                                            @else
                                                Showing {{ $tutors->count() }} results
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="show-filter add-course-info">
                                        <div class="d-sm-flex justify-content-center justify-content-lg-end align-items-center">
                                            <div class="sort-by me-sm-2 mb-2 mb-sm-0">
                                                <select name="sort" class="form-select" onchange="document.getElementById('filter-form').submit();">
                                                    <option value="">Sort by</option>
                                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                                                </select>
                                            </div>
                                            <div class="search-group">
                                                <i class="feather-search"></i>
                                                <input type="text" name="search" class="form-control" placeholder="Search for tutors..." value="{{ request('search') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row course-list-cover">
                            @forelse ($tutors as $tutor)
                                <div class="col-xl-4 col-md-6 d-flex">
                                    <div class="instructor-item instructor-item-six flex-fill">
                                        <div class="instructors-img">
                                            <a href="#">
                                                @if($tutor->current_profile && $tutor->current_profile->avatar)
                                                    <img class="img-fluid" src="{{ asset('storage/' . $tutor->current_profile->avatar) }}" alt="{{ $tutor->current_profile->name }}">
                                                @else
                                                    <img class="img-fluid" src="/frontpage/assets/img/user/user-61.jpg" alt="img">
                                                @endif
                                            </a>
                                            <div class="position-absolute start-0 top-0 d-flex align-items-start w-100 z-index-2 p-2">
												<span class="verify">
													<img src="/frontpage/assets/img/icons/verify-icon.svg" alt="img" class="img-fluid">
												</span>
											</div>
                                        </div>
                                        <div class="instructor-content">
                                            <div>
                                                <h3 class="title mb-2">
                                                    <a href="#">{{ $tutor->current_profile->name ?? 'Tutor Name' }}</a>
                                                </h3>
                                                <span class="designation">
                                                    {{ $tutor->subjects->unique('name')->take(2)->pluck('name')->join(', ') }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center instructor-bottom">
												<div class="d-flex align-items-center">
													<span class="d-flex align-items-center"><i class="isax isax-book-saved5 fs-16 text-secondary me-2"></i>{{ $tutor->subjects->pluck('topics')->flatten()->count() }}+ Lesson</span>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center fw-bold mt-5">No tutors found matching your criteria.</p>
                                </div>
                            @endforelse
                        </div>

                        @if ($tutors->hasPages())
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    {{ $tutors->withQueryString()->links() }}
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
            </form> 
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('filter-form');
        if (filterForm) {
            filterForm.addEventListener('change', function (event) {
                if (event.target.type === 'checkbox' || event.target.tagName === 'SELECT') {
                    filterForm.submit();
                }
            });
        }
    });
</script>
@endpush