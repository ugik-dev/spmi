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
    <h2>Satuan Belanja</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Satuan Belanja</th>
                <th>Kode Satuan Belanja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenditureUnits as $index => $expenditureUnit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $expenditureUnit->name }}</td>
                    <td>{{ $expenditureUnit->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
