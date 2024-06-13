<!DOCTYPE html>
<html>

<head>
    <title>Indikator Kinerja</title>

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
    <h2>Indikator Kinerja Sasaran Program</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No.</th>
                <th>Indikator Kinerja Sasaran Program</th>
                <th>Sasaran Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $indexCounter = 1;
            @endphp
            @foreach ($programTargetsHasPerformanceIndicators as $programTarget)
                @foreach ($programTarget->performanceIndicators as $performanceIndicator)
                    <tr>
                        <td>{{ $indexCounter }}</td>
                        <td>{{ $programTarget->name }}</td>
                        <td>{{ $performanceIndicator->name }}</td>
                    </tr>
                    @php
                        $indexCounter++;
                    @endphp
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
