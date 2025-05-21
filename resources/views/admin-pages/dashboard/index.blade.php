<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard {{ Auth::user()->name }} - Aplikasi Kelulusan</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .card.border-left-primary:hover,
        .card.border-left-info:hover,
        .card.border-left-warning:hover,
        .card.border-left-success:hover {
            transform: scale(1.05);
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        .card.border-left-primary .icon-card,
        .card.border-left-info .icon-card,
        .card.border-left-warning .icon-card,
        .card.border-left-success .icon-card {
            transition: color 0.3s ease;
            color: #6e707e;
        }

        .card.border-left-primary:hover .icon-card,
        .card.border-left-info:hover .icon-card,
        .card.border-left-warning:hover .icon-card,
        .card.border-left-success:hover .icon-card {
            color: inherit;
        }

        /* Card warna biru untuk Siswa */
        .card.border-left-primary {
            border-left: 0.25rem solid #4e73df;
        }

        .card.border-left-primary .icon-card {
            color: #4e73df;
        }

        .card.border-left-primary:hover .icon-card {
            color: #2e59d9;
        }

        /* Card warna biru untuk Kelas */
        .card.border-left-info {
            border-left: 0.25rem solid #36b9cc;
        }

        .card.border-left-info .icon-card {
            color: #36b9cc;
        }

        .card.border-left-info:hover .icon-card {
            color: #2c9faf;
        }

        /* Card warna kuning untuk Mata Pelajaran */
        .card.border-left-warning {
            border-left: 0.25rem solid #f6c23e;
        }

        .card.border-left-warning .icon-card {
            color: #f6c23e;
        }

        .card.border-left-warning:hover .icon-card {
            color: #e0a800;
        }

        /* Card warna hijau untuk Pengguna */
        .card.border-left-success {
            border-left: 0.25rem solid #1cc88a;
        }

        .card.border-left-success .icon-card {
            color: #1cc88a;
        }

        .card.border-left-success:hover .icon-card {
            color: #17a673;
        }

        .table {
            table-layout: fixed;
            /* Menjamin kolom memiliki lebar yang seimbang */
        }

        th,
        td {
            white-space: nowrap;
            /* Agar teks tidak ke-wrap kecuali kolom tertentu */
            text-align: center;
        }

        td.nama-siswa {
            max-width: 200px;
            /* Batasi lebar kolom nama */
            white-space: normal;
            /* Izinkan teks turun ke bawah */
            word-break: break-word;
            /* Pecah kata panjang agar tidak keluar */
        }

        table.dataTable thead th {
            background-color: #4e73df;
            color: white;
            text-align: center;
        }

        /* Warna latar belang-belang */
        table.dataTable tbody tr:nth-child(odd) {
            background-color: #fcfcfc;
        }

        table.dataTable tbody tr:nth-child(even) {
            background-color: #F1F4F9;
        }

        /* Membuat kolom Nama left-aligned */
        table.dataTable tbody td:nth-child(2) {
            text-align: left;
        }

        table.dataTable td {
            text-align: center;
        }

        table.dataTable tfoot th {
            background-color: #f8f9fc;
        }

        @media (max-width: 991px) {
            .table-responsive {
                overflow-x: auto;
                display: block;
                width: 100%;
            }

            .table-responsive table {
                min-width: 800px;
                /* Pastikan tabel bisa di-scroll horizontal */
            }
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        @include('admin-pages.components.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                @include('admin-pages.components.topbar')

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <div class="alert alert-info alert-dismissible fade show" role="alert"
                        style="background-color: #e9f7fe; border-radius: 8px; border: 1px solid #bee3f8;">
                        <strong>Selamat Datang, {{ Auth::user()->name }}!</strong>
                        Selamat datang di dashboard Aplikasi Kelulusan! Anda dapat mulai mengelola data dengan mudah di
                        sini.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="row">
                        <!-- Total Siswa Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.students.index') }}">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Siswa</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Total Pengguna Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.users.index') }}">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Pengguna</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Total Kelas Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.student_classes.index') }}">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Total Kelas</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClasses }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-school fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Total Mata Pelajaran Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('admin.subjects.index') }}">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Total Mata Pelajaran</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalSubjects }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-book-open fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="row">
                            <!-- Grafik Graduation -->
                            <div class="col-md-12 mb-4">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary text-center">Daftar Siswa dengan
                                            Nilai Ujian Tertinggi</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="graduationChart" height="70"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik PPDB -->
                            <div class="col-md-12 mb-4">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary text-center">Daftar Siswa dengan
                                            Nilai Rapor Tertinggi</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="ppdbChart" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @include('admin-pages.components.footer')

            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- JavaScript -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- DataTables -->
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            const graduationLabels = {!! json_encode($topGraduationScores->map(fn($s) => $s->nama . ' (' . $s->kelas . ')')) !!};
            const graduationData = {!! json_encode($topGraduationScores->pluck('final_average')) !!};

            const ppdbLabels = {!! json_encode($topPPDBScores->map(fn($s) => $s->nama . ' (' . $s->kelas . ')')) !!};
            const ppdbData = {!! json_encode($topPPDBScores->pluck('total_average')) !!};

            const graduationChart = new Chart(document.getElementById('graduationChart'), {
                type: 'bar',
                data: {
                    labels: graduationLabels,
                    datasets: [{
                        label: 'Rata-rata Ujian',
                        data: graduationData,
                        backgroundColor: '#4e73df'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    indexAxis: 'y'
                }
            });

            const ppdbChart = new Chart(document.getElementById('ppdbChart'), {
                type: 'bar',
                data: {
                    labels: ppdbLabels,
                    datasets: [{
                        label: 'Total Rata-rata Rapor',
                        data: ppdbData,
                        backgroundColor: '#1cc88a'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    indexAxis: 'y'
                }
            });
        </script>
</body>

</html>
