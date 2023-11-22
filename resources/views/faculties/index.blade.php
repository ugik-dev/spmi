@extends('template.BaseView')
@push('styles')
    <style>
        .vision-input .remove-vision {
            cursor: pointer;
        }

        .vision-input .remove-vision i {
            color: red;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Fakultas</h6>
                </div>
                <div class="card-body">
                    @can('create faculty')
                        <a class="btn btn-primary mb-3" data-toggle="modal" data-target="#createFacultyModal">
                            <i class="fa fa-plus"></i> Tambah Fakultas
                        </a>
                    @endcan

                    @include('partials.session')
                    <div class="table-responsive">
                        <table class="table table-bordered" id="faculties-datatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Singkatan</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama</th>
                                    <th>Singkatan</th>
                                    <th width="150px">Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($faculties as $faculty)
                                    <tr>
                                        <td>{{ $faculty->name }}</td>
                                        <td>{{ $faculty->abbr }}</td>
                                        <td width="150px" class="d-flex justify-content-center">
                                            @can('edit faculty')
                                                <button type="button" class="btn btn-warning btn-edit mr-1 mb-1 mb-md-0"
                                                    data-faculty="{{ $faculty }}" data-toggle="modal"
                                                    data-target="#editFacultyModal">Edit</button>
                                            @endcan
                                            @can('delete faculty')
                                                <button type="button" class="btn btn-danger btn delete-button"
                                                    data-faculty-name="{{ $faculty->name }}"
                                                    data-id="{{ $faculty->id }}">Hapus</button>
                                            @endcan
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

    @can('create faculty')
        {{-- Create Faculty Modal --}}
        @include('faculties.partials.create-modal')
    @endcan

    @can('edit faculty')
        {{-- Edit Faculty Modal --}}
        @include('faculties.partials.edit-modal')
    @endcan
@endsection

@push('scripts')
    <script src="{{ mix('js/faculties-index.js') }}"></script>
@endpush
