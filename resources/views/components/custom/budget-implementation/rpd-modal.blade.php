<div class="modal fade" id="withdrawalPlanModal" tabindex="-1" role="dialog" aria-labelledby="withdrawalPlanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawalPlanModalLabel">Withdrawal Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="currentActivityId" value="">
                <h2 class="mb-2 text-center fw-bold text-white bg-primary p-2" id="accumulatedTotalSum"></h2>
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
                                        id="amount-{{ $index + 1 }}" value="-" readonly>
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
            </div>
        </div>
    </div>
</div>
