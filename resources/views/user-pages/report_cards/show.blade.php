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
                                <!-- Kolom Kiri -->
                                <div class="col-md-9">
                                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                                    <p><strong>NIS / NISN:</strong> {{ $student->nis }} / {{ $student->nisn }}</p>
                                    <p><strong>Alamat Sekolah:</strong> {{ $schoolProfile->alamat }}</p>
                                </div>
                                <!-- Kolom Kanan -->
                                <div class="col-md-3">
                                    <p><strong>Kelas:</strong> {{ $student->studentClass->kelas ?? 'Belum diatur' }}</p>
                                    <p><strong>Semester:</strong> {{ $reportCard->semester }}</p>
                                    <p><strong>Fase:</strong>
                                        @if(in_array($reportCard->semester, ['Level 4 Semester 1', 'Level 4 Semester 2']))
                                        B
                                        @elseif(in_array($reportCard->semester, ['Level 5 Semester 1', 'Level 5 Semester 2', 'Level 6 Semester 1', 'Level 6 Semester 2']))
                                        C
                                        @else
                                        Tidak Diketahui
                                        @endif
                                    </p>
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
                                        @foreach ($reportCard->subjects->sortBy('pivot.subject_id') as $subject)
                                        @php
                                        $nilai = $subject->pivot->nilai ?? 'Belum diisi';
                                        @endphp
                                        <tr class="{{ $loop->odd ? 'odd-row' : 'even-row' }}">
                                            <td style="text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $subject->nama }}</strong>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                {{ $nilai }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="form-group text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('user.report_cards.export-pdf', ['student' => $student->id, 'reportCard' => $reportCard->id]) }}" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Rapor</a>
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