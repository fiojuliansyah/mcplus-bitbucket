@extends('frontend.layouts.app')

@section('content')
<div class="container section-padding-top">
  <h2 class="main-title mb-4">Upload New Course</h2>

  <form action="{{ route('tutor.upload-course.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label class="form-label">Course Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Subject</label>
      <input type="text" name="subject" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Form</label>
      <input type="number" name="form" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tutor Name</label>
      <input type="text" name="tutor" class="form-control" value="Mr. John Doe" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Video URL</label>
      <input type="url" name="video_url" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Image</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
  </form>
</div>
@endsection
