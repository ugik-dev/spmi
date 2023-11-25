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

    @can('create prodi')
        {{-- Create Study Program Modal --}}
        @include('study_programs.partials.create-modal')
    @endcan

    @can('edit prodi')
        {{-- Edit Study Program Modal --}}
        @include('study_programs.partials.edit-modal')
    @endcan
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(function() {
            const $programs = $("#study_programs-table").DataTable();

            // DataTables init event
            $programs.on('init.dt', function() {
                // Modify button after table initialization
                $programs.buttons('.button-add').nodes().each(function() {
                    $(this).attr('data-toggle', 'modal');
                    $(this).attr('data-target', '#createStudyProgramModal');
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
                const studyProgramData = $buttonEdit.data("model");

                // Populate vision fields in edit modal with remove buttons
                const visionArray = studyProgramData.vision || [];
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