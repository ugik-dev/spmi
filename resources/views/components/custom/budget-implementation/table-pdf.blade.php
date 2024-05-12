<div class="table-responsive my-4">
    <Table>
        <tr>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>{{ $dipa->unit->name }}</td>
        </tr>
        <tr>
            <td>Petugas Entri</td>
            <td>:</td>
            <td>{{ $dipa->user?->name }}</td>
        </tr>
        <tr>
            <td>Revisi ke </td>
            <td>:</td>
            <td>{{ $dipa->revision }}</td>
        </tr>
        <tr>
            <td>Tanggal Entri</td>
            <td>:</td>
            <td>{{ $dipa->created_at }}</td>
        </tr>
        <tr>
            <td>Pagu Unit Kerja</td>
            <td>:</td>
            <td>Rp {{ number_format($dipa->unit->unitBudgets[0]->pagu ?? '0', 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Usulan</td>
            <td>:</td>
            <td>Rp {{ number_format($totalSum, 0, ',', '.') }}</td>
        </tr>
    </Table>

    <style>
        #budget_implementation-table,
        #budget_implementation-table tr,
        #budget_implementation-table td {
            border-collapse: collapse;
            border: 1px solid black;
            /* tambahkan garis tepi hitam pada sel tabel */
        }

        #budget_implementation-table td:nth-child(1),
        #budget_implementation-table td:nth-child(2),
        #budget_implementation-table td:nth-child(3),
        /* #budget_implementation-table td:nth-child(14), */
        #budget_implementation-table td:nth-child(4) {
            white-space: pre-wrap;
            word-wrap: break-word;
            vertical-align: top;
            text-align: left;
        }

        .money {
            text-align: right
        }
    </style>
    <table id="budget_implementation-table" class="table table-bordered" border=1 style="width: 100%">
        <thead>
            <tr class="text-center">
                <th scope="col">MISI (RENSTRA)</th>
                <th scope="col">SASARAN PROGRAM (RENSTRA)</th>
                <th scope="col">Sasaran(PERKIN)</th>
                <th scope="col">Indikator (PERKIN)</th>
                <th scope="col">Kode</th>
                <th scope="col">SubKomponen</th>
                <th scope="col">Volume</th>
                <th scope="col">Satuan</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Jumlah Usulan</th>
                {{-- <th scope="col">Jumlah RPD</th> --}}
                <th scope="col">Data Dukung</th>
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

                    // $totalRows = count($accountGroups); // Jumlah baris dari $budgetImplementations
                    // // dd($budgetImplementations);
                    // // Hitung jumlah detail untuk setiap $budgetImplementation dan tambahkan ke total baris
                    // // dd($budgetImplementations[1]->details);
                    // foreach ($budgetImplementations as $budgetImplementation) {
                    //     echo 'h' . count($budgetImplementation->details);
                    //     $totalRows += count($budgetImplementation->details);
                    // }
                    // dd($totalRows);

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
                            <td rowspan="{{ $totalRows + 1 }}">{{ $misi }}</td>
                            <td rowspan="{{ $totalRows + 1 }}">{{ $Indikator?->programTarget?->iku?->description }}
                            </td>
                            <td rowspan="{{ $totalRows + 1 }}">{{ $Indikator?->programTarget?->name }}</td>
                            <td rowspan="{{ $totalRows + 1 }}">{{ $Indikator?->name }}</td>
                            <td>{{ $budgetImplementations->first()->activity->code }}</td>
                            <td>{{ $budgetImplementations->first()->activity->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                {{ number_format($budgetImplementations->first()->activity_total_sum, 0, ',', '.') }}
                            </td>
                            <td rowspan="{{ $totalRows + 1 }}">
                                @php
                                    $rekap_file = false;
                                    if (
                                        !empty(
                                            $budgetImplementations->first()->activity->activityRecap?->attachment_path
                                        )
                                    ) {
                                        $filePath = Storage::disk(App\Supports\Disk::ActivityRecapAttachment)->path(
                                            $budgetImplementations->first()->activity->activityRecap?->attachment_path,
                                        );
                                        $fileMimeType = mime_content_type($filePath);
                                        $rekap_file = true;
                                    } else {
                                        $fileMimeType = false;
                                    }
                                @endphp
                                @if ($rekap_file)
                                    Ada
                                @else
                                @endif
                            </td>


                            <td rowspan="{{ $totalRows + 1 }}" title="Klik untuk menambahkan atau edit catatan"
                                class="bs-tooltip"
                                onclick="addCatatan('{{ $budgetImplementations->first()->activity->id }}')">
                                @php $i_note = 1 @endphp
                                @foreach ($budgetImplementations->first()->activity->activityNote as $note)
                                    {!! $i_note != 1 ? '<br>' : '' !!}
                                    {{ $i_note }}. {{ $note->description }}
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
                                <td class="money">
                                    {{ number_format($budgetImplementations->first()->account_total_sum, 0, ',', '.') }}
                                </td>
                                {{-- <td></td>
                                <td></td>
                                <td></td> --}}
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
                                    <td class="money">{{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="count_detail money"> {{ number_format($detail->total, 0, ',', '.') }}
                                    </td>
                                    {{-- <td></td>
                                    <td></td>
                                    <td></td> --}}

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
