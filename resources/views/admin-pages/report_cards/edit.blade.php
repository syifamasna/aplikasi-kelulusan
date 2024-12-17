<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Nilai Rapor {{ $student->nama }} - Aplikasi Kelulusan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_aliya.png') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin-pages.components.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin-pages.components.topbar')

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
                                <form action="{{ route('admin.report_cards.update', [$student->id, $reportCard->id]) }}" method="POST" style="overflow-x: hidden;">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama" class="control-label">Nama Peserta Didik</label>
                                                <input type="text" name="nama" class="form-control" id="nama" value="{{ $student->nama }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nis" class="control-label">NIS</label>
                                                <input type="text" name="nis" class="form-control" id="nis" value="{{ $student->nis }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nisn" class="control-label">NISN</label>
                                                <input type="text" name="nisn" class="form-control" id="nisn" value="{{ $student->nisn }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kelas" class="control-label">Kelas</label>
                                                <select class="form-control" name="kelas" id="kelas" disabled>
                                                    <option value="{{ $student->studentClass->kelas ?? '' }}">
                                                        {{ $student->studentClass->kelas ?? 'Belum diatur' }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="semester" class="control-label">Semester</label>
                                                <input type="text" name="semester" class="form-control" id="semester" value="{{ old('semester', $reportCard->semester) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tahun_ajar" class="control-label">Tahun Ajar</label>
                                                <select class="form-control" name="tahun_ajar" id="tahun_ajar" required>
                                                    <option value="" selected disabled>Pilih Tahun Ajar</option>
                                                    @foreach($school_years->sortBy('tahun_ajar') as $school_year)
                                                    <option value="{{ $school_year->tahun_ajar }}" {{ $reportCard->tahun_ajar == $school_year->tahun_ajar ? 'selected' : '' }}>
                                                        {{ $school_year->tahun_ajar }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabel Mata Pelajaran (ID 1-9) -->
                                    <br>
                                    <h6 class="m-0 font-weight-bold text-primary text-center">Mata Pelajaran</h6><br>
                                    <div class="row">
                                        @foreach ($subjects as $subject)
                                        @if ($subject->id >= 1 && $subject->id <= 9)
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mata_pelajaran[{{ $subject->id }}]">{{ $subject->nama }}</label>
                                                <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $reportCard->subjects->where('id', $subject->id)->first()->pivot->nilai ?? '') }}" placeholder="Masukkan Nilai..." required>
                                            </div>
                                    </div>
                                    @endif
                                    @endforeach
                            </div>

                            <!-- Muatan Lokal & Khas SDIT Aliya (ID 10-15) -->
                            <br>
                            <h6 class="m-0 font-weight-bold text-primary text-center">Muatan Lokal & Muatan Khas SDIT Aliya</h6><br>
                            <div class="row">
                                @foreach ($subjects as $subject)
                                @if ($subject->id >= 10 && $subject->id <= 15)
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]">{{ $subject->nama }}</label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $reportCard->subjects->where('id', $subject->id)->first()->pivot->nilai ?? '') }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <!-- Subjudul untuk Absensi -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Absensi</h6><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sakit">Sakit</label>
                                    <input type="number" name="sakit" id="sakit" class="form-control" value="{{ old('sakit', $reportCard->sakit) }}" placeholder="Jumlah Hari Sakit">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="izin">Izin</label>
                                    <input type="number" name="izin" id="izin" class="form-control" value="{{ old('izin', $reportCard->izin) }}" placeholder="Jumlah Hari Izin">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alfa">Alfa</label>
                                    <input type="number" name="alfa" id="alfa" class="form-control" value="{{ old('alfa', $reportCard->alfa) }}" placeholder="Jumlah Hari Alfa">
                                </div>
                            </div>
                        </div>


                        <!-- Subjudul untuk Ekstrakurikuler -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Ekstrakurikuler</h6><br>
                        @php
                        $ekskul = json_decode($reportCard->ekskul, true) ?? [];
                        $nilai_ekskul = json_decode($reportCard->nilai_ekskul, true) ?? [];
                        $ket_ekskul = json_decode($reportCard->ket_ekskul, true) ?? [];
                        @endphp
                        <!-- Ekstrakurikuler 1 -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ekskul">Ekstrakurikuler 1</label>
                                    <input type="text" name="ekskul[]" id="ekskul" class="form-control" value="{{ old('ekskul.0', $ekskul[0] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai_ekskul">Nilai</label>
                                    <input type="number" name="nilai_ekskul[]" id="nilai_ekskul" class="form-control" value="{{ old('nilai_ekskul.0', $nilai_ekskul[0] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ket_ekskul">Keterangan</label>
                                    <input type="text" name="ket_ekskul[]" id="ket_ekskul" class="form-control" value="{{ old('ket_ekskul.0', $ket_ekskul[0] ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Ekstrakurikuler 2 -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ekskul_2">Ekstrakurikuler 2</label>
                                    <input type="text" name="ekskul[]" id="ekskul_2" class="form-control" value="{{ old('ekskul.1', $ekskul[1] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai_ekskul_2">Nilai</label>
                                    <input type="number" name="nilai_ekskul[]" id="nilai_ekskul_2" class="form-control" value="{{ old('nilai_ekskul.1', $nilai_ekskul[1] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ket_ekskul_2">Keterangan</label>
                                    <input type="text" name="ket_ekskul[]" id="ket_ekskul_2" class="form-control" value="{{ old('ket_ekskul.1', $ket_ekskul[1] ?? '') }}">
                                </div>
                            </div>
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
    @include('admin-pages.components.footer')
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