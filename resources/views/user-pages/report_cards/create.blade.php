<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tambah Nilai Rapor {{ $student->nama }} - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        @include('user-pages.components.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('user-pages.components.topbar')

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

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">Tabel Identitas Rapor</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('user.report_cards.store', $student->id) }}" method="POST" style="overflow-x: hidden;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama" class="control-label"><strong>Nama Peserta Didik</strong></label>
                                                <input type="text" name="nama" class="form-control" id="nama" value="{{ $student->nama }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nis" class="control-label"><strong>NIS</strong></label>
                                                <input type="text" name="nis" class="form-control" id="nis" value="{{ $student->nis }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nisn" class="control-label"><strong>NISN</strong></label>
                                                <input type="text" name="nisn" class="form-control" id="nisn" value="{{ $student->nisn }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kelas" class="control-label"><strong>Kelas</strong></label>
                                                <select class="form-control" name="kelas" id="kelas" disabled>
                                                    <option value="{{ $student->studentClass->kelas ?? '' }}">
                                                        {{ $student->studentClass->kelas ?? 'Belum diatur' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="semester" class="control-label"><strong>Semester</strong></label>
                                                <select name="semester" class="form-control" id="semester" required>
                                                    <option value="" disabled selected>Pilih Semester</option>
                                                    <option value="Level 4 Semester 1">Level 4 Semester 1</option>
                                                    <option value="Level 4 Semester 2">Level 4 Semester 2</option>
                                                    <option value="Level 5 Semester 1">Level 5 Semester 1</option>
                                                    <option value="Level 5 Semester 2">Level 5 Semester 2</option>
                                                    <option value="Level 6 Semester 1">Level 6 Semester 1</option>
                                                    <option value="Level 6 Semester 2">Level 6 Semester 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tahun_ajar" class="control-label"><strong>Tahun Ajar</strong></label>
                                                <select class="form-control" name="tahun_ajar" id="tahun_ajar" required>
                                                    <option value="" selected disabled>Pilih Tahun Ajar</option>
                                                    @foreach($school_years->sortBy('tahun_ajar') as $school_year)
                                                    <option value="{{ $school_year->tahun_ajar }}">{{ $school_year->tahun_ajar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabel Mata Pelajaran -->
                                    <br>
                                    <h6 class="m-0 font-weight-bold text-primary text-center">Mata Pelajaran</h6><br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Mata Pelajaran</th>
                                                    <th class="text-center">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subjects->sortBy('id') as $subject)
                                                <tr>
                                                    <td><strong>{{ $subject->nama }}</strong></td>
                                                    <td>
                                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." min="0" max="100" required>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <br>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success">Simpan Nilai Rapor</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('user-pages.components.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>

</html>