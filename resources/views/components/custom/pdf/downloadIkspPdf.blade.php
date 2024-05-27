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
    <h2>Indikator Kinerja Sasaran Program</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Sasaran Program</th>
                <th>Indikator Kinerja Sasaran Program</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programTargets as $index => $programTarget)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $programTarget->iku->description }}</td>
                    <td>{{ $programTarget->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
