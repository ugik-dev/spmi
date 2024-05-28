<!DOCTYPE html>
<html>

<head>
    <title>Indikator Kinerja Utama</title>

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
    <h2>Pagu</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th style="width: 10px;">No</th>
                <th style="width: 80px;">Tahun</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagus as $index => $pagu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pagu->year }}</td>
                    <td style="text-align: right;">{{ 'Rp ' . number_format($pagu->nominal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
