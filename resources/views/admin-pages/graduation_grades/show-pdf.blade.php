<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Ijazah Sekolah {{ $student->nama }} - PDF</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            /* Mengurangi jarak bawah header */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            /* Mengurangi jarak di atas tabel */
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        hr {
            margin: 20px 0;
        }

        .details p {
            margin: 5px 0;
        }

        .details p strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>DAFTAR NILAI<br>SEKOLAH DASAR<br>TAHUN AJARAN 2024/2025</h2>
        </div>

        <table style="width: 100%; border-spacing: 10px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                    <p><strong>Nomor Induk Siswa :</strong> {{ $student->nis }}</p>
                    <p><strong>Nomor Induk Siswa Nasional :</strong> {{ $student->nisn }}</p>
                </td>
            </tr>
        </table>

        <!-- Nilai Mata Pelajaran -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <!-- Kelompok A -->
                <tr>
                    <td colspan="3"><strong>Kelompok A</strong></td>
                </tr>
                @php
                $kelompokAIds = [1, 2, 3, 4, 5, 6];
                $nomorUrut = 1;
                @endphp
                @foreach ($kelompokAIds as $subjectId)
                @php
                $subject = $subjects->firstWhere('id', $subjectId);
                $rataRata = $averageSubjects[$subjectId] ?? 0;
                @endphp
                @if ($subject)
                <tr>
                    <td class="text-center">{{ $nomorUrut++ }}</td>
                    <td>{{ $subject->nama }}</td>
                    <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td>
                </tr>
                @endif
                @endforeach

                <!-- Kelompok B -->
                <tr>
                    <td colspan="3"><strong>Kelompok B</strong></td>
                </tr>
                @php
                $kelompokBIds = [8, 7];
                @endphp
                @foreach ($kelompokBIds as $index => $subjectId)
                @php
                $subject = $subjects->firstWhere('id', $subjectId);
                $rataRata = $averageSubjects[$subjectId] ?? 0;
                @endphp
                @if ($subject)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $subject->nama }}</td>
                    <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td>
                </tr>
                @endif
                @endforeach

                <!-- Muatan Lokal -->
                <tr>
                    <td class="text-center">3</td>
                    <td>Muatan Lokal</td>
                    <td></td>
                </tr>
                @php
                $muatanLokalIds = [10, 9, 11];
                @endphp
                @foreach ($muatanLokalIds as $subjectId)
                @php
                $subject = $subjects->firstWhere('id', $subjectId);
                $rataRata = $averageSubjects[$subjectId] ?? 0;
                @endphp
                @if ($subject)
                <tr>
                    <td></td>
                    <td>{{ $subject->nama }}</td>
                    <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td>
                </tr>
                @endif
                @endforeach

                <!-- Rata-rata -->
                <tr>
                    <td colspan="2" class="text-center"><strong>Rata-rata</strong></td>
                    <td class="text-center"><strong>{{ number_format($finalAverage, 2, ',', '.') }}</strong></td> <!-- Ganti dengan $finalAverage -->
                </tr>
            </tbody>
        </table>
    </div>

    </div>
</body>

</html>