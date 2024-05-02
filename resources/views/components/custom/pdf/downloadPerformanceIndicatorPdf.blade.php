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
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Performance Indicators Report</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Sasaran Program</th>
                <th>Indikator Kinerja</th>
                <th>Target</th>
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
                        <td>{{ number_format((float) $performanceIndicator->value, 2, '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
