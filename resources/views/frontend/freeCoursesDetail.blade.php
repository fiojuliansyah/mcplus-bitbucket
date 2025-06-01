@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">

          {{-- Video at the top --}}
          <div class="ratio ratio-16x9 mb-4">
            <iframe src="{{ $course['video_url'] }}" title="{{ $course['title'] }}" frameborder="0" allowfullscreen></iframe>
          </div>

          <h2 class="card-title mb-3">{{ $course['title'] }}</h2>
          <p><strong>Subject:</strong> {{ $course['subject'] }}</p>
          <p><strong>Form:</strong> {{ $course['form'] }}</p>
          <p><strong>tutor:</strong> {{ $course['tutor'] }}</p>
          <p class="mt-3">{{ $course['description'] }}</p>

          <a href="/free-course" class="btn btn-outline-secondary mt-4">
            ← Back to Free Courses
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
