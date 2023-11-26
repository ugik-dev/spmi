<ul class="navbar-nav bg-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img class="img-logo" src="{{ mix('images/logo-sidebar.png') }}" alt="Logo">
        </div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            Dasbor
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading mb-2">
        Menu Manajemen
    </div>

    <!-- Nav Items -->
    @can('see criteria')
    <li class="nav-item {{ Route::is('criteria.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('criteria.index') }}">
            <i class="fas fa-book mr-2"></i>Kriteria
        </a>
    </li>
    @endcan

    @can('see prodis')
    <<<<<<< HEAD <li class="nav-item {{ Route::is('programs.index') ? 'active' : '' }}">
        <a class="nav-link {{ Route::is('programs.index') ? 'active' : '' }}" href="{{ route('programs.index') }}"><i class="mr-2 fa-solid fa-book"></i>Program Studi</a>
        </li>
        =======
        <li class="nav-item {{ Route::is('programs.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('programs.index') }}">
                <i class="fas fa-book mr-2"></i>Program Studi
            </a>
        </li>
        >>>>>>> 604d2c8ca13c698f47a644b3e555862c36030ca2
        @endcan

        @can('see degrees')
        <<<<<<< HEAD <li class="nav-item {{ Route::is('degrees.index') ? 'active' : '' }}">
            <a class="nav-link {{ Route::is('degrees.index') ? 'active' : '' }}" href="{{ route('degrees.index') }}">
                <i class="mr-2 fa-solid fa-graduation-cap"></i>Jenjang Pendidikan</a>
            </li>
            =======
            <li class="nav-item {{ Route::is('degrees.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('degrees.index') }}">
                    <i class="fas fa-graduation-cap mr-2"></i>Jenjang Pendidikan
                </a>
            </li>
            >>>>>>> 604d2c8ca13c698f47a644b3e555862c36030ca2
            @endcan

            @can('see faculties')
            <<<<<<< HEAD <li class="nav-item {{ Route::is('faculties.index') ? 'active' : '' }}">
                <a class="nav-link {{ Route::is('faculties.index') ? 'active' : '' }}" href="{{ route('faculties.index') }}"><i class="mr-2 fa-solid fa-building"></i>Fakultas</a>
                </li>
                =======
                <li class="nav-item {{ Route::is('faculties.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('faculties.index') }}">
                        <i class="fas fa-building mr-2"></i>Fakultas
                    </a>
                </li>
                >>>>>>> 604d2c8ca13c698f47a644b3e555862c36030ca2
                @endcan

                @can('see users')
                <<<<<<< HEAD <li class="nav-item {{ Route::is('users.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fa-solid fa-user"></i>
                        <span>Pengguna</span>
                        =======
                        <li class="nav-item {{ Route::is('users.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-user mr-2"></i>Pengguna
                            </a>
                        </li>
                        @endcan

                        {{-- <li class="nav-item {{ Route::is('degrees.index') || Route::is('faculties.index') ? 'active' : '' }}">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturan" aria-expanded="true" aria-controls="pengaturan">
                            <i class="fas fa-fw fa-cog"></i>
                            <span>Pengaturan</span>
                            >>>>>>> 604d2c8ca13c698f47a644b3e555862c36030ca2
                        </a>
                        </li>
                        @endcan
                        @can('see kriteria')
                        <li class="nav-item {{ Route::is('kriteria.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kriteria.index') }}">
                                <i class="fa-solid fa-user"></i>
                                <span>Kriteria</span>
                            </a>
                        </li>
                        @endcan
                        @can('see indikator')
                        <li class="nav-item {{ Route::is('indikator.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('indikator.index') }}">
                                <i class="fa-solid fa-user"></i>
                                <span>Indikator</span>
                            </a>
                        </li>
                        @endcan
                        @can('see element')
                        <li class="nav-item {{ Route::is('element.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('element.index') }}">
                                <i class="fa-solid fa-user"></i>
                                <span>Element</span>
                            </a>
                        </li>
                        @endcan
                        {{-- <li class="nav-item {{ Route::is('degrees.index') || Route::is('faculties.index') ? 'active' : '' }}">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturan" aria-expanded="true" aria-controls="pengaturan">
                            <i class="fas fa-fw fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                        <div id="pengaturan" class="collapse" aria-labelledby="heading2" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item {{ Route::is('degrees.index') ? 'active' : '' }}" href="{{ route('degrees.index') }}">degrees Pendidikan</a>
                                <a class="collapse-item {{ Route::is('faculties.index') ? 'active' : '' }}" href="{{ route('faculties.index') }}">Fakultas</a>
                            </div>
                        </div>
                        </li> --}}


                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Sidebar Toggler -->
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>

</ul>