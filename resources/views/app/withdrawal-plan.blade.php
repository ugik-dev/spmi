<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <style>
            .month-filter-wrapper {
                /* Add custom styling as per your application's design */
                margin-bottom: 15px;
            }

            .month-filter-wrapper select {
                flex-grow: 1;
            }

            .month-filter-wrapper label {
                /* Styling for label */
                margin-bottom: 5px;
                display: block;
            }

            /* Responsive styling */
            @media (max-width: 576px) {
                .month-filter-wrapper .d-flex {
                    flex-direction: column;
                }

                .month-filter-wrapper select {
                    margin-bottom: 10px;
                }
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">

            <div class="card style-4">
                <div class="card-body pt-1 mb-0 pb-0">

                    <div class="m-o-dropdown-list">
                        <div class="media mt-0 mb-3">
                            <div class="badge--group me-3">
                                <div class="badge badge-success badge-dot"></div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading mb-0">
                                    <span class="media-title">Dipa Info</span>
                                    <div class="dropdown-list dropdown" role="group">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-horizontal">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu left">

                                            <a class="dropdown-item"
                                                href="{{ route('budget_implementation.dipa', $dipa) }}"><span>Lihat
                                                    Dipa</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path
                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg></a>
                                            {{-- <a class="dropdown-item" href="javascript:void(0);"><span>Statistics</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-bar-chart-2">
                                                    <line x1="18" y1="20" x2="18" y2="10">
                                                    </line>
                                                    <line x1="12" y1="20" x2="12" y2="4">
                                                    </line>
                                                    <line x1="6" y1="20" x2="6" y2="14">
                                                    </line>
                                                </svg></a> --}}
                                        </div>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <p class="card-text mb-0">Unit Kerja : {{ $dipa->unit->name }}
                        <br>Tahun : {{ $dipa->year }}
                        <br>Total Usulan : Rp
                        {{ number_format($dipa->total) }}
                    </p>
                    {{-- <p class="card-text mt-4 mb-0">{{ $dipa->total }}</p> --}}
                </div>
                <div class="card-footer pt-0 border-0">
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-12 layout-spacing">
            <x-custom.statbox>
                <x-custom.alerts />
                <div class="table-responsive my-4">
                    <table id="withdrawal_plan-table" class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="bg-primary" scope="col">Kode</th>
                                <th class="bg-primary" scope="col">Deskripsi</th>
                                <th class="bg-primary" scope="col">Total Usulan</th>
                                <th class="bg-primary" scope="col">Total RPD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                <tr title="Klik untuk lihat detail rencana penarikan dana"
                                    class="activity-row bs-tooltip" data-activity-id="{{ $activity->id }}"
                                    data-activity-accumulated-sum="{{ $activity->calculateTotalSum() }}"
                                    data-activity-code="{{ $activity->code }}"
                                    data-activity-name="{{ $activity->name }}" data-toggle="modal"
                                    data-target="#withdrawalPlanModal">
                                    <td>{{ $activity->code }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                        {{ $activity->calculateTotalSumFormatted() }}</td>
                                    <td>
                                        Rp
                                        {{ number_format($activity->withdrawalPlans->sum('amount_withdrawn'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Data masih kosong...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </x-custom.statbox>
        </div>
    </div>
    @php
        $editable = false;
        if (
            $dipa->user_id == Auth::user()->id &&
            in_array($dipa->status, ['draft', 'reject-kp', 'reject-ppk', 'reject-spi', 'reject-perencanaan'])
        ) {
            $editable = true;
        }
    @endphp
    <!-- Withdrawal Plan Modal -->
    <div class="modal fade" id="withdrawalPlanModal" tabindex="-1" role="dialog"
        aria-labelledby="withdrawalPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawalPlanModalLabel">Withdrawal Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="currentActivityId" value="">
                    <h2 class="mb-2 text-center fw-bold text-white bg-primary p-2" id="accumulatedTotalSum"></h2>

                    <div class="month-filter-wrapper mb-3" hidden>
                        <label class="form-label">Pilih Bulan di Tampilkan:</label>
                        <div class="row month-checkboxes">
                            @foreach ($months as $index => $month)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input checked class="form-check-input month-checkbox" type="checkbox"
                                            value="{{ $index + 1 }}" id="monthCheckbox{{ $index + 1 }}">
                                        <label class="form-check-label" for="monthCheckbox{{ $index + 1 }}">
                                            {{ $month->getName() }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button id="toggleAllMonths" class="btn btn-primary btn-sm mt-2">Pilih Semua</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="bg-primary text-center">Bulan</th>
                                <th class="bg-primary text-center">Jumlah Penarikan</th>
                            </tr>
                        </thead>
                        <tbody id="withdrawalPlanModalBody">
                            @foreach ($months as $index => $month)
                                <tr data-month="{{ $month->value }}" class="month-row">
                                    <td>{{ $month->getName() }}</td>
                                    <td>
                                        <input type="text" class="form-control editable-amount"
                                            id="amount-{{ $index + 1 }}" value="-"
                                            {{ $editable ? '' : 'disabled' }}>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th
                                    class="border-top border-bottom border-start border-end border-primary bg-primary text-center">
                                    Total Akumulasi
                                </th>
                                <td class="border-top border-bottom border-end border-start-0 border-primary"
                                    id="totalAccumulated">-</td>
                            </tr>
                            <tr>
                                <th
                                    class="border-top border-bottom border-start border-end border-warning bg-warning text-center">
                                    Sisa
                                </th>
                                <td class="border-top border-bottom border-end border-start-0 border-warning"
                                    id="residual">-</td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="btnSaveWithdrawalPlan" class="btn btn-lg btn-success ms-auto d-block"
                        {{ $editable ? '' : 'disabled' }}>Simpan</button>

                </div>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setupActivityRows();
                setupEditableAmounts();
                setupMonthCheckboxes();
                setupToggleAllButton();
                document.getElementById('btnSaveWithdrawalPlan').addEventListener('click', function() {
                    let rows = document.querySelectorAll('#withdrawalPlanModalBody tr.month-row');
                    let savedData = [];
                    rows.forEach((row) => {
                        let rawAmount = document.getElementById(
                            `amount-${row.getAttribute('data-month')}`).value;

                        // Remove 'Rp' and dots, then convert to number
                        let amount = parseInt(rawAmount.replace('-', 0).replace('Rp', '').replace(/\./g,
                            ''));

                        let rowData = {
                            'month': row.getAttribute('data-month'),
                            'amount_withdrawn': amount
                        };
                        savedData.push(rowData);
                    });

                    savingWithdrawalPlans(savedData);
                });
            });


            async function savingWithdrawalPlans(withdrawalPlans) {
                try {
                    let activityId = document.getElementById('currentActivityId').value;
                    const response = await axios.post('/admin/penganggaran/rencana-penarikan-dana-update', {
                        "activityId": activityId,
                        "withdrawalPlans": withdrawalPlans,
                    });

                    if (response.status === 200) {
                        // Assuming the server sends back a success message
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.data.message || 'Data penarikan dana berhasil disimpan.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                $('#withdrawalPlanModal').modal('hide'); // Close the modal
                                location.reload(); // Reload the page
                            }
                        });
                    } else {
                        // If the server response status is not 200
                        Swal.fire({
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!',
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    // Handling any errors that occur during the HTTP request
                    console.error(error);

                    let errorMessage = 'Gagal untuk simpan data.';
                    if (error.response && error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }

                    Swal.fire({
                        title: 'Kesalahan',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            }

            function setupActivityRows() {
                document.querySelectorAll('.activity-row').forEach(row => {
                    row.addEventListener('click', () => {
                        const activity = getActivityData(row);
                        resetModalAmounts();
                        fetchAndPopulateModal(activity);
                    });
                });
            }

            function setupEditableAmounts() {
                document.querySelectorAll('.editable-amount').forEach(input => {
                    input.addEventListener('input', handleInput);
                    input.addEventListener('blur', formatAmountOnBlur);
                });
            }

            function setupMonthCheckboxes() {
                document.querySelectorAll('.month-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', filterMonths);
                });
            }

            function setupToggleAllButton() {
                const toggleAllButton = document.getElementById('toggleAllMonths');
                toggleAllButton.addEventListener('click', () => {
                    let allChecked = Array.from(document.querySelectorAll('.month-checkbox')).every(checkbox => checkbox
                        .checked);
                    document.querySelectorAll('.month-checkbox').forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });
                    filterMonths();
                });
            }

            function filterMonths() {
                let selectedMonths = Array.from(document.querySelectorAll('.month-checkbox:checked')).map(checkbox => checkbox
                    .value);

                document.querySelectorAll('#withdrawalPlanModalBody tr.month-row').forEach(row => {
                    const monthIndex = row.getAttribute('data-month');
                    row.style.display = selectedMonths.includes(monthIndex) ? '' : 'none';
                });
            }

            function handleInput(e) {
                const input = e.target;
                const numericValue = input.value.replace(/[^0-9]/g, '');
                input.value = numericValue; // Keep only numeric values
                formatInputAsIDRCurrency(input); // Format as IDR currency
                recalculateResidual(); // Recalculate residual after input change
            }

            function formatInputAsIDRCurrency(input) {
                let numericValue = parseInt(input.value.replace(/[^0-9]/g, ''), 10);
                if (!isNaN(numericValue)) {
                    input.value = numericValue.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                }
            }

            function formatAmountOnBlur(e) {
                const input = e.target;
                const numericValue = parseInt(input.value.replace(/[^0-9]/g, ''), 10);

                if (isNaN(numericValue) || numericValue === 0) {
                    input.value = '-';
                } else {
                    input.value = numericValue.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                }
                recalculateResidual(); // Recalculate residual after input change
            }

            function recalculateResidual() {
                let totalInputAmount = 0;
                document.querySelectorAll('.editable-amount').forEach(input => {
                    const amount = parseFloat(input.value.replace(/Rp\s?|,00/g, '').replace(/\./g, '').replace(/[^\d]/g,
                        ''));
                    if (!isNaN(amount)) {
                        totalInputAmount += amount;
                    }
                });
                let activityID = document.getElementById('currentActivityId').value;
                let activityData = getActivityData(document.querySelector(`[data-activity-id="${activityID}"]`));
                let residual = activityData.accumulatedSum - totalInputAmount;

                if (residual < 0) {
                    document.getElementById('residual').classList.add('bg-danger')
                } else {
                    document.getElementById('residual').classList.remove('bg-danger')
                }
                document.getElementById('btnSaveWithdrawalPlan').disabled = residual < 0;

                document.getElementById('residual').innerText = window.formatAsIDRCurrency(residual);
                document.getElementById('totalAccumulated').innerText = window.formatAsIDRCurrency(totalInputAmount);
            }

            function getActivityData(row) {
                return {
                    id: row.dataset.activityId,
                    code: row.dataset.activityCode,
                    name: row.dataset.activityName,
                    accumulatedSum: row.dataset.activityAccumulatedSum
                };
            }

            function resetModalAmounts() {
                for (let i = 1; i <= 12; i++) {
                    const monthElement = document.getElementById(`amount-${i}`);
                    if (monthElement) {
                        monthElement.value = '-';
                    }
                }
            }

            async function fetchAndPopulateModal(activity) {
                try {
                    const response = await axios.get(
                        `/api/withdrawal-plans/${activity.id}`);
                    populateModalWithData(response.data, activity);
                } catch (error) {
                    showErrorAlert('Kesalahan', 'Gagal memuat data penarikan dana.');
                }
            }

            function populateModalWithData(data, activity) {
                let totalAccumulated = 0;

                data.forEach(plan => {
                    const monthElement = document.getElementById(`amount-${plan.month}`);
                    if (monthElement) {
                        const amount = parseFloat(plan.amount_withdrawn) || 0;
                        monthElement.value = amount === 0 ? "-" : window.formatAsIDRCurrency(amount);
                        totalAccumulated += amount;
                    }
                });

                let residual = activity.accumulatedSum - totalAccumulated;
                document.getElementById('withdrawalPlanModalLabel').innerText = `${activity.code} - ${activity.name}`;
                document.getElementById('totalAccumulated').textContent = window.formatAsIDRCurrency(totalAccumulated);
                document.getElementById('accumulatedTotalSum').innerText = window.formatAsIDRCurrency(activity.accumulatedSum);
                document.getElementById('residual').innerText = window.formatAsIDRCurrency(residual);
                document.getElementById('currentActivityId').value = activity.id;
                $('#withdrawalPlanModal').modal('show');
            }

            function showErrorAlert(title, message) {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'error'
                });
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
