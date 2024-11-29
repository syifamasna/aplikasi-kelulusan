<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profil Saya - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .profile-header {
            background: #4e73df;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .profile-header .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h2 {
            font-size: 24px;
            font-weight: 600;
        }

        .profile-header .role {
            font-size: 16px;
            color: #ddd;
        }

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
                    <h1 class="h3 mb-4 text-gray-800">Profil Pengguna</h1>


                    <!-- Profile Header -->
                    <div class="profile-header d-flex align-items-center mb-4">
                        <div class="profile-img mr-4">
                            @if ($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil" class="img-fluid profile-img">
                            @else
                            <i class="fas fa-user-circle fa-5x"></i>
                            @endif
                        </div>
                        <div class="profile-info">
                            <h2>{{ $user->name }}</h2>
                            <p class="role">Role: {{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

                    <!-- Profile Details Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Profil</h6>
                            <!-- Edit Profile Button -->
                            <a href="{{ route('admin.profile.edit', Auth::user()->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Profil
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>********</td>
                                    </tr>
                                    <tr>
                                        <th>Foto Profil</th>
                                        <td>
                                            @if ($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil" class="img-fluid" width="100">
                                            @else
                                            <i class="fas fa-user-circle fa-3x"></i>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>