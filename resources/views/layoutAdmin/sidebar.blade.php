<div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Sidebar user panel (optional) -->
            @if (Auth::user()->admin->opco_id === 1 || Auth::user()->admin->opco_id === 2)
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="brand-link d-flex justify-content-center">
                    <img src="{{ asset('images/logoSIGputih.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
                        style="width: 170px; height: auto; max-height: 100px;">
                </a>
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/admin.png') }}" class="elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            @if (Auth::user()->admin->opco_id === 1)
                                Admin GHOPO Tuban
                            @elseif (Auth::user()->admin->opco_id === 2)
                                Admin SG Rembang
                            @endif
                        </a>
                    </div>
                </div>

                <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="{{ url('/dashboardcadpot') }}"
                        class="nav-link {{ $activeMenu == 'dashboardcadpot' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Cadangan dan Potensi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/dashboardvendorbb') }}"
                        class="nav-link {{ $activeMenu == 'dashboardvendorbb' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Vendor</p>
                    </a>
                </li>

                <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;">

                <li class="nav-header">
                    @if (Auth::user()->admin->opco_id === 1)
                        Data GHOPO Tuban
                    @elseif (Auth::user()->admin->opco_id === 2)
                        Data SG Rembang
                    @endif
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admincadpot') }}"
                        class="nav-link {{ $activeMenu == 'admincadpot' ? 'active' : '' }}">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>Cadangan dan Potensi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/adminvendorbb') }}"
                        class="nav-link {{ $activeMenu == 'adminvendorbb' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Vendor</p>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }} mt-3">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Keluar</p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>
