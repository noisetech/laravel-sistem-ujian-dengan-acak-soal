<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Sistem Ujian</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (Auth::user()->role === 'siswa')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jenjang_mapel') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Jenjang Mapel</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('hasil_ujian') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Hasil Ujian</span></a>
        </li>
    @elseif (Auth::user()->role === 'super admin')
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guru') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Guru</span></a>
        </li>





        <li class="nav-item">
            <a class="nav-link" href="{{ route('mapel') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Mapel</span></a>
        </li>




        <li class="nav-item">
            <a class="nav-link" href="{{ route('jenjang_mapel') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Jenjang Mapel</span></a>
        </li>




        <li class="nav-item">
            <a class="nav-link" href="{{ route('kelas') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Kelas</span></a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswa') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Siswa</span></a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('bank_soal') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Bank Soal</span></a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('user') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>User</span></a>
        </li>
    @endif





    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('ujian') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Ujian</span></a>
    </li>
 --}}


    <!-- Nav Item - Tables -->



    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
