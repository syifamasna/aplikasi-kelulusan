<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Siswa - Aplikasi Kelulusan</title>
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

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Data Siswa Kelas 6 SIT Aliya</h1>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>NIS</th>
                <th>NISN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $student->nama }}</td>
                <td>{{ $student->kelas }}</td>
                <td>{{ $student->jk }}</td>
                <td>{{ $student->nis }}</td>
                <td>{{ $student->nisn }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>