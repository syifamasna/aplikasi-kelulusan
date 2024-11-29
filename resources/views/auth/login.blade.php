<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Aplikasi Kelulusan</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>
        /* Latar belakang gradient */
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a) !important;
        }

        .bg-login-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 250px;
        }

        .bg-login-image img {
            max-height: 100%;
            width: auto;
        }

        .form-container {
            padding: 20px;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            margin: auto;
            width: 100%;
            max-width: 600px;
        }

        /* Menambahkan styling untuk input password */
        .password-container {
            position: relative;
        }

        .password-container .fa-eye,
        .password-container .fa-eye-slash {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            /* Warna biru */
            border-color: #007bff;
            /* Border biru */
            color: #fff;
            /* Warna teks */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Warna lebih gelap saat hover */
            border-color: #004085;
            /* Warna border saat hover */
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container login-container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-10">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Gambar di atas -->
                        <div class="bg-login-image">
                            <img src="{{ asset('img/logo_aliya.png')}}" alt="Logo SIT Aliya">
                        </div>
                        <div class="form-container text-center">
                            <h1 class="h4 text-gray-900 mb-4">Login Aplikasi Kelulusan SIT Aliya</h1>

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

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Masukkan Email..." required>
                                </div>
                                <div class="form-group password-container">
                                    <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Masukkan Password..." required>
                                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js')}}"></script>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const passwordField = document.getElementById("password");

        togglePassword.addEventListener("click", function() {
            // Toggle the type of the password field
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;

            // Toggle the icon
            this.classList.toggle("fa-eye-slash");
            this.classList.toggle("fa-eye");
        });
    </script>

</body>

</html>