        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Aplikasi Kelulusan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa fa-info-circle"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

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
                        <a class="collapse-item" href="{{ route('students.index') }}"> <i class="fa fa-user fa-1x"></i> Data Siswa</a>
                        <a class="collapse-item" href="{{ route('teachers.index') }}"> <i class="fas fa-chalkboard-teacher fa-1x"></i> Data Guru</a>
                        <a class="collapse-item" href="{{ route('subjects.index') }}"> <i class="fas fa-book-reader fa-1x"></i> Mata Pelajaran</a>
                        <a class="collapse-item" href="{{ route('school_years.index') }}"> <i class="fas fa-calendar fa-1x"></i> Tahun Ajar</a>
                        <a class="collapse-item" href="{{ route('student_classes.index') }}"> <i class="fas fa-school fa-1x"></i> Kelas</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Data Rapor -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-book-reader"></i>
                    <span>Data Rapor</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Rapor:</h6>
                        <a class="collapse-item" href="utilities-color.html">Rapor 6A</a>
                        <a class="collapse-item" href="utilities-border.html">Rapor 6B</a>
                        <a class="collapse-item" href="utilities-animation.html">Rapor 6C</a>
                        <a class="collapse-item" href="utilities-other.html">Rapor 6D</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Data Kelulusan -->
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
                        <a class="collapse-item" href="utilities-color.html">Ijazah</a>
                        <a class="collapse-item" href="utilities-border.html">PPDB</a>
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
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->