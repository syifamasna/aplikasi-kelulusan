<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Detail Nilai Rapor {{ $student->nama }} - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>
        /* Gaya untuk baris ganjil dan genap */
        .odd-row {
            background-color: #fcfcfc;
        }

        .even-row {
            background-color: #F1F4F9;
        }

        /* Gaya untuk header tabel */
        thead {
            background-color: #343a40;
            /* Warna abu-abu gelap untuk header */
            color: white;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin-pages.components.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('admin-pages.components.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 text-center">Detail Nilai Rapor - {{ $student->nama }}</h1>

                    <!-- Data Rapor -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Identitas Rapor</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>NIS:</strong> {{ $student->nis }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>NISN:</strong> {{ $student->nisn }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Kelas:</strong> {{ $student->studentClass->kelas ?? 'Belum diatur' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Semester:</strong> {{ $reportCard->semester }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Tahun Ajar:</strong> {{ $reportCard->tahun_ajar }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Mata Pelajaran -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Nilai Mata Pelajaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead style="background-color: #343a40; color: white; text-align: center;">
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">No</th>
                                            <th style="text-align: left;">Mata Pelajaran</th>
                                            <th style="text-align: center; vertical-align: middle;">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportCard->subjects as $subject)
                                        @php
                                        // Cek apakah subject ini termasuk ID 12 hingga 15 dan nilai tidak diisi
                                        $nilai = $reportCard->subjects->firstWhere('id', $subject->id)->pivot->nilai ?? null;
                                        $is_optional_subject = in_array($subject->id, [12, 13, 14, 15]);
                                        @endphp

                                        @if (!$is_optional_subject || ($is_optional_subject && $nilai !== null)) <!-- Hanya tampilkan jika nilai ada -->
                                        <tr class="{{ $loop->odd ? 'odd-row' : 'even-row' }}">
                                            <td style="text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $subject->nama }}</strong><br>

                                                <!-- Memastikan apakah subject memiliki detail -->
                                                @php
                                                $details = json_decode($subject->pivot->details, true);
                                                @endphp

                                                <!-- Garis Pemisah jika membutuhkan informasi tambahan -->
                                                @if (in_array($subject->id, [12, 13, 14, 15]))
                                                <hr style="border: 1px solid #ddd; margin-top: 5px; margin-bottom: 10px;">
                                                @endif

                                                <!-- Menampilkan informasi tambahan untuk mata pelajaran tertentu -->
                                                @if ($subject->id == 12 || $subject->id == 13)
                                                <p>Target Akhir Semester: {{ $details['target'] ?? 'Tidak ada target' }}</p>
                                                <hr style="border: 1px solid #ddd; margin-top: 5px; margin-bottom: 10px;">
                                                <p>Capaian Saat Ini: {{ $details['capaian'] ?? 'Tidak ada capaian' }}</p>
                                                @elseif ($subject->id == 14)
                                                <p>Target: {{ $details['target'] ?? 'Tidak ada target' }}</p>
                                                @elseif ($subject->id == 15)
                                                @php
                                                $aplikasi = $details['aplikasi'] ?? null;
                                                @endphp
                                                <p>Aplikasi/Program: {{ $aplikasi ?? 'Tidak ada aplikasi/program' }}</p>
                                                @endif
                                            </td>

                                            <!-- Kolom Nilai -->
                                            <td style="text-align: center; vertical-align: middle;">
                                                {{ $nilai ?? 'Belum diisi' }}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Prestasi -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Prestasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead style="background-color: #343a40; color: white; text-align: center;">
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; width: 10%;">No</th>
                                            <th style="text-align: left; width: 30%;">Jenis Prestasi</th>
                                            <th style="text-align: center; vertical-align: middle; width: 60%;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $prestasi = json_decode($reportCard->prestasi, true) ?? [];
                                        $ket_prestasi = json_decode($reportCard->ket_prestasi, true) ?? [];
                                        @endphp

                                        @if (count($prestasi) > 0)
                                        @foreach ($prestasi as $index => $prestasiItem)
                                        <tr class="{{ $loop->odd ? 'odd-row' : 'even-row' }}">
                                            <td style="text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
                                            <td>{{ $prestasiItem ?? '-' }}</td>
                                            <td style="text-align: center; vertical-align: middle;">{{ $ket_prestasi[$index] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <!-- Jika tidak ada data prestasi, tampilkan baris kosong dengan nilai default -->
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">1</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">2</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                            <td style="text-align: center; vertical-align: middle;">-</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Guru -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Catatan Guru</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $reportCard->catatan ?? 'Tidak ada catatan dari guru.' }}</p>
                        </div>
                    </div>

                    <!-- Ketidakhadiran -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Ketidakhadiran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left; width: 50%;">Sakit</td>
                                            <td style="text-align: center; width: 50%;">{{ $reportCard->sakit ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">Izin</td>
                                            <td style="text-align: center;">{{ $reportCard->izin ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">Tanpa Keterangan</td>
                                            <td style="text-align: center;">{{ $reportCard->alfa ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="form-group text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('admin.report_cards.export-pdf', ['student' => $student->id, 'reportCard' => $reportCard->id]) }}" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Rapor</a>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin-pages.components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>

</html>