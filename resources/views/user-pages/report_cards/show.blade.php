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
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('user-pages.components.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('user-pages.components.topbar')
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
                                                @php
                                                $nilai = $reportCard->subjects->firstWhere('id', $subject->id)->pivot->nilai ?? 'Belum diisi';
                                                @endphp
                                                {{ $nilai }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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

                    <!-- Ketidakhadiran -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Absensi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Sakit:</strong> {{ $reportCard->sakit ?? '-' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Izin:</strong> {{ $reportCard->izin ?? '-' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Alfa:</strong> {{ $reportCard->alfa ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prestasi -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Prestasi</h6>
                        </div>
                        <div class="card-body">
                            @php
                            $prestasi = json_decode($reportCard->prestasi, true) ?? [];
                            $ket_prestasi = json_decode($reportCard->ket_prestasi, true) ?? [];
                            @endphp

                            <!-- Jika tidak ada data prestasi, tetap tampilkan form dengan nilai default -->
                            @if (count($prestasi) > 0)
                            @foreach ($prestasi as $index => $prestasiItem)
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Prestasi {{ $index + 1 }}:</strong> {{ $prestasiItem ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Keterangan:</strong> {{ $ket_prestasi[$index] ?? '-' }}</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <!-- Menampilkan form dengan nilai default "-" jika tidak ada prestasi -->
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Jenis Prestasi 1:</strong> -</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Keterangan:</strong> -</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Jenis Prestasi 2:</strong> -</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Keterangan:</strong> -</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ekstrakurikuler -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Ekstrakurikuler</h6>
                        </div>
                        <div class="card-body">
                            @php
                            $ekskul = json_decode($reportCard->ekskul);
                            $nilai_ekskul = json_decode($reportCard->nilai_ekskul);
                            $ket_ekskul = json_decode($reportCard->ket_ekskul);
                            @endphp
                            @foreach ($ekskul as $index => $ekskulItem)
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Ekstrakurikuler {{ $index + 1 }}:</strong> {{ $ekskulItem ?? '-' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Nilai:</strong> {{ $nilai_ekskul[$index] ?? '-' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Keterangan:</strong> {{ $ket_ekskul[$index] ?? '-' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="form-group text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('user-pages.components.footer')
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