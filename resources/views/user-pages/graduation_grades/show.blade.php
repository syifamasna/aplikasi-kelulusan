<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Detail Ijazah {{ $student->nama }} - Aplikasi Kelulusan</title>
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
                    <h1 class="h3 mb-4 text-gray-800 text-center">Detail Ijazah - {{ $student->nama }}</h1>

                    <!-- Data Ijazah -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: #4e73df; color: white;">
                            <h6 class="m-0 font-weight-bold text-center">Identitas Ijazah</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Baris pertama: Nama dan NIS -->
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> {{ $student->nama }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>NIS:</strong> {{ $student->nis }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Baris kedua: NISN dan Tahun Ajar -->
                                <div class="col-md-6">
                                    <p><strong>NISN:</strong> {{ $student->nisn }}</p>
                                </div>
                                <div class="col-md-6">
                                    @if ($reportCard)
                                    <p><strong>Tahun Ajar:</strong> {{ date('Y')-1 }}/{{ date('Y') }}</p>
                                    @else
                                    <p><strong>Tahun Ajar:</strong> Data tidak tersedia</p>
                                    @endif
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
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Kelompok A -->
                                        <tr>
                                            <td colspan="3" class="font-weight-bold">Kelompok A</td>
                                        </tr>
                                        @php
                                        $kelompokAIds = [1, 2, 3, 4, 5, 6];
                                        $totalRataRata = 0; // Variabel untuk menghitung total rata-rata
                                        $jumlahPelajaran = 0; // Variabel untuk menghitung jumlah mata pelajaran
                                        $nomorUrut = 1; // Penghitung nomor urut untuk Kelompok A
                                        @endphp
                                        @foreach ($kelompokAIds as $subjectId)
                                        @php
                                        // Cek apakah subject ada
                                        $subject = $subjects->firstWhere('id', $subjectId);
                                        if (!$subject) {
                                        continue; // Skip jika subject tidak ada
                                        }

                                        // Ambil nilai rata-rata dari $averageSubjects
                                        $rataRata = $averageSubjects[$subjectId] ?? 0;
                                        $totalRataRata += $rataRata; // Menambahkan nilai rata-rata untuk perhitungan rata-rata akhir
                                        $jumlahPelajaran++; // Menambah jumlah mata pelajaran
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $nomorUrut++ }}</td> <!-- Nomor urut tetap berlanjut -->
                                            <td><strong>{{ $subject->nama ?? 'Tidak ada data' }}</strong></td> <!-- Bold nama mata pelajaran -->
                                            <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td> <!-- Format angka dengan dua desimal -->
                                        </tr>
                                        @endforeach

                                        <!-- Kelompok B -->
                                        <tr>
                                            <td colspan="3" class="font-weight-bold">Kelompok B</td>
                                        </tr>
                                        @php
                                        $kelompokBIds = [8, 7]; // Mengubah urutan kelompok B
                                        $muatanLokalIds = [10, 9, 11]; // Mengubah urutan Muatan Lokal
                                        @endphp
                                        @foreach ($kelompokBIds as $index => $subjectId)
                                        @php
                                        $subject = $subjects->firstWhere('id', $subjectId);
                                        if (!$subject) {
                                        continue; // Skip jika subject tidak ada
                                        }

                                        // Ambil nilai rata-rata dari $averageSubjects
                                        $rataRata = $averageSubjects[$subjectId] ?? 0;
                                        $totalRataRata += $rataRata; // Menambahkan nilai rata-rata untuk perhitungan rata-rata akhir
                                        $jumlahPelajaran++; // Menambah jumlah mata pelajaran
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td> <!-- Nomor urut tetap berlanjut -->
                                            <td><strong>{{ $subject->nama ?? 'Tidak ada data' }}</strong></td> <!-- Bold nama mata pelajaran -->
                                            <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td> <!-- Format angka dengan dua desimal -->
                                        </tr>
                                        @endforeach

                                        <!-- Baris Muatan Lokal -->
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td><strong>Muatan Lokal</strong></td> <!-- Bold Muatan Lokal -->
                                            <td></td>
                                        </tr>
                                        @foreach ($muatanLokalIds as $index => $subjectId)
                                        @php
                                        $subject = $subjects->firstWhere('id', $subjectId);
                                        if (!$subject) {
                                        continue; // Skip jika subject tidak ada
                                        }

                                        // Ambil nilai rata-rata dari $averageSubjects
                                        $rataRata = $averageSubjects[$subjectId] ?? 0;
                                        $totalRataRata += $rataRata; // Menambahkan nilai rata-rata untuk perhitungan rata-rata akhir
                                        $jumlahPelajaran++; // Menambah jumlah mata pelajaran
                                        @endphp
                                        <tr>
                                            <td class="text-center"></td>
                                            <td><strong>{{ $subject->nama ?? 'Tidak ada data' }}</strong></td> <!-- Bold nama mata pelajaran -->
                                            <td class="text-center">{{ number_format($rataRata, 2, ',', '.') }}</td> <!-- Format angka dengan dua desimal -->
                                        </tr>
                                        @endforeach

                                        <!-- Rata-rata Akhir -->
                                        <tr>
                                            <td colspan="2" class="text-center font-weight-bold">Rata-rata</td>
                                            <td class="text-center font-weight-bold">
                                                @php
                                                $rataRataAkhir = $jumlahPelajaran > 0 ? round($totalRataRata / $jumlahPelajaran, 2) : 0;
                                                @endphp
                                                {{ number_format($rataRataAkhir, 2, ',', '.') }} <!-- Format angka dengan dua desimal -->
                                            </td>
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
                        <a href="{{ route('user.graduation_grades.export-pdf', ['studentId' => $student->id]) }}" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Ijazah</a>
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