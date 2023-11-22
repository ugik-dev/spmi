@extends('template.BaseView')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
                </div>
                <div class="card-body">
                    <a class="btn btn-primary mb-3" data-toggle="modal" data-target="#createUserModal"><i
                            class="fa fa-plus"></i>
                        Tambah Pengguna</a>

                    @include('partials.session')
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('edit user')
        {{-- Edit User Modal --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div style="min-width:60vw;" class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-form" action="" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="user-name">Nama</label>
                                <input type="text" id="user-name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="">Role</label>
                                <select class="form-control" id="user-role" name="role">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user-email">Email</label>
                                <input type="email" id="user-email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group d-flex align-items-center">
                                <input type="password" class="form-control form-control-user" id="user-password"
                                    placeholder="Password" name="password">
                                <span toggle="#user-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button class="btn-warning btn w-25" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endcan

    @can('create user')
        {{-- Create User Modal --}}
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="new-user-name">Nama</label>
                                <input type="text" id="new-user-name" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new-user-role">Role</label>
                                <select class="form-control" id="new-user-role" name="role">
                                    <option value="">Pilih Role</option>
                                    {{-- @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="new-user-email">Email</label>
                                <input type="email" id="new-user-email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group d-flex align-items-center">
                                <input type="password" class="form-control form-control-user" id="new-user-password"
                                    placeholder="Password" name="password" required>
                                <span toggle="#new-user-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    <script src="{{ mix('js/users-index.js') }}"></script>
@endpush
