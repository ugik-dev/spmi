<!DOCTYPE html>
<html>

<head>
    <title>Indikator Kinerja</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
    <h2>Performance Indicators Report</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No.</th>
                <th>Sasaran Program</th>
                <th>Indikator Kinerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programTargetsHasPerformanceIndicators as $programTarget)
                @foreach ($programTarget->performanceIndicators as $index => $performanceIndicator)
                    <tr>
                        @if ($index == 0)
                            <td rowspan="{{ count($programTarget->performanceIndicators) }}">
                                {{ $loop->parent->iteration }}</td>
                            <td rowspan="{{ count($programTarget->performanceIndicators) }}">{{ $programTarget->name }}
                            </td>
                        @endif
                        <td>{{ $performanceIndicator->name }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
