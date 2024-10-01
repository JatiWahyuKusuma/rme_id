<div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link d-flex justify-content-center">
                <img src="{{ asset('images/logoSIGputih.png') }}" alt="AdminLTE Logo"
                class="brand-image elevation-3" style="width: 170px; height: auto; max-height: 100px;">                
            </a>
            

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/userr.png') }}" class="elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Super Admin</a>
                </div>
            </div>

            <!-- Removed the horizontal line after the user panel -->

             
            <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="{{ url('/dashboardcadangan') }}" class="nav-link {{ $activeMenu == 'dashboardcadangan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Cadangan dan Potensi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Vendor</p>
                    </a>
                </li>
            </li>


            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;">
            
            <li class="nav-header">Data Cadangan dan Potensi</li>
            <li class="nav-item">
                <a href="{{ url('/cadpot') }}" class="nav-link {{ $activeMenu == 'cadpot' ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>GHOPO Tuban</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/cadpot') }}" class="nav-link {{ $activeMenu == 'cadpot' ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>SG Rembang</p>
                </a>
            </li>

            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;"> 

            <li class="nav-header">Data Vendor</li>
            <li class="nav-item">
                <a href="{{ url('/vendor') }}" class="nav-link {{ $activeMenu == 'vendor' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>GHOPO Tuban</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/vendor') }}" class="nav-link {{ $activeMenu == 'vendor' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>SG Rembang</p>
                </a>
            </li>

            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;"> 

            <li class="nav-header">Data User</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Data Level</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/opco') }}" class="nav-link {{ $activeMenu == 'opco' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Data Opco</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ $activeMenu == 'admin' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Data Admin</p>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }} mt-3"> <!-- Tambahkan kelas mt-3 -->
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Keluar</p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>
