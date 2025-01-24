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
            <h2>LAPORAN HASIL BELAJAR (RAPOR) PESERTA DIDIK<br>SEKOLAH DASAR ISLAM TERPADU ALIYA KOTA BOGOR</h2>
        </div>

        <table style="width: 100%; border-spacing: 10px;">
            <tr>
                <td style="width: 33%; vertical-align: top;">
                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                    <p><strong>NIS/NISN:</strong> {{ $student->nis }} / {{ $student->nisn }}</p>
                    <p><strong>Kelas:</strong> {{ $student->studentClass->kelas ?? 'Belum diatur' }}</p>
                </td>
                <td style="width: 17%; vertical-align: top;">
                    <p><strong>Semester:</strong> {{ $reportCard->semester }}</p>
                    <p><strong>Tahun Ajar:</strong> {{ $reportCard->tahun_ajar }}</p>
                </td>
            </tr>
        </table>

        <!-- Tabel Mata Pelajaran -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportCard->subjects as $subject)
                @php
                // Mendapatkan nilai dan informasi tambahan (target, capaian, aplikasi)
                $nilai = $reportCard->subjects->firstWhere('id', $subject->id)->pivot->nilai ?? null;
                $details = json_decode($subject->pivot->details, true) ?? [];
                $is_optional_subject = in_array($subject->id, [12, 13, 14, 15]);
                @endphp

                @if (!$is_optional_subject || ($is_optional_subject && $nilai !== null)) <!-- Hanya tampilkan jika nilai ada atau tidak opsional -->
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        <strong>{{ $subject->nama }}</strong><br>

                        <!-- Menambahkan garis setelah nama mata pelajaran jika ada informasi tambahan -->
                        @if ($subject->id == 12 || $subject->id == 13)
                        <hr style="border: 1px solid #ddd; margin-top: 5px; margin-bottom: 10px;">
                        <p><strong>Target Akhir Semester:</strong> {{ $details['target'] ?? 'Tidak ada target' }}</p>
                        <p><strong>Capaian Saat Ini:</strong> {{ $details['capaian'] ?? 'Tidak ada capaian' }}</p>
                        @elseif ($subject->id == 14)
                        <hr style="border: 1px solid #ddd; margin-top: 5px; margin-bottom: 10px;">
                        <p><strong>Target:</strong> {{ $details['target'] ?? 'Tidak ada target' }}</p>
                        @elseif ($subject->id == 15)
                        <hr style="border: 1px solid #ddd; margin-top: 5px; margin-bottom: 10px;">
                        <p><strong>Aplikasi/Program:</strong> {{ $details['aplikasi'] ?? 'Tidak ada aplikasi/program' }}</p>
                        @endif
                    </td>
                    <td class="text-center">{{ $nilai ?? 'Belum diisi' }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <!-- Prestasi -->
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10%;">No</th>
                    <th>Jenis Prestasi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                $prestasi = json_decode($reportCard->prestasi, true) ?? [];
                $ket_prestasi = json_decode($reportCard->ket_prestasi, true) ?? [];
                @endphp

                @if (count($prestasi) > 0)
                @foreach ($prestasi as $index => $prestasiItem)
                <tr>
                    <td class="text-center" style="width: 10%;">{{ $index + 1 }}</td>
                    <td>{{ $prestasiItem }}</td>
                    <td>{{ $ket_prestasi[$index] ?? '-' }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" style="width: 10%;">1</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                </tr>
                <tr>
                    <td class="text-center" style="width: 10%;">2</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Catatan Guru -->
        <table class="table">
            <thead>
                <tr>
                    <th>Catatan Guru</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>{{ $reportCard->catatan ?? 'Tidak ada catatan dari guru.' }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Ketidakhadiran -->
        <table class="table">
            <thead>
                <tr>
                    <th>Ketidakhadiran</th>
                    <th>Jumlah Hari</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">Sakit</td>
                    <td class="text-center">{{ $reportCard->sakit ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left">Izin</td>
                    <td class="text-center">{{ $reportCard->izin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left">Tanpa Keterangan</td>
                    <td class="text-center">{{ $reportCard->alfa ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>