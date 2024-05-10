<div class="table-responsive my-4">
    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
        @if (empty($dipa) || ($dipa->status == 'draft' && $dipa->user_id == Auth::user()->id))
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
            <h4 class="totalCost mx-4 my-2 {{ $totalSum > ($unitBudget->pagu ?? 0) ? 'text-danger' : 'text-success' }}">
                Rp
                {{ number_format($totalSum, 0, ',', '.') }} (max Rp
                {{ number_format($unitBudget->pagu ?? '0', 0, ',', '.') }})</h4>
            @if (empty($dipa) || ($dipa->status == 'draft' && $dipa->user_id == Auth::user()->id))
                @if ($dipa)
                    <button {{ $totalSum > ($unitBudget->pagu ?? 0) ? 'disabled' : '' }} id="send-dipa"
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
                @if (in_array($dipa->status, ['accept']) &&
                        // $dipa->work_unit_id == Auth::user()->employee?->work_unit_id &&
                        Auth::user()->hasRole(['SUPER ADMIN PERENCANAAN']))
                    <div class="float-end p-2">
                        <x-custom.dipa.perencanaan2-modal :dipa="$dipa" />
                    </div>
                @endif
                <div class="float-end p-2">
                    <x-custom.dipa.log-modal :dipa="$dipa" />
                    <x-custom.budget-implementation.export-btn :dipaId="$dipa->id" :btnExport="$btnExport" />
                </div>
            @endif
        </div>
    </div>

    <style>
        #budget_implementation-table td:nth-child(1),
        {
        text-align: center;
        }

        #budget_implementation-table td:nth-child(1),
        #budget_implementation-table td:nth-child(2),
        #budget_implementation-table td:nth-child(3),
        #budget_implementation-table td:nth-child(4) {
            white-space: pre-wrap;
            word-wrap: break-word;
            vertical-align: top;
        }

        .money {
            text-align: end
        }
    </style>
    <table id="budget_implementation-table" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col">Kode</th>
                <th scope="col">SubKomponen</th>
                <th scope="col">Volume</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Jumlah Total</th>
                <th scope="col">Catatan</th>
            </tr>
        </thead>
        <tbody class="dipa-table">
            @php
                $cr1 = 1;
            @endphp
            @foreach ($groupedBI as $activityCode => $accountGroups)
                @php
                    $isActivityDisplayed = false;
                    $totalRows = 0;
                @endphp
                <!-- Activity Row -->
                @php
                    foreach ($accountGroups as $accountCode => $budgetImplementations) {
                        foreach ($budgetImplementations as $budgetImplementation) {
                            if ($budgetImplementation->accountCode) {
                                $totalRows++;
                            }
                            foreach ($budgetImplementation->details as $detail) {
                                if ($detail) {
                                    $totalRows++;
                                }
                            }
                        }
                    }

                @endphp

                @foreach ($accountGroups as $accountCode => $budgetImplementations)
                    @php
                        $Indikator = $budgetImplementations->first()->activity->performanceIndicator;
                        $misi = $Indikator?->programTarget?->iku?->mission?->description;
                    @endphp
                    @if (!$isActivityDisplayed)
                        <tr data-crow="{{ $cr1 }}"
                            @if ($dipa) data-activity="{{ $budgetImplementations->first()->activity->id }}"
                            data-bi="{{ $budgetImplementations->first()->id }}" @endif
                            class="activity-row crow-{{ $cr1 }}">
                            <td>{{ $budgetImplementations->first()->activity->code }}</td>
                            <td>{{ $budgetImplementations->first()->activity->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="money">Rp
                                {{ number_format($budgetImplementations->first()->activity_total_sum, 0, ',', '.') }}
                            </td>
                            <td rowspan="{{ $totalRows + 1 }}" {{-- title="Klik untuk menambahkan atau edit catatan"
                                class="bs-tooltip"
                                onclick="addCatatan('{{ $budgetImplementations->first()->activity->id }}')" --}}>
                                @php $i_note = 1 @endphp
                                @foreach ($budgetImplementations->first()->activity->activityNote as $note)
                                    {!! $i_note != 1 ? '<br>' : '' !!}
                                    {{ $note->user->name }}:<br> {!! nl2br($note->description) !!}
                                    @php $i_note++ @endphp
                                @endforeach
                                {{-- </p> --}}
                            </td>
                        </tr>
                        @php
                            $isActivityDisplayed = true;
                            $cr2 = 1;
                        @endphp
                    @endif
                    @foreach ($budgetImplementations as $budgetImplementation)
                        @if ($budgetImplementation->accountCode)
                            <tr data-crow="{{ $cr1 . '-' . $cr2 }}"
                                @if ($dipa) data-bi="{{ $budgetImplementations->first()->id }}"
                                data-account-code="{{ $budgetImplementation->accountCode->id }}" @endif
                                class="account-row crow-{{ $cr1 }} crow-{{ $cr1 . '-' . $cr2 }}">
                                <td>{{ $budgetImplementation->accountCode->code }}</td>
                                <td>{{ $budgetImplementation->accountCode->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="money">Rp
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
                                    <td></td>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->volume }}</td>
                                    <td>{{ $detail->expenditureUnit->code }}</td>
                                    <td class="money">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="money count_detail">Rp {{ number_format($detail->total, 0, ',', '.') }}
                                    </td>
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
