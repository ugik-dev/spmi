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
    <h2>Misi</h2>
    <table>
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Misi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($missions as $index => $mission)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mission->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
