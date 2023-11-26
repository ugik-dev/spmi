@extends('template.BaseView')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Fakultas</h6>
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

    {{-- Create Study Program Modal --}}
    @can('create prodi')
        @include('criteria.partials.create-modal')
    @endcan

    {{-- Edit Study Program Modal --}}
    {{-- @can('edit prodi')
        @include('criteria.partials.edit-modal')
    @endcan --}}
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(function() {
            const $criteriaTable = $("#criteria-table").DataTable();

            // DataTables init event
            $criteriaTable.on('init.dt', function() {
                // Modify button after table initialization
                $criteriaTable.buttons('.button-add').nodes().each(function() {
                    $(this).attr('data-toggle', 'modal');
                    $(this).attr('data-target', '#createCriterionModal');
                    $(this).find('.button-add-icon-placeholder').html('<i class="fa fa-plus"></i>');
                    $(this).removeClass('btn-secondary').addClass('btn-primary');
                });
            });

            $(document).ready(function() {
                setupEditModal('#editModal', '#edit-prodi-form', '/prodi/edit/:id', 'model');

                setupDeleteFunctionality(
                    '#study_programs-table',
                    '/prodi/hapus/:id',
                    'model-name'
                );
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#criterion-level').on('change', function() {
                var level = $(this).val();
                if (level > 1) {
                    $('#parent-criterion-group').removeClass('d-none');

                    axios.get('/get-parent-criteria', {
                            params: {
                                level: level - 1
                            }
                        })
                        .then(function(response) {
                            var parentInput = $("#criterion-parent");
                            parentInput.empty(); // Clear previous options

                            // Assuming response.data is an array of criteria
                            response.data.forEach(function(criterion) {
                                parentInput.append(new Option(criterion.name + ' (' + criterion
                                    .code + ')', criterion.id));
                            });
                        })
                        .catch(function(error) {
                            console.log(error);
                            // Handle the error here, such as displaying a notification
                        });
                } else {
                    $('#parent-criterion-group').addClass('d-none');
                }
            });

            // Additional logic...
        });
    </script>
@endpush
