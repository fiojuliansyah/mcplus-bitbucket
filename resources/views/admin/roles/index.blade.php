@extends('admin.layouts.master')

@section('content')
    <div class="content-inner container-fluid pb-0" id="page_layout">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                            <h4 class="mb-0">Access Control</h4>
                            <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fa fa-plus"></i> Add Access
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive rounded py-4 table-space">
                                <table class="table custom-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Name</th>
                                            <th>Permission</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td><span class="badge bg-primary">Active</span></td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-success rounded" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editModal-{{ $role->id }}">
                                                            <span class="btn-inner">
                                                                <i class="fa-solid fa-user-edit fa-xs"></i>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-danger rounded delete-btn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $role->id }}">
                                                            <span class="btn-inner">
                                                                <i class="fa-solid fa-trash fa-xs"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Creating a New Role -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add Access</h5>
                        <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="col-form-label">Role Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Permission</label>
                            @foreach ($permissions->groupBy('grup') as $grup => $permissionGroup)
                                <div class="pb-5">
                                    <strong>{{ $grup }}</strong>
                                    <div class="pt-3">
                                        @foreach ($permissionGroup as $permission)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                    <span class="form-check-label">{{ $permission->mock }}</span>
                                                </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($roles as $role)
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal-{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $role->id }}">Edit Jabatan</h5>
                            <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" name="name" value="{{ $role->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Hak & Akses</label>
                                @foreach ($permissions->groupBy('grup') as $grup => $permissionGroup)
                                    <div class="pb-5">
                                        <strong>{{ $grup }}</strong>
                                        <div class="pt-3">
                                            @foreach ($permissionGroup as $permission)
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <span class="form-check-label">{{ $permission->mock }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal-{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel-{{ $role->id }}">Hapus Jabatan</h5>
                            <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="isax isax-close-circle5"></i>
							</button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah kamu yakin ingin menghapus jabatan <strong>{{ $role->name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
