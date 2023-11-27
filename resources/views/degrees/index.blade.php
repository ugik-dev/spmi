@extends('template.BaseView')

@section('content')
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data degrees</h6>
            </div>
            <div class="card-body">
                @include('partials.session')
                <div class="table-responsive py-4">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>

@can('edit degree')
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Degree</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-degree-form" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="degree-name">Name</label>
                        <input type="text" id="degree-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="degree-code">Code</label>
                        <input type="text" id="degree-code" name="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan


@can('create degree')
<div class="modal fade" id="createDegreeModal" tabindex="-1" aria-labelledby="createDegreeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDegreeModalLabel">Tambah degrees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('degrees.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="new-degree-name">Name</label>
                        <input type="text" id="new-degree-name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new-degree-code">Code</label>
                        <input type="text" id="new-degree-code" name="code" class="form-control" required>
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
<script>
    $(function() {
        const $degreesTable = $("#degrees-table").DataTable();

        // DataTables init event
        $degreesTable.on('init.dt', function() {
            // Modify button after table initialization
            $degreesTable.buttons('.button-add').nodes().each(function() {
                $(this).attr('data-toggle', 'modal');
                $(this).attr('data-target', '#createDegreeModal');
                $(this).find('.button-add-icon-placeholder').html('<i class="fa fa-plus"></i>');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
            });
        });

        $(document).ready(function() {
            setupEditModal('#editModal', '#edit-degree-form', '/degrees/edit/:id', 'model');

            setupDeleteFunctionality(
                '#degrees-table',
                '/degrees/hapus/:id',
                'model-name'
            );
        });
    });
</script>
{{-- <script src="{{ mix('js/degrees-index.js') }}"></script> --}}
@endpush