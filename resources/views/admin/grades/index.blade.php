@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">Grade List</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Grade
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded py-4 table-space">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Grade -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.grades.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Grade</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Grade Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image <small>(optional)</small></label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
@endpush
