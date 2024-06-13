<!DOCTYPE html>
<html>

<head>
    <title>Export PDF</title>

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
    <h2>Data Timeline</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Metode Approval</th>
                <th>Tahun</th>
                <th>Dari</th>
                <th>Sampai</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timelines as $index => $timeline)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ strtoupper(categoryTimeline($timeline->category)) }}</td>
                    <td>{!! $timeline->metode !!}</td>
                    <td>{{ $timeline->year }}</td>
                    <td>{{ $timeline->start }}</td>
                    <td>{{ $timeline->end }}</td>
                    <td>{{ $timeline->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
