<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Siswa - Aplikasi Kelulusan</title>

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
        @include('components.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('components.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Siswa</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <form action="{{ route('students.store') }}" method="POST" style="overflow-x: hidden;">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama" class="control-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" id="nama" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kelas" class="control-label">Kelas</label>
                                                <select class="form-control" name="kelas" id="kelas" required>
                                                    <option value="" selected disabled>Pilih Kelas</option>
                                                    @foreach ($classes as $class)
                                                    <option value="{{ $class->kelas }}">{{ $class->kelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jk" class="control-label">Jenis Kelamin</label>
                                                <select class="form-control" name="jk" id="jk" required>
                                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" name="id">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nis" class="control-label">NIS</label>
                                                <input type="text" name="nis" class="form-control" id="nis" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nisn" class="control-label">NISN</label>
                                                <input type="text" name="nisn" class="form-control" id="nisn" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ route('students.index') }}" class="btn btn-warning">Kembali</a>
                                    <div class="clearfix"></div>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('components.footer')
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

</body>

</html>