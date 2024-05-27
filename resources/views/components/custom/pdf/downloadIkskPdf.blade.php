<!DOCTYPE html>
<html>

<head>
    <title>Indikator Kinerja Sasaran Program</title>

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
    <h2>Indikator Kinerja Sasaran Kegiatan</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Sasaran Kegiatan</th>
                <th>Indikator Kinerja Sasaran Kegiatan</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($performanceIndicators as $index => $performanceIndicator)
                @foreach ($performanceIndicator->iksks as $iksk)
                    <tr>
                        <td>{{ $loop->parent->iteration }}</td>
                        <td>{{ $performanceIndicator->name }}</td>
                        <td>{{ $iksk->name }}</td>
                        <td>
                            @if ($iksk->type == 'decimal')
                                {{ number_format((float) $iksk->value, 2, '.', '') }}
                            @elseif ($iksk->type == 'persen')
                                {{ (int) $iksk->value }}%
                            @elseif ($iksk->type == 'range')
                                {{ number_format((float) $iksk->value, 2, '.', '') }} -
                                {{ number_format((float) $iksk->value_end, 2, '.', '') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
