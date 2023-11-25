<ul class="navbar-nav bg-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-logo">
            <img class="img-logo" src="{{ mix('images/logo-sidebar.png') }}">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dasbor</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Menu Manajemen
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    @can('see prodis')
        <li class="nav-item {{ Route::is('programs.index') ? 'active' : '' }}">
            <a class="nav-link {{ Route::is('programs.index') ? 'active' : '' }}" href="{{ route('programs.index') }}"><i
                    class="mr-2 fa-solid fa-book"></i>Program Studi</a>
        </li>
    @endcan
    @can('see degrees')
        <li class="nav-item {{ Route::is('degrees.index') ? 'active' : '' }}">
            <a class="nav-link {{ Route::is('degrees.index') ? 'active' : '' }}" href="{{ route('degrees.index') }}">
                <i class="mr-2 fa-solid fa-graduation-cap"></i>Jenjang
                Pendidikan</a>
        </li>
    @endcan
    @can('see faculties')
        <li class="nav-item {{ Route::is('faculties.index') ? 'active' : '' }}">
            <a class="nav-link {{ Route::is('faculties.index') ? 'active' : '' }}"
                href="{{ route('faculties.index') }}"><i class="mr-2 fa-solid fa-building"></i>Fakultas</a>
        </li>
    @endcan
    @can('see users')
        <li class="nav-item {{ Route::is('users.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fa-solid fa-user"></i>
                <span>Pengguna</span>
            </a>
        </li>
    @endcan

    {{-- <li class="nav-item {{ Route::is('degrees.index') || Route::is('faculties.index') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturan"
            aria-expanded="true" aria-controls="pengaturan">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
        </a>
        <div id="pengaturan" class="collapse" aria-labelledby="heading2" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Route::is('degrees.index') ? 'active' : '' }}"
                    href="{{ route('degrees.index') }}">Jenjang Pendidikan</a>
                <a class="collapse-item {{ Route::is('faculties.index') ? 'active' : '' }}"
                    href="{{ route('faculties.index') }}">Fakultas</a>
            </div>
        </div>
    </li> --}}


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
