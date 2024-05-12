<div class="table-responsive my-4">
    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
        @if (empty($dipa) || in_array($dipa->status, ['draft', 'reject-ppk', 'reject-spi', 'reject-kp', 'reject-perencanaan']))
            <div class="d-flex flex-wrap gap-1 my-2">
                <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">Rekam SubKomp</button>
                <button id="add-account_code_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                    class="btn btn-primary shadow-sm">Rekam Akun</button>
                <button id="add-expenditure_detail_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                    class="btn btn-primary shadow-sm">Rekam
                    Detail</button>
            </div>
        @endif
        <div class="d-flex flex-wrap gap-2 my-2">
            <h4
                class="totalCost mx-4 my-2 {{ $totalSum != ($unitBudget->nominal ?? 0) ? 'text-danger' : 'text-success' }}">
                Rp
                {{ number_format($totalSum, 0, ',', '.') }} (max Rp
                {{ number_format($unitBudget->nominal ?? '0', 0, ',', '.') }})</h4>
            @if (empty($dipa) || in_array($dipa->status, ['draft', 'reject-ppk', 'reject-spi', 'reject-kp', 'reject-perencanaan']))
                @if ($dipa)
                    <button {{ $totalSum != ($unitBudget->pagu ?? 0) ? 'disabled' : '' }} id="send-dipa"
                        class="btn btn-outline-warning shadow-sm bs-tooltip">Ajukan</button>
                @endif
                <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
                <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
                <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
            @elseif($dipa->status == 'draft')
            @endif
            @if ($dipa)
                @if (in_array($dipa->status, ['wait-kp', 'reject-kp']) &&
                        $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                        Auth::user()->hasRole(['KEPALA UNIT KERJA']))
                    <div class="float-end p-2">
                        <x-custom.dipa.kepala-modal :dipa="$dipa" />
                    </div>
                @endif
                @if (in_array($dipa->status, ['wait-ppk', 'reject-ppk']) &&
                        // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                        Auth::user()->hasRole(['PPK']))
                    <div class="float-end p-2">
                        <x-custom.dipa.ppk-modal :dipa="$dipa" />
                    </div>
                @endif
                @if (in_array($dipa->status, ['wait-spi', 'reject-spi']) &&
                        // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                        Auth::user()->hasRole(['SPI']))
                    <div class="float-end p-2">
                        <x-custom.dipa.spi-modal :dipa="$dipa" />
                    </div>
                @endif
                @if (in_array($dipa->status, ['wait-perencanaan', 'reject-perencanaan']) &&
                        // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                        Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN']))
                    <div class="float-end p-2">
                        <x-custom.dipa.perencanaan-modal :dipa="$dipa" />
                    </div>
                @endif
                <div class="float-end p-2">
                    <x-custom.dipa.log-modal :dipa="$dipa" />
                    <x-custom.budget-implementation.export-btn :dipaId="$dipa->id" :btn="$btnExport" />
                    {{-- <a href="{{ route('dipa.fpdf', $dipa) }}" class="btn btn-sm btn-success temporary-edit mb-2 mt-2"
                        data-res="Y" target="_blank">
                        <i data-feather="printer"></i> Cetak
                    </a> --}}
                </div>
            @endif
        </div>
    </div>
    <table id="budget_implementation-table" class="table table-bordered">
        <thead>
            <!-- <tr>
                <th class="invisible"></th>
                <th style="background:none !important;border:none !important;border-radius:0 !important;width:fit-content !important;text-decoration-color:red !important;text-decoration-thickness:0.225rem !important;"
                    class="text-dark h3 text-center fw-bold text-decoration-underline">
                    Rp {{ number_format($totalSum, 0, ',', '.') }}
                </th>
            </tr> -->
            <tr class="text-center">
                <th hidden scope="col">Indikator</th>
                <th scope="col">Kode</th>
                <th scope="col">SubKomponen</th>
                <th scope="col">Volume</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Jumlah Biaya</th>
            </tr>
        </thead>
        <tbody class="dipa-table">
            @php
                $cr1 = 1;
            @endphp
            @foreach ($groupedBI as $activityCode => $accountGroups)
                @php
                    $isActivityDisplayed = false;
                    // $cr1 = 1;
                @endphp
                @foreach ($accountGroups as $accountCode => $budgetImplementations)
                    <!-- Activity Row -->
                    @if (!$isActivityDisplayed)
                        <tr data-crow="{{ $cr1 }}"
                            @if ($dipa) data-activity="{{ $budgetImplementations->first()->activity->id }}"
                            data-bi="{{ $budgetImplementations->first()->id }}" @endif
                            class="activity-row crow-{{ $cr1 }}">
                            <td hidden>{{ $budgetImplementations->first()->activity->performance_indicator_id }}</td>
                            <td>{{ $budgetImplementations->first()->activity->code }}</td>
                            <td>{{ $budgetImplementations->first()->activity->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Rp
                                {{ number_format($budgetImplementations->first()->activity_total_sum, 0, ',', '.') }}
                            </td>
                        </tr>
                        @php
                            $isActivityDisplayed = true;
                            $cr2 = 1;
                        @endphp
                    @endif

                    @foreach ($budgetImplementations as $budgetImplementation)
                        @if ($budgetImplementation->accountCode)
                            <!-- Account Code Row -->
                            <tr data-crow="{{ $cr1 . '-' . $cr2 }}"
                                @if ($dipa) data-bi="{{ $budgetImplementations->first()->id }}"
                                data-account-code="{{ $budgetImplementation->accountCode->id }}" @endif
                                class="account-row crow-{{ $cr1 }} crow-{{ $cr1 . '-' . $cr2 }}">
                                <td hidden></td>
                                <td>{{ $budgetImplementation->accountCode->code }}</td>
                                <td>{{ $budgetImplementation->accountCode->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Rp
                                    {{ number_format($budgetImplementations->first()->account_total_sum, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        @php $cr3 = 1; @endphp
                        @foreach ($budgetImplementation->details as $detail)
                            @if ($detail)
                                <!-- Expenditure Detail Row -->
                                <tr data-crow="{{ $cr1 . '-' . $cr2 . '-' . $cr3 }}"
                                    @if ($dipa) data-expenditure="{{ $detail->id }}" @endif
                                    class="expenditure-row crow-{{ $cr1 }} crow-{{ $cr1 . '-' . $cr2 }} crow-{{ $cr1 . '-' . $cr2 . '-' . $cr3 }}">
                                    <td hidden></td> <!-- Empty cells for activity and account columns -->
                                    <td></td> <!-- Empty cells for activity and account columns -->
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->volume }}</td>
                                    <td>{{ $detail->expenditureUnit->code }}</td>
                                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="count_detail">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            @php $cr3++; @endphp
                        @endforeach
                        @php $cr2++; @endphp
                    @endforeach
                @endforeach
                @php $cr1++; @endphp
            @endforeach
        </tbody>
    </table>
</div>
