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
                    @include('partials.session')
                    <div class="table-responsive py-4">
                        {{ $dataTable->table() }}
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
    {{ $dataTable->scripts() }}
    <script>
        $(function() {
            const $facultiesTable = $("#faculties-table").DataTable();

            // DataTables init event
            $facultiesTable.on('init.dt', function() {
                // Modify button after table initialization
                $facultiesTable.buttons('.button-add').nodes().each(function() {
                    $(this).attr('data-toggle', 'modal');
                    $(this).attr('data-target', '#createFacultyModal');
                    $(this).find('.button-add-icon-placeholder').html('<i class="fa fa-plus"></i>');
                    $(this).removeClass('btn-secondary').addClass('btn-primary');
                });
            });

            $(document).ready(function() {
                setupEditModal('#editModal', '#edit-faculty-form', '/fakultas/edit/:id', 'model');

                setupDeleteFunctionality(
                    '#faculties-table',
                    '/fakultas/hapus/:id',
                    'model-name'
                );
            });

            // Function to add new vision input field with a remove button
            function addVisionInput(containerId, value = "") {
                const container = $(`#${containerId}`);
                const index = container.children().length + 1; // To keep track of the vision items
                container.append(`
    <div class="input-group mb-2 vision-input">
      <input type="text" name="vision[]" class="form-control" value="${value}" placeholder="Visi ${index}">
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-danger remove-vision" onclick="removeVision(this)">
          <i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
  `);
            }

            // Function to remove vision input field
            window.removeVision = function(button) {
                $(button).closest(".vision-input").remove();
            };

            // Add vision input field in create modal
            $("#add-create-vision").on("click", () =>
                addVisionInput("create-vision-container")
            );

            // Add vision input field in edit modal
            $("#add-edit-vision").on("click", () =>
                addVisionInput("edit-vision-container")
            );
            $('#editModal').on("show.bs.modal", (event) => {
                const $buttonEdit = $(event.relatedTarget);
                const facultyData = $buttonEdit.data("model");

                // Populate vision fields in edit modal with remove buttons
                const visionArray = facultyData.vision ?
                    JSON.parse(facultyData.vision) : [];
                const $visionContainer = $("#edit-vision-container");
                $visionContainer.empty(); // Clear existing inputs
                visionArray.forEach((visionItem, index) => {
                    addVisionInput("edit-vision-container",
                        visionItem); // Use the function to add inputs with values
                });

            });
        });
    </script>
@endpush
