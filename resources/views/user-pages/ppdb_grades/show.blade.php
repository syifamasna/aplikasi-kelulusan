<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Surat Keterangan Nilai Rapor {{ $student->nama }} - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
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
                    <h1 class="h3 mb-4 text-gray-800 text-center">Surat Keterangan Nilai Rapor - {{ $student->nama }}
                    </h1>

                    <!-- Data Ijazah -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Identitas Siswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Nomor Induk Siswa Nasional:</strong> {{ $student->nisn }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Tempat dan Tanggal Lahir:</strong> {{ $student->ttl }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Nomor Pokok Sekolah Nasional:</strong> {{ $schoolProfile->npsn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Nilai Mata Pelajaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr style="background-color: #343a40; color: white; text-align: center;">
                                            <th rowspan="2" style="width: 5%;">No</th>
                                            <th rowspan="2" style="width: 20%;">Muatan Pelajaran (Kurikulum Merdeka)
                                            </th>
                                            <th colspan="7">Nilai Rapor</th>
                                        </tr>
                                        <tr style="background-color: #343a40; color: white; text-align: center;">
                                            <th>4.1</th>
                                            <th>4.2</th>
                                            <th>5.1</th>
                                            <th>5.2</th>
                                            <th>6.1</th>
                                            <th>Jumlah</th>
                                            <th>Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subjectIds = array_keys($averageSubjects);
                                            $nomorUrut = 1;
                                            $totalJumlahNilai = 0;
                                            $jumlahSemester = 5; // Karena semester keys: 4.1,4.2,5.1,5.2,6.1
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
                                                <td><strong>{{ $subject->nama ?? 'Tidak ada data' }}</strong></td>
                                                @foreach ($nilaiSemesters as $nilai)
                                                    <td class="text-center">
                                                        {{ fmod($nilai, 1) == 0 ? number_format($nilai, 0, ',', '.') : number_format($nilai, 2, ',', '.') }}
                                                    </td>
                                                @endforeach
                                                <td class="text-center font-weight-bold">
                                                    {{ number_format($jumlahNilai, 0, ',', '.') }}</td>
                                                <td class="text-center font-weight-bold">
                                                    {{ number_format($rataRata, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach

                                        <tr style="background-color: #f8f9fc; font-weight: bold; text-align: center;">
                                            <td colspan="7">Total</td>
                                            <td>{{ number_format($totalJumlahNilai, 0, ',', '.') }}</td>
                                            <td>{{ number_format($ppdbGrade->total_average, 2, ',', '.') }}</td>
                                        </tr>
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

                    <!-- Tombol Kembali -->
                    <div class="form-group text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('user.ppdb_grades.export-pdf', ['studentId' => $student->id]) }}"
                            class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Nilai</a>
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
