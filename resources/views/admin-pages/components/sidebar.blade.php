        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Aplikasi Kelulusan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa fa-info-circle"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <style>
                .collapse-item {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    /* Jarak antara ikon dan teks */
                    white-space: normal;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }

                .collapse-item i {
                    min-width: 25px;
                    /* Pastikan semua ikon memiliki lebar yang sama */
                    text-align: center;
                    flex-shrink: 0;
                    /* Mencegah ikon mengecil jika teks panjang */
                }
            </style>

            <!-- Nav Item - Data Master -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Master:</h6>
                        <a class="collapse-item" href="{{ route('admin.students.index') }}">
                            <i class="fa fa-user fa-1x"></i> Data Siswa
                        </a>
                        <a class="collapse-item" href="{{ route('admin.student_classes.index') }}">
                            <i class="fas fa-chalkboard fa-1x"></i> Data Kelas
                        </a>
                        <a class="collapse-item" href="{{ route('admin.subjects.index') }}">
                            <i class="fas fa-book-reader fa-1x"></i> Data Mata Pelajaran
                        </a>
                        <a class="collapse-item" href="{{ route('admin.school_years.index') }}">
                            <i class="fas fa-calendar fa-1x"></i> Data Tahun Ajar
                        </a>
                        <a class="collapse-item" href="{{ route('admin.teachers.index') }}">
                            <i class="fas fa-chalkboard-teacher fa-1x"></i> Data Guru
                        </a>
                        <a class="collapse-item" href="{{ route('admin.school_profiles.index') }}">
                            <i class="fas fa-school fa-1x"></i> Data Sekolah
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Data Rapor -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.report_cards.index') }}">
                    <i class="fas fa-book-reader"></i>
                    <span>Data Rapor</span>
                </a>
            </li>

            <!-- Nav Item - Data Kelulusan (TIDAK DIUBAH) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-user-graduate"></i>
                    <span>Data Kelulusan</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Kelulusan:</h6>
                        <a class="collapse-item" href="{{ route('admin.graduation_grades.index') }}"
                            style="display: flex; align-items: flex-start; gap: 8px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                            <i class="fas fa-clipboard-check fa-1x" style="flex-shrink: 0; margin-top: 4px;"></i>
                            Nilai Hasil Ujian Sekolah
                        </a>

                        <a class="collapse-item" href="{{ route('admin.ppdb_grades.index') }}"
                            style="display: flex; align-items: flex-start; gap: 8px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                            <i class="fas fa-file-invoice fa-1x" style="flex-shrink: 0; margin-top: 4px;"></i>
                            Surat Keterangan Nilai Rapor
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Lainnya
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span></a>
            </li>

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Keluar" jika anda ingin mengakhiri sesi.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();">
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulir Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Add CSS Styles here -->
        <style>
            /* Sidebar Background Gradient (Biru Primary ke Hijau) */
            #accordionSidebar {
                background: linear-gradient(to bottom, #4e73df, #34bfa3);
                /* Gradient dari biru primary ke hijau */
                color: #fff;
            }
        </style>