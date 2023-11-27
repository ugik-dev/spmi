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
    @can('edit prodi')
        @include('criteria.partials.edit-modal')
    @endcan
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        async function handleSelectCriterionLevelChange(event) {
            const level = parseInt($(this).val());
            const parentLevel = parseInt(level - 1);
            const criterionForm = $(event.delegateTarget);
            const parentCriterionSelect = criterionForm.find('[name="parent"]');
            const parentCriterionGroup = parentCriterionSelect.closest('.form-group');
            const parentCriterionCode = criterionForm.find('[name="parent_code"]');
            const parentCriterionCodeGroup = parentCriterionCode.closest('.form-group');

            if (!(level > 1)) {
                parentCriterionGroup.addClass('d-none');
                parentCriterionCodeGroup.addClass('d-none');
                return Promise.resolve(); // Immediately resolve the promise
            }
            parentCriterionGroup.removeClass('d-none');
            parentCriterionCodeGroup.removeClass('d-none');

            try {
                const response = await axios.get('/get-parent-criteria', {
                    params: {
                        level: parentLevel
                    }
                });
                const options = response.data.map(item =>
                    `<option value="${item.id}">[${item.code}] - ${item.name}</option>`);
                parentCriterionSelect.html(options.join(''));
                parentCriterionSelect.trigger('change');
                return Promise.resolve(); // Resolve the promise after populating options
            } catch (error) {
                console.error('Error fetching data:', error);
                return Promise.reject(error); // Reject the promise in case of an error
            }
        }


        function handleSelectParentChange(event) {
            const criterionForm = $(event.delegateTarget);
            const parentCodeInput = criterionForm.find('[name="parent_code"]');

            const selectedOptionText = $(this).find('option:selected').text();
            const codeMatch = selectedOptionText.match(/\[(.*?)\]/);

            if (codeMatch && codeMatch[1]) {
                parentCodeInput.val(codeMatch[1]);
            } else {
                parentCodeInput.val('');
            }
        }

        function populateEditForm(criterionData) {
            var form = $('#edit-criterion-form');

            // Populate other fields directly
            form.find('[name="name"]').val(criterionData.name);
            form.find('[name="code"]').val(criterionData.code);


            setTimeout(() => {
                form.find('[name="level"]').val(criterionData.level).change();

                setTimeout(() => {
                    form.find('[name="parent"]').val(criterionData.parentId).change();
                }, 100); // adjust delay as necessary
            }, 100);
        }
        $(document).ready(function() {
            // Temporary hide sidebar to debug console
            $('#accordionSidebar').addClass('d-none')

            // Cached jQuery objects for better performance
            const $criteriaTable = window.LaravelDataTables['criteria-table'];

            $criteriaTable.on('init.dt', function() {
                modifyDataTableButtons($criteriaTable);
                attachEditButtonEvent();
            });

            $("#create-criterion-form").on('change', '[name="level"]', handleSelectCriterionLevelChange);
            $("#create-criterion-form").on('change', '[name="parent"]', handleSelectParentChange);
            $("#edit-criterion-form").on('change', '[name="level"]', handleSelectCriterionLevelChange);
            $("#edit-criterion-form").on('change', '[name="parent"]', handleSelectParentChange);
        });

        function modifyDataTableButtons($criteriaTable) {
            $criteriaTable.buttons('.button-add').nodes().each(function() {
                $(this).attr('data-toggle', 'modal')
                    .attr('data-target', '#createCriterionModal')
                    .html('<i class="fa fa-plus"></i> Tambah Kriteria')
                    .removeClass('btn-secondary').addClass('btn-primary');
            });
            $(".btn.btn-secondary").addClass('my-1 my-md-0');
            $($criteriaTable.buttons().container()[0]).addClass("text-center d-block");
            $("#create-criterion-form select").val('').change();
        }

        function attachEditButtonEvent() {
            $('.btn-edit').on('click', function() {
                var criterionData = $(this).data('model');
                populateEditForm(criterionData);
            });
        }
    </script>
@endpush
