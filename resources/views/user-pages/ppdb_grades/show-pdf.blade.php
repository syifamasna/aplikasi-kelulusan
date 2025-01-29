<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Ijazah PPDB {{ $student->nama }} - PDF</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
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
            margin: 15px 0;
            /* Mengurangi jarak horisontal */
        }

        .details p {
            margin: 3px 0;
            /* Mengurangi margin antara paragraf */
        }

        .details p strong {
            font-weight: bold;
        }

        .signature {
            width: 100%;
            margin-top: 30px;
            /* Mengurangi jarak atas signature */
            text-align: right;
        }

        .signature-content {
            display: inline-block;
            text-align: left;
        }

        .stamp {
            opacity: 0.6;
            width: 75px;
            height: 87px;
            object-fit: cover;
            margin-left: -35px;
        }

        .signature p {
            margin: 3px 0;
        }

        .underline {
            text-decoration: underline;
            display: inline-block;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>DAFTAR NILAI<br>SEKOLAH DASAR<br>TAHUN AJARAN {{ date('Y')-1 }}/{{ date('Y') }}</h2>
        </div>

        <table style="width: 100%; border-spacing: 10px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p><strong>Nama</strong><span style="display: inline-block; width: 169px;"></span>: {{ $student->nama }}</p>
                    <p><strong>Tempat dan Tanggal Lahir</strong><span style="display: inline-block; width: 32px;"></span>: </p>
                    <p><strong>Nomor Induk Siswa</strong><span style="display: inline-block; width: 76px;"></span>: {{ $student->nis }}</p>
                    <p><strong>Nomor Induk Siswa Nasional</strong><span style="display: inline-block; width: 15px;"></span>: {{ $student->nisn }}</p>
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

        <div class="signature">
            <div class="signature-content">
                <p>..............................,..............................{{ date('Y') }}</p>
                <p>Kepala,</p>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}" alt="stamp" class="stamp"><br>
                <p class="underline">Luluk Dianarini, S.TP, M.Pd.</p>
                <p>NIP...............................................................</p>
            </div>
        </div>
    </div>

    </div>
</body>

</html>