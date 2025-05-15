@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                        <h4 class="mb-0">{{ $grade->name }} Subjects</h4>
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus"></i> Add Subject
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

    <!-- Modal Create Subject -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
               <form action="{{ route('admin.subjects.store', ['slug' => $grade->slug]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image <small>(optional)</small></label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trailer <small>(optional)</small></label>
                            <input type="url" class="form-control" name="trailer">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Subject</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
@endpush
