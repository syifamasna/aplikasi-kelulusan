<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - Aplikasi Kelulusan</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>
        .card:hover {
            transform: scale(1.05);
            /* Efek pembesaran saat hover */
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        a {
            text-decoration: none;
            /* Menghilangkan underline pada link */
        }

        a:hover {
            text-decoration: none;
            /* Tetap menghilangkan underline saat hover */
        }

        /* Mengubah warna ikon sesuai dengan warna teks saat hover */
        .icon-card {
            transition: color 0.3s ease;
            color: #6e707e;
            /* Set default color for icons */
        }

        .card:hover .icon-card {
            color: inherit;
            /* Set icon color to inherit from card color */
        }

        /* Warna ikon sesuai dengan class card */
        .card.border-left-primary:hover .icon-card {
            color: #4e73df;
            /* Warna untuk primary */
        }

        .card.border-left-success:hover .icon-card {
            color: #1cc88a;
            /* Warna untuk success */
        }

        .card.border-left-info:hover .icon-card {
            color: #36b9cc;
            /* Warna untuk info */
        }

        .card.border-left-warning:hover .icon-card {
            color: #f6c23e;
            /* Warna untuk warning */
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Alert box with close button -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert" style="background-color: #e9f7fe; border-radius: 8px; border: 1px solid #bee3f8;">
                        <strong>Selamat Datang, {{ Auth::user()->name }}!</strong>
                        Selamat datang di dashboard Aplikasi Kelulusan! Anda dapat mulai mengelola data dengan mudah di sini.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Siswa Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('user.students.index') }}">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Siswa</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Total Mata Pelajaran Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="{{ route('user.subjects.index') }}">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Total Mata Pelajaran</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubjects }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-book-open fa-2x icon-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
        <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js')}}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/chart-area-demo.js')}}"></script>
        <script src="{{ asset('js/demo/chart-pie-demo.js')}}"></script>

</body>

</html>