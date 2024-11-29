<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Profil - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .profile-img-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-back {
            background: #f6c23e;
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

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Edit Profil</h1>

                    <a href="{{ route('user.profile.index') }}" class="btn btn-back mb-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <!-- Edit Profile Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Profil Saya</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Foto Profil -->
                                <div class="text-center mb-4">
                                    <img id="profile-img-preview"
                                        src="{{ $user->image ? asset('storage/' . $user->image) : asset('img/default-user.png') }}"
                                        alt="Tambahkan Foto Profil"
                                        class="profile-img-preview">
                                    <div class="form-group">
                                        <label for="image">Foto Profil</label>
                                        <input type="file" name="image" id="profile-img-input" class="form-control-file">
                                    </div>
                                </div>

                                <!-- Nama -->
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password Baru <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
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

    <script>
        // Preview foto profil sebelum upload
        document.getElementById('profile-img-input').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const imgPreview = document.getElementById('profile-img-preview');
                imgPreview.src = URL.createObjectURL(file);
            }
        });
    </script>
</body>

</html>