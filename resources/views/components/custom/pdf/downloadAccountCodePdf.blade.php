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
    <h2>Kode Akun</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Akun</th>
                <th>Deskripsi Akun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accountCodes as $index => $accountCode)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $accountCode->code }}</td>
                    <td>{{ $accountCode->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
