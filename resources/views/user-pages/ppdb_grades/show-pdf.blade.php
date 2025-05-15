<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Surat Keterangan Nilai Rapor {{ $student->nama }} - PDF</title>
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
            border: 1px solid black;
            padding: 8px;
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
            margin-top: 30px;
            /* Mengurangi jarak atas signature */
            text-align: right;
        }

        .signature-content {
            display: inline-block;
            text-align: left;
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
            <div style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                    alt="Logo Sekolah" style="width: 70px; height: auto; display: block; margin: 0 auto;">
                <h1 style="color: #03A3ED; font-size: 30px; margin-bottom: 0;">SEKOLAH ISLAM TERPADU ALIYA</h1>
                <h2 style="color: #039B50; font-size: 26px; margin-top: -5px;">KBIT - TKIT - SDIT</h2>
                <hr>
                <h2 style="text-decoration: underline;">SURAT KETERANGAN NILAI RAPOR</h2>
                <p style="text-align: justify;">Yang bertanda tangan di bawah ini, Kepala SD Islam Terpadu Aliya,
                    Kecamatan Bogor Barat, Kota Bogor, menerangkan bahwa :</p>
            </div>
        </div>

        <table style="width: 100%; border-spacing: 10px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p>Nama<span style="display: inline-block; width: 180px;"></span>:
                        <strong>{{ $student->nama }}</strong></p>
                    <p>Tempat dan Tanggal Lahir<span style="display: inline-block; width: 52px;"></span>:
                        <strong>{{ $student->ttl }}</strong></p>
                    <p>Nomor Induk Siswa Nasional<span style="display: inline-block; width: 37px;"></span>:
                        <strong>{{ $student->nisn }}</strong></p>
                    <p>Nomor Pokok Sekolah Nasional<span style="display: inline-block; width: 20px;"></span>:
                        <strong>{{ $schoolProfile->npsn }}</strong></p>
                </td>
            </tr>
        </table>

        <!-- Nilai Mata Pelajaran -->
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2">Muatan Pelajaran (Kurikulum Merdeka)</th>
                    <th colspan="7" class="text-center">Nilai Rapor</th>
                </tr>
                <tr>
                    <th class="text-center">4.1</th>
                    <th class="text-center">4.2</th>
                    <th class="text-center">5.1</th>
                    <th class="text-center">5.2</th>
                    <th class="text-center">6.1</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subjectIds = array_keys($averageSubjects);
                    $nomorUrut = 1;
                    $totalJumlahNilai = 0;
                    $jumlahSemester = 5;
                @endphp

                @foreach ($subjectIds as $subjectId)
                    @php
                        $subject = $subjects->firstWhere('id', $subjectId);
                        if (!$subject) {
                            continue;
                        }

                        $nilaiSemesters = [
                            '4.1' => $averageSubjects[$subjectId]['nilai']['4.1'] ?? 0,
                            '4.2' => $averageSubjects[$subjectId]['nilai']['4.2'] ?? 0,
                            '5.1' => $averageSubjects[$subjectId]['nilai']['5.1'] ?? 0,
                            '5.2' => $averageSubjects[$subjectId]['nilai']['5.2'] ?? 0,
                            '6.1' => $averageSubjects[$subjectId]['nilai']['6.1'] ?? 0,
                        ];

                        $jumlahNilai = array_sum($nilaiSemesters);
                        $rataRata = $jumlahNilai / $jumlahSemester;
                        $totalJumlahNilai += $jumlahNilai;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $nomorUrut++ }}</td>
                        <td>{{ $subject->nama ?? 'Tidak ada data' }}</td>
                        @foreach ($nilaiSemesters as $nilai)
                            <td class="text-center">
                                {{ fmod($nilai, 1) == 0 ? number_format($nilai, 0, ',', '.') : number_format($nilai, 2, ',', '.') }}
                            </td>
                        @endforeach
                        <td class="text-center font-weight-bold">
                            {{ number_format($jumlahNilai, 0, ',', '.') }}
                        </td>
                        <td class="text-center font-weight-bold">
                            {{ number_format($rataRata, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="7" class="text-center font-weight-bold">Total</td>
                    <td class="text-center font-weight-bold">
                        {{ number_format($totalJumlahNilai, 0, ',', '.') }}
                    </td>
                    <td class="text-center font-weight-bold">
                        {{ number_format($ppdbGrade->total_average, 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: justify;">Daftar nilai rapor sekolah dasar tahun {{ date('Y') }} ini digunakan untuk
            pendaftaran ke SMP/MTS.</p>

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
