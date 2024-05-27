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
    <h2>Sasaran Program</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Misi</th>
                <th>Sasaran Program</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ikus as $index => $iku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $iku->mission->description }}</td>
                    <td>{{ $iku->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
