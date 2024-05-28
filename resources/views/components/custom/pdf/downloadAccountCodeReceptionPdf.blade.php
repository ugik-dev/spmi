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
    <h2>Kode Akun Penerimaan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Akun Penerimaan</th>
                <th>Deskripsi Kode Akun Penerimaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accountCodeReceptions as $index => $accountCodeReception)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $accountCodeReception->code }}</td>
                    <td>{{ $accountCodeReception->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
