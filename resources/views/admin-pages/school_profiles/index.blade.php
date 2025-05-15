<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data Sekolah - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .card .card-header {
            background: #f8f9fc;
            font-weight: 600;
        }

        .card .card-body {
            background: #fff;
        }

        .table td,
        .table th {
            vertical-align: middle;
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
                    <h1 class="h3 mb-4 text-gray-800">Data Sekolah</h1>
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="row">
                            <!-- Card Informasi Sekolah -->
                            <div class="col-md-7">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Sekolah</h6>
                                        <a href="{{ route('admin.school_profiles.edit', $school_profiles->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Nama Sekolah</th>
                                                <td>{{ $school_profiles->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kepala Sekolah</th>
                                                <td>{{ $school_profiles->kepsek }}</td>
                                            </tr>
                                            <tr>
                                                <th>NPSN</th>
                                                <td>{{ $school_profiles->npsn }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kode Pos</th>
                                                <td>{{ $school_profiles->kode_pos }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telepon</th>
                                                <td>{{ $school_profiles->telepon }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $school_profiles->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $school_profiles->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Website</th>
                                                <td>{{ $school_profiles->website }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Logo Sekolah -->
                            <div class="col-md-5">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Logo Sekolah</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <!-- Preview Gambar (Default: Icon Sekolah) -->
                                        <div id="imagePreviewContainer">
                                            @if ($school_profiles->logo)
                                            <img id="imagePreview" src="{{ asset('storage/' . $school_profiles->logo) }}" class="img-fluid mb-3" width="150">
                                            @else
                                            <i id="defaultIcon" class="fas fa-school fa-3x text-secondary mb-3"></i>
                                            <img id="imagePreview" src="" class="img-fluid mb-3 d-none" width="100" style="border: 1px solid #ddd; padding: 5px;">
                                            @endif
                                        </div>

                                        <!-- Tombol Hapus Logo -->
                                        @if ($school_profiles->logo)
                                        <form action="{{ route('admin.school_profiles.deleteLogo', $school_profiles->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-3">Hapus Logo</button>
                                        </form>
                                        @endif

                                        <!-- Form Upload Logo -->
                                        <form action="{{ route('admin.school_profiles.uploadLogo', $school_profiles->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input type="file" name="logo" class="form-control" required accept="image/*" id="inputLogo">
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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

        <!-- Script Preview Gambar -->
        <script>
            document.getElementById('inputLogo').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const imagePreview = document.getElementById('imagePreview');
                const defaultIcon = document.getElementById('defaultIcon');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        defaultIcon?.classList.add('d-none'); // Sembunyikan icon sekolah
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = "";
                    imagePreview.classList.add('d-none');
                    defaultIcon?.classList.remove('d-none'); // Tampilkan kembali icon sekolah
                }
            });
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>