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
                                                    <option value="Level 1 Semester 1">Level 1 Semester 1</option>
                                                    <option value="Level 1 Semester 2">Level 1 Semester 2</option>
                                                    <option value="Level 2 Semester 1">Level 2 Semester 1</option>
                                                    <option value="Level 2 Semester 2">Level 2 Semester 2</option>
                                                    <option value="Level 3 Semester 1">Level 3 Semester 1</option>
                                                    <option value="Level 3 Semester 2">Level 3 Semester 2</option>
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

                                    <!-- Tabel Mata Pelajaran (ID 1-9) -->
                                    <br>
                                    <h6 class="m-0 font-weight-bold text-primary text-center">Mata Pelajaran</h6><br>
                                    <div class="row">
                                        @foreach ($subjects as $subject)
                                        @if ($subject->id >= 1 && $subject->id <= 9)
                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                                <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
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
                                @if ($subject->id >= 10 && $subject->id <= 11)
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <!-- Muatan Lokal & Khas SDIT Aliya (ID 12-15) -->
                        <div class="row">
                            @foreach ($subjects as $subject)
                            @if ($subject->id >= 12 && $subject->id <= 15)
                                <!-- ID 12: Nilai, Target Akhir Semester, Capaian Saat Ini -->
                                @if ($subject->id == 12)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target Akhir Semester</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_12" class="form-control" value="{{ old('target.' . $subject->id) }}" placeholder="Contoh: Lulus Tajwid Jilid 9" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capaian[{{ $subject->id }}]">Capaian Saat Ini</label>
                                        <input type="text" name="capaian[{{ $subject->id }}]" id="capaian_12" class="form-control" value="{{ old('capaian.' . $subject->id) }}" placeholder="Contoh: Jilid 5 Hal 40" required>
                                    </div>
                                </div>
                                <!-- ID 13: Nilai, Target Akhir Semester, Capaian Saat Ini -->
                                @elseif ($subject->id == 13)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target Akhir Semester</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_13" class="form-control" value="{{ old('target.' . $subject->id) }}" placeholder="Contoh: Q.S Al-Infithar" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capaian[{{ $subject->id }}]">Capaian Saat Ini</label>
                                        <input type="text" name="capaian[{{ $subject->id }}]" id="capaian_13" class="form-control" value="{{ old('capaian.' . $subject->id) }}" placeholder="Contoh: Q.S Al-Muthaffifin ayat 1" required>
                                    </div>
                                </div>
                                <!-- ID 14: Nilai, Target -->
                                @elseif ($subject->id == 14)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_14" class="form-control" value="{{ old('target.' . $subject->id) }}" placeholder="Contoh: Hadis 1 s.d 5" required>
                                    </div>
                                </div>
                                <!-- ID 15: Nilai, Aplikasi/Program -->
                                @elseif ($subject->id == 15)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id) }}" placeholder="Masukkan Nilai..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="aplikasi[{{ $subject->id }}]">Aplikasi/Program</label>
                                        <input type="text" name="aplikasi[{{ $subject->id }}]" id="aplikasi_{{ $subject->id }}" class="form-control" value="{{ old('aplikasi.' . $subject->id) }}" placeholder="Contoh: Ms. Office Excel" required>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach
                        </div>

                        <!-- Subjudul untuk Absensi -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Absensi</h6><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sakit"><strong>Sakit</strong></label>
                                    <input type="number" name="sakit" id="sakit" class="form-control" value="{{ old('sakit') }}" placeholder="Jumlah Hari Sakit">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="izin"><strong>Izin</strong></label>
                                    <input type="number" name="izin" id="izin" class="form-control" value="{{ old('izin') }}" placeholder="Jumlah Hari Izin">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alfa"><strong>Alfa</strong></label>
                                    <input type="number" name="alfa" id="alfa" class="form-control" value="{{ old('alfa') }}" placeholder="Jumlah Hari Alfa">
                                </div>
                            </div>
                        </div>

                        <!-- Subjudul untuk Prestasi -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Prestasi</h6><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prestasi"><strong>Jenis Prestasi 1</strong></label>
                                    <input type="text" name="prestasi[]" id="prestasi" class="form-control" value="{{ old('prestasi.0') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ket_prestasi"><strong>Keterangan</strong></label>
                                    <input type="text" name="ket_prestasi[]" id="ket_prestasi" class="form-control" value="{{ old('ket_prestasi.0') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Subjudul untuk Prestasi 2 (Opsional) -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prestasi"><strong>Jenis Prestasi 2</strong></label>
                                    <input type="text" name="prestasi[]" id="prestasi" class="form-control" value="{{ old('prestasi.1') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ket_prestasi"><strong>Keterangan</strong></label>
                                    <input type="text" name="ket_prestasi[]" id="ket_prestasi" class="form-control" value="{{ old('ket_prestasi.1') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Subjudul untuk Ekstrakurikuler -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Ekstrakurikuler</h6><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ekskul"><strong>Ekstrakurikuler 1</strong></label>
                                    <input type="text" name="ekskul[]" id="ekskul" class="form-control" value="{{ old('ekskul.0') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai_ekskul"><strong>Nilai</strong></label>
                                    <input type="number" name="nilai_ekskul[]" id="nilai_ekskul" class="form-control" value="{{ old('nilai_ekskul.0') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ket_ekskul"><strong>Keterangan</strong></label>
                                    <input type="text" name="ket_ekskul[]" id="ket_ekskul" class="form-control" value="{{ old('ket_ekskul.0') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Baris Ekstrakurikuler 2 (Opsional) -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ekskul_2"><strong>Ekstrakurikuler 2</strong></label>
                                    <input type="text" name="ekskul[]" id="ekskul_2" class="form-control" value="{{ old('ekskul.1') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nilai_ekskul_2"><strong>Nilai</strong></label>
                                    <input type="number" name="nilai_ekskul[]" id="nilai_ekskul_2" class="form-control" value="{{ old('nilai_ekskul.1') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ket_ekskul_2"><strong>Keterangan</strong></label>
                                    <input type="text" name="ket_ekskul[]" id="ket_ekskul_2" class="form-control" value="{{ old('ket_ekskul.1') }}">
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