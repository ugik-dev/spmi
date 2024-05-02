<!DOCTYPE html>
<html>

<head>
    <title>Indikator Kinerja Utama</title>
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
    <h2>Indikator Kinerja Utama</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Misi</th>
                <th>IKU</th>
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
