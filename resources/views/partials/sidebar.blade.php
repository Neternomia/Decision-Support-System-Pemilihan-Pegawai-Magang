<style>
    #accordionSidebar .nav-item .nav-link {
    color: #FFFFFF !important; /* Warna teks putih */
    ransform: translateY(0); /* Nonaktifkan gerakan default pada elemen lain */
    }


    #accordionSidebar .nav-item.active .nav-link {
    background-color: #B5651D !important; /* Warna latar belakang aktif */
    color: #FFFFFF !important;           /* Warna teks aktif */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Efek bayangan default */
    border-radius: 5px; /* Membulatkan sudut */
    transform: translateY(0); /* Posisi default */
    transition: transform 0.2s ease, box-shadow 0.2s ease; /* Animasi halus */
}

    #accordionSidebar .nav-item.active .nav-link:hover {
        transform: translateY(-3px); /* Bergerak ke atas saat hover */
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3); /* Bayangan lebih intens saat hover */
    }

    #accordionSidebar .nav-item.active .nav-link i {
        color: #FFFFFF !important; /* Warna ikon pada menu aktif */
    }
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #D07A45;">
    <a class="sidebar-brand d-flex align-items-center justify-content-center mb-4" href="#" style="margin-top: 10px">
        <div class="sidebar-brand-text mx-3">Sistem SMART Pegawai Magang</div>
    </a>

    <hr class="sidebar-divider my-0" style="border: 0;height: 4px; background-color: white; margin: 0;">
    <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

<!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ request()->is('periods*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('periods.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Periode</span>
        </a>
    </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ request()->is('kriteria*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kriteria.index') }}">
                    <i class="fas fa-fw fa-check-square"></i>
                    <span>Kriteria</span>
                </a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item {{ Route::is('parameter.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('parameter.index') }}">
                    <i class="fas fa-sliders-h"></i>
                    <span>Parameter</span>
                </a>
            </li>

        <li class="nav-item {{ request()->is('alternatif*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('alternatif.index') }}">
                <i class="fas fa-check-double"></i>
                <span>Data Alternatif</span>
            </a>
        </li>
            <li class="nav-item {{ request()->is('penilaian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penilaian.select') }}">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Penilaian</span>
                </a>
            </li>
        <li class="nav-item {{ request()->is('perhitungan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('perhitungan.index') }}">
                <i class="fas fa-calculator"></i>
                <span>Perhitungan</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('hasil-akhir*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hasil_akhir.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>Hasil Akhir</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Laporan</span>
            </a>
        </li>


    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
</ul>
