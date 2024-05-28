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
    <h2>Data User</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User Role</th>
                <th>Nama Lengkap</th>
                <th>NIP/NIK/NIDN</th>
                <th>Jabatan</th>
                <th>Unit Kerja</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->employee->id ?? '-' }}</td>
                    <td>{{ $user->employee->position ?? '-' }}</td>
                    <td>{{ $user->employee->workUnit->name ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
