<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Daftar Nilai Hasil Ujian Sekolah {{ $student->nama }} - PDF</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            margin: 10px;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 2px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
            margin-bottom: 5px;
            page-break-inside: avoid;
            /* Cegah pemisahan halaman */
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 4px;
            /* Kurangi padding */
        }

        .table th {
            text-align: center;
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

        .signature {
            width: 100%;
            margin-top: 25px;
            /* Mengurangi jarak atas signature */
            text-align: right;
        }

        .signature-content {
            display: inline-block;
            text-align: left;
        }

        .signature p {
            margin: 2px 0;
            /* Kurangi margin bawah pada paragraf */
            line-height: 1.2;
            /* Kurangi tinggi baris */
        }

        .underline {
            text-decoration: underline;
            display: inline-block;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                    alt="Logo Sekolah" style="width: 70px; height: auto; display: block; margin: 0 auto;">
                <h1 style="color: #03A3ED; font-size: 30px; margin-bottom: 0;">SEKOLAH ISLAM TERPADU ALIYA</h1>
                <h2 style="color: #039B50; font-size: 26px; margin-top: -5px;">KBIT - TKIT - SDIT</h2>
                <hr>
                <h2 style="text-decoration: underline; margin-bottom: 0px;">DAFTAR NILAI HASIL UJIAN SEKOLAH</h2>
                <p style="font-size: 16px; text-align: center; margin-top: 0px; margin-bottom: 0px;">Tahun Pelajaran
                    {{ date('Y') - 1 }}/{{ date('Y') }}</p>
            </div>
        </div>

        <table style="width: 100%; margin-top: 0px; border-spacing: 10px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p>Nama<span style="display: inline-block; width: 180px;"></span>:
                        <strong>{{ $student->nama }}</strong>
                    </p>
                    <p>Tempat dan Tanggal Lahir<span style="display: inline-block; width: 52px;"></span>:
                        <strong>{{ $student->ttl }}</strong>
                    </p>
                    <p>Nomor Induk Siswa Nasional<span style="display: inline-block; width: 37px;"></span>:
                        <strong>{{ $student->nisn }}</strong>
                    </p>
                    <p>Nomor Pokok Sekolah Nasional<span style="display: inline-block; width: 20px;"></span>:
                        <strong>{{ $schoolProfile->npsn }}</strong>
                    </p>
                </td>
            </tr>
        </table>

        <!-- Nilai Mata Pelajaran -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Muatan Pelajaran (Kurikulum Merdeka)</th>
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
                    <td class="text-center"><strong>{{ number_format($finalAverage, 2, ',', '.') }}</strong></td>
                    <!-- Ganti dengan $finalAverage -->
                </tr>
            </tbody>
        </table>

        <div class="signature">
            <div class="signature-content">
                <p>Bogor, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p>Kepala,</p>
                <div style="height: 70px;"></div> <!-- Ruang tanda tangan -->
                <p class="underline">{{ $schoolProfile->kepsek }}</p>
                <p>NIP...........................................</p>
            </div>
        </div>
    </div>

    </div>
</body>

</html>
