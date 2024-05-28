<!DOCTYPE html>
<html>

<head>
    <title>Work Unit Report</title>
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
    <h2>Laporan Unit Kerja</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Unit Kerja</th>
                <th>Kode Unit Kerja</th>
                <th>Kepala Unit</th>
                <th>PPK</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workUnits as $index => $workUnit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $workUnit->name }}</td>
                    <td>{{ $workUnit->code }}</td>
                    <td>{{ $workUnit->kepalaUnit ? $workUnit->kepalaUnit->name : '-' }}</td>
                    <td>{{ $workUnit->ppkUnit ? $workUnit->ppkUnit->name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
