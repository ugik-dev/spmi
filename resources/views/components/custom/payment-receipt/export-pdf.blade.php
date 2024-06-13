<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2 {
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        td {
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Data Rekam Kuitansi Pembayaran</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Kuitansi</th>
                <th>Status</th>
                <th>Uraian Kegiatan</th>
                <th>Tanggal Kegiatan</th>
                <th>Jumlah</th>
                <th>Pelaksana Kegiatan</th>
                <th>Bendahara</th>
                <th>PPK</th>
                <th>Penyedia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receipts as $index => $receipt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst(__($receipt->type)) }}</td>
                    <td>{!! status_receipt($receipt->status) !!}</td>
                    <td>{{ $receipt->description }}</td>
                    <td>{{ $receipt->activity_date }}</td>
                    <td>Rp{{ number_format($receipt->amount, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $firstIteration = true;
                        @endphp

                        @foreach ($receipt->pengikut as $pengikut)
                            @if ($firstIteration)
                                @php
                                    $firstIteration = false;
                                @endphp
                            @else
                                ,<br>
                            @endif
                            {{ $pengikut->user->name }}
                        @endforeach
                    </td>
                    <td>{{ $receipt->treasurer->name ?? '-' }}</td>
                    <td>{{ $receipt->ppk->name }}</td>
                    <td>{{ $receipt->provider ?? '-' }} {{ $receipt->provider_organization }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
