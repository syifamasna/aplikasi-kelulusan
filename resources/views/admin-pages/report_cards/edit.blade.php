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
                                                <label for="semester" class="control-label"><strong>Semester</strong></label>
                                                <select name="semester" class="form-control" id="semester" required>
                                                    <option value="" disabled>Pilih Semester</option>
                                                    <option value="Level 1 Semester 1" {{ old('semester', $semester) == 'Level 1 Semester 1' ? 'selected' : '' }}>Level 1 Semester 1</option>
                                                    <option value="Level 1 Semester 2" {{ old('semester', $semester) == 'Level 1 Semester 2' ? 'selected' : '' }}>Level 1 Semester 2</option>
                                                    <option value="Level 2 Semester 1" {{ old('semester', $semester) == 'Level 2 Semester 1' ? 'selected' : '' }}>Level 2 Semester 1</option>
                                                    <option value="Level 2 Semester 2" {{ old('semester', $semester) == 'Level 2 Semester 2' ? 'selected' : '' }}>Level 2 Semester 2</option>
                                                    <option value="Level 3 Semester 1" {{ old('semester', $semester) == 'Level 3 Semester 1' ? 'selected' : '' }}>Level 3 Semester 1</option>
                                                    <option value="Level 3 Semester 2" {{ old('semester', $semester) == 'Level 3 Semester 2' ? 'selected' : '' }}>Level 3 Semester 2</option>
                                                    <option value="Level 4 Semester 1" {{ old('semester', $semester) == 'Level 4 Semester 1' ? 'selected' : '' }}>Level 4 Semester 1</option>
                                                    <option value="Level 4 Semester 2" {{ old('semester', $semester) == 'Level 4 Semester 2' ? 'selected' : '' }}>Level 4 Semester 2</option>
                                                    <option value="Level 5 Semester 1" {{ old('semester', $semester) == 'Level 5 Semester 1' ? 'selected' : '' }}>Level 5 Semester 1</option>
                                                    <option value="Level 5 Semester 2" {{ old('semester', $semester) == 'Level 5 Semester 2' ? 'selected' : '' }}>Level 5 Semester 2</option>
                                                    <option value="Level 6 Semester 1" {{ old('semester', $semester) == 'Level 6 Semester 1' ? 'selected' : '' }}>Level 6 Semester 1</option>
                                                    <option value="Level 6 Semester 2" {{ old('semester', $semester) == 'Level 6 Semester 2' ? 'selected' : '' }}>Level 6 Semester 2</option>
                                                </select>
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
                                                <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $reportCard->subjects->where('id', $subject->id)->first()->pivot->nilai ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100" required>
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
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $nilai[$subject->id] ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100" required>
                                    </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <!-- Muatan Lokal & Khas SDIT Aliya (ID 12-15) -->
                        <div class="row">
                            @foreach ($subjects as $subject)
                            @if ($subject->id >= 12 && $subject->id <= 15)
                                <!-- Untuk mata pelajaran dengan id 12 -->
                                @if ($subject->id == 12)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $nilai[$subject->id] ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target Akhir Semester</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_12" class="form-control" value="{{ old('target.' . $subject->id, $pivotData[$subject->id]['target'] ?? '') }}" placeholder="Contoh: Lulus Tajwid Jilid 9">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capaian[{{ $subject->id }}]">Capaian Saat Ini</label>
                                        <input type="text" name="capaian[{{ $subject->id }}]" id="capaian_12" class="form-control" value="{{ old('capaian.' . $subject->id, $pivotData[$subject->id]['capaian'] ?? '') }}" placeholder="Contoh: Jilid 5 Hal 40">
                                    </div>
                                </div>
                                @elseif ($subject->id == 13)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $nilai[$subject->id] ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target Akhir Semester</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_13" class="form-control" value="{{ old('target.' . $subject->id, $pivotData[$subject->id]['target'] ?? '') }}" placeholder="Contoh: Q.S Al-Infithar">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capaian[{{ $subject->id }}]">Capaian Saat Ini</label>
                                        <input type="text" name="capaian[{{ $subject->id }}]" id="capaian_13" class="form-control" value="{{ old('capaian.' . $subject->id, $pivotData[$subject->id]['capaian'] ?? '') }}" placeholder="Contoh: Q.S Al-Muthaffifin ayat 1">
                                    </div>
                                </div>
                                @elseif ($subject->id == 14)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $nilai[$subject->id] ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="target[{{ $subject->id }}]">Target</label>
                                        <input type="text" name="target[{{ $subject->id }}]" id="target_akhir_14" class="form-control" value="{{ old('target.' . $subject->id, $pivotData[$subject->id]['target'] ?? '') }}" placeholder="Contoh: Hadis 1 s.d 5">
                                    </div>
                                </div>
                                @elseif ($subject->id == 15)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mata_pelajaran[{{ $subject->id }}]"><strong>{{ $subject->nama }}</strong></label>
                                        <input type="number" class="form-control" name="mata_pelajaran[{{ $subject->id }}]" value="{{ old('mata_pelajaran.' . $subject->id, $nilai[$subject->id] ?? '') }}" placeholder="Masukkan Nilai..." min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="aplikasi[{{ $subject->id }}]">Aplikasi/Program</label>
                                        <input type="text" name="aplikasi[{{ $subject->id }}]" id="aplikasi_{{ $subject->id }}" class="form-control" value="{{ old('aplikasi.' . $subject->id, $pivotData[$subject->id]['aplikasi'] ?? '') }}" placeholder="Contoh: Ms. Office Excel">
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

                        <!-- Subjudul untuk Prestasi -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Prestasi</h6><br>

                        @php
                        $prestasi = json_decode($reportCard->prestasi, true) ?? [];
                        $ket_prestasi = json_decode($reportCard->ket_prestasi, true) ?? [];
                        @endphp

                        <!-- Tombol Tambah Prestasi -->
                        <div class="text-right mb-3">
                            <button type="button" id="add-prestasi" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Prestasi
                            </button>
                        </div>

                        <!-- Container untuk Prestasi -->
                        <div id="prestasi-container">
                            @foreach ($prestasi as $index => $jenis)
                            <div class="row prestasi-item align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="prestasi_{{ $index }}"><strong>Jenis Prestasi {{ $index + 1 }}</strong></label>
                                        <input type="text" name="prestasi[]" id="prestasi_{{ $index }}" class="form-control" value="{{ old("prestasi.$index", $jenis) }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="ket_prestasi_{{ $index }}"><strong>Keterangan</strong></label>
                                        <input type="text" name="ket_prestasi[]" id="ket_prestasi_{{ $index }}" class="form-control" value="{{ old("ket_prestasi.$index", $ket_prestasi[$index] ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-prestasi">
                                        <i class="fas fa-trash-alt"></i> Hapus Prestasi
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Template untuk Prestasi Baru (Disembunyikan) -->
                        <div id="prestasi-template" class="d-none">
                            <div class="row prestasi-item align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><strong>Jenis Prestasi {index}</strong></label>
                                        <input type="text" name="prestasi[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><strong>Keterangan</strong></label>
                                        <input type="text" name="ket_prestasi[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-prestasi">
                                        <i class="fas fa-trash-alt"></i> Hapus Prestasi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Guru -->
                        <br>
                        <h6 class="m-0 font-weight-bold text-primary text-center">Catatan Guru</h6><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="catatan" class="control-label"><strong>Catatan Guru</strong></label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="5" placeholder="Tulis catatan atau komentar guru di sini...">{{ old('catatan', $reportCard->catatan) }}</textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('prestasi-container');
            const template = document.getElementById('prestasi-template').innerHTML;
            const addButton = document.getElementById('add-prestasi');

            // Fungsi untuk memperbarui label indeks
            function updateLabels() {
                const items = container.querySelectorAll('.prestasi-item');
                items.forEach((item, index) => {
                    const label = item.querySelector('label[for^="prestasi_"]');
                    if (label) label.textContent = `Jenis Prestasi ${index + 1}`;
                });
            }

            // Fungsi untuk menambah prestasi baru
            addButton.addEventListener('click', function() {
                const newElement = document.createElement('div');
                const newIndex = container.querySelectorAll('.prestasi-item').length + 1;
                newElement.innerHTML = template.replace('{index}', newIndex);
                container.appendChild(newElement);

                // Tambahkan event listener pada tombol hapus di elemen baru
                newElement.querySelector('.remove-prestasi').addEventListener('click', function() {
                    newElement.remove();
                    updateLabels(); // Perbarui label setelah elemen dihapus
                });

                updateLabels(); // Perbarui label setelah elemen ditambahkan
            });

            // Event listener tombol hapus pada elemen default
            container.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-prestasi') || event.target.closest('.remove-prestasi')) {
                    event.target.closest('.prestasi-item').remove();
                    updateLabels(); // Perbarui label setelah elemen dihapus
                }
            });
        });
    </script>

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