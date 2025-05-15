<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Nilai Rapor {{ $student->nama }} - PDF</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 12px;
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
            margin-top: 20px;
            margin-bottom: 20px;
            /* Mengurangi jarak bawah header */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 10px;
        }

        .table th {
            background-color: #f2f2f2;
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
            margin: 20px 0;
        }

        .details p {
            margin: 5px 0;
        }

        .details p strong {
            font-weight: bold;
        }

        .signature {
            display: flex;
            width: 100%;
            margin-top: 60px;
            /* Mengurangi jarak atas signature */
            text-align: center;
            justify-content: space-between;
        }

        .signature-content {
            display: inline-block;
            width: 30%;
            text-align: center;
        }

        .signature p {
            margin: 3px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>LAPORAN HASIL BELAJAR (RAPOR) PESERTA DIDIK<br>
                @if(in_array($reportCard->semester, ['Level 4 Semester 1', 'Level 5 Semester 1', 'Level 6 Semester 1']))
                SEMESTER I (SATU)
                @elseif(in_array($reportCard->semester, ['Level 4 Semester 2', 'Level 5 Semester 2', 'Level 6 Semester 2']))
                SEMESTER II (DUA)
                @else
                SEMESTER TIDAK DIKETAHUI
                @endif
                TAHUN PELAJARAN {{ $reportCard->tahun_ajar }}<br>
                SEKOLAH DASAR ISLAM TERPADU ALIYA KOTA BOGOR
            </h3>

        </div>

        <table style="width: 100%; border-spacing: 5px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p><strong>Nama Peserta Didik</strong><span style="display: inline-block; width: 20px;"></span>: {{ $student->nama }}</p>
                    <p><strong>NIS / NISN</strong><span style="display: inline-block; width: 82px;"></span>: {{ $student->nis }} / {{ $student->nisn }}</p>
                    <p><strong>Alamat Sekolah</strong><span style="display: inline-block; width: 47px;"></span>: {{ $schoolProfile->alamat }}</p>
                </td>
                <td style="width: 15%; vertical-align: top;">
                    <p><strong>Kelas</strong><span style="display: inline-block; width: 40px;"></span>: {{ $student->studentClass->kelas ?? 'Belum diatur' }}</p>
                    <p><strong>Fase</strong><span style="display: inline-block; width: 45px;"></span>:
                        @if(in_array($reportCard->semester, ['Level 4 Semester 1', 'Level 4 Semester 2']))
                        B
                        @elseif(in_array($reportCard->semester, ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2']))
                        C
                        @else
                        Tidak Diketahui
                        @endif
                    </p>
                </td>
            </tr>
        </table>

        <!-- Tabel Mata Pelajaran -->
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle;">No</th>
                    <th style="text-align: center;">Mata Pelajaran</th>
                    <th style="text-align: center; vertical-align: middle;">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportCard->subjects->sortBy('pivot.subject_id') as $subject)
                @php
                $nilai = $subject->pivot->nilai ?? 'Belum diisi';
                @endphp
                <tr class="{{ $loop->odd ? 'odd-row' : 'even-row' }}">
                    <td style="text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td>
                        {{ $subject->nama }}
                    <td style="text-align: center; vertical-align: middle;">
                        {{ $nilai }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <div class="signature-content">
                <p>Orangtua / Wali</p>
                <div style="height: 80px;"></div> <!-- Ruang tanda tangan -->
                <p><strong>(...............................................)</strong></p>
            </div>

            <div class="signature-content" style="position: relative; top: 110px;">
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <div style="height: 70px;"></div> <!-- Ruang tanda tangan -->
                <p><strong>{{ $schoolProfile->kepsek ?? '...............................................' }}</strong></p>
            </div>

            <div class="signature-content">
                <p>Bogor, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p>Wali Kelas</p>
                <div style="height: 70px;"></div> <!-- Ruang tanda tangan -->
                <p><strong>{{ $studentClass->nama_guru ?? '............................................' }}</strong></p>
            </div>
        </div>

    </div>
</body>

</html>