<div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Brand Logo -->
            <a href="{{ url('/dashboardcadangan') }}" class="brand-link d-flex justify-content-center">
                <img src="{{ asset('images/SIGputihMerah.png') }}" alt="AdminLTE Logo" class="brand-image"
                    style="width: 170px; height: auto; max-height: 100px; box-shadow: none;">
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
                <a href="{{ url('/dashboardcadangan') }}"
                    class="nav-link {{ $activeMenu == 'dashboardcadangan' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="22" height="22" x="0" y="0" viewBox="0 0 24 24"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M22.25 0H1.75C.785 0 0 .785 0 1.75v2.5C0 5.215.785 6 1.75 6h20.5C23.215 6 24 5.215 24 4.25v-2.5C24 .785 23.215 0 22.25 0zM1.75 24h7.5c.965 0 1.75-.785 1.75-1.75V9.75C11 8.785 10.215 8 9.25 8h-7.5C.785 8 0 8.785 0 9.75v12.5C0 23.215.785 24 1.75 24zM22.25 8h-7.5C13.785 8 13 8.785 13 9.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5C24 8.785 23.215 8 22.25 8zM22.25 17h-7.5c-.965 0-1.75.785-1.75 1.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5c0-.965-.785-1.75-1.75-1.75z"
                                fill="#c2c7d0" opacity="1" data-original="#c2c7d0" class=""></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Cadangan dan Potensi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dashboardvendor') }}"
                    class="nav-link {{ $activeMenu == 'dashboardvendor' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="22" height="22" x="0" y="0" viewBox="0 0 24 24"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M22.25 0H1.75C.785 0 0 .785 0 1.75v2.5C0 5.215.785 6 1.75 6h20.5C23.215 6 24 5.215 24 4.25v-2.5C24 .785 23.215 0 22.25 0zM1.75 24h7.5c.965 0 1.75-.785 1.75-1.75V9.75C11 8.785 10.215 8 9.25 8h-7.5C.785 8 0 8.785 0 9.75v12.5C0 23.215.785 24 1.75 24zM22.25 8h-7.5C13.785 8 13 8.785 13 9.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5C24 8.785 23.215 8 22.25 8zM22.25 17h-7.5c-.965 0-1.75.785-1.75 1.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5c0-.965-.785-1.75-1.75-1.75z"
                                fill="#c2c7d0" opacity="1" data-original="#c2c7d0" class=""></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Vendor</p>
                </a>
            </li>
            {{-- <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;"> --}}
            {{-- <li class="nav-header">Riwayat</li>
            <li class="nav-item">
                <a href="{{ url('/cadangan/history') }}"
                    class="nav-link {{ $activeMenu == 'riwayatcadpot' ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    {{-- <p>Cadangan dan Potensi</p>
                    {{-- riwayatcadpot --}}
                {{-- </a>
            </li> --}} 
            {{-- <li class="nav-item">
                <a href="{{ url('/riwayatvendor') }}"
                    class="nav-link {{ $activeMenu == 'riwayatvendor' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Vendor</p>
                </a>
            {{-- </li> --}} 
            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;">
            <li class="nav-header">Data All Opco</li>
            <li class="nav-item">
                <a href="{{ url('/cadpot') }}" class="nav-link {{ $activeMenu == 'cadpot' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="27" height="27" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path fill-rule="evenodd"
                                d="M136.121 105.976h66.7c3.664 0 6.662 2.998 6.662 6.662v47.329H129.46v-47.329c0-3.664 2.997-6.662 6.661-6.662zm347.668 42.169c8.684 0 14.492 8.795 11.345 16.71l-10.606 34.385C491.919 231.362 496 266.553 496 303.453s-4.083 72.086-11.474 104.206l10.608 34.393c3.147 7.915-2.661 16.71-11.345 16.71H268.136c-8.684 0-14.492-8.794-11.345-16.71l10.608-34.393c-7.391-32.12-11.474-67.306-11.474-104.206 0-36.901 4.08-72.091 11.471-104.213l-10.606-34.385c-3.147-7.915 2.661-16.71 11.345-16.71zM315.992 415.659h119.94a8 8 0 0 0 0-16h-119.94a8 8 0 0 0 0 16zm99.939-55.507h-79.938a8 8 0 0 0 0 16h79.938a8 8 0 0 0 0-16zM315.992 207.24h119.94a8 8 0 0 0 0-16h-119.94a8 8 0 0 0 0 16zm99.939 23.507h-79.938a8 8 0 0 0 0 16h79.938a8 8 0 0 0 0-16zM140.374 370.789c24.293 0 43.986 19.693 43.986 43.986s-19.693 43.986-43.986 43.986-43.986-19.693-43.986-43.986 19.693-43.986 43.986-43.986zm0 26.077c-9.891 0-17.909 8.018-17.909 17.909s8.018 17.909 17.909 17.909 17.909-8.018 17.909-17.909-8.018-17.909-17.909-17.909zm108.086 17.909 2.394-7.762c-7.453-33.92-10.929-68.86-10.929-103.56 0-25.67 1.902-51.471 5.908-76.894H33.655L77.34 368.19c2.191 7.103 5.452 13.603 9.576 19.35 9.925-19.438 30.139-32.751 53.458-32.751 33.124 0 59.986 26.862 59.986 59.986zM22 175.967h221.475l7.377 23.919a448.588 448.588 0 0 0-2.207 10.673H22c-3.3 0-6-2.7-6-6v-22.593c0-3.299 2.7-5.999 6-5.999zm203.482-48.864v32.864h14.435c.216-14.741 12.201-27.822 28.219-27.822h13.226c-.728-2.888-3.355-5.042-6.461-5.042zm-186.141-1.478 57.764-33.35c3.173-1.832 7.268-.735 9.1 2.439l7.718 13.368a22.524 22.524 0 0 0-.463 4.556v47.329H51.477l-14.574-25.242c-1.832-3.173-.735-7.268 2.438-9.1zm124.275-35.649h39.205c11.948 0 21.812 9.371 22.608 21.127h18.21V59.901c0-3.664-2.998-6.662-6.662-6.662h-66.7c-3.664 0-6.662 2.998-6.662 6.662v30.075z"
                                clip-rule="evenodd" fill="#c2c7d0" opacity="1" data-original="#c2c7d0"></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Cadangan dan Potensi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/vendorbb') }}" class="nav-link {{ $activeMenu == 'vendorbb' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="25" height="25" x="0" y="0" viewBox="0 0 64 64"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <g fill="#000">
                                <path
                                    d="M7 2a2 2 0 0 0-1.93 1.474l-3 11A2 2 0 0 0 2 15a8.977 8.977 0 0 0 3 6.708V52c0 5.523 4.477 10 10 10h17a2 2 0 1 0 0-4H15a6 6 0 0 1-6-6V23.777A9.033 9.033 0 0 0 11 24a8.983 8.983 0 0 0 7-3.343C19.65 22.697 22.173 24 25 24s5.35-1.304 7-3.343C33.65 22.697 36.173 24 39 24s5.35-1.304 7-3.343A8.983 8.983 0 0 0 53 24c.687 0 1.357-.077 2-.223V33.5a2 2 0 1 0 4 0V21.708A8.978 8.978 0 0 0 62 15c0-.178-.024-.355-.07-.526l-3-11A2 2 0 0 0 57 2z"
                                    fill="#c2c7d0" opacity="1" data-original="#c2c7d0" class=""></path>
                                <path
                                    d="M49 35a8 8 0 0 0-5.894 13.41A13 13 0 0 0 36 60a2 2 0 0 0 2 2h22a2 2 0 0 0 2-2 13 13 0 0 0-7.106-11.59A8 8 0 0 0 49 35z"
                                    fill="#c2c7d0" opacity="1" data-original="#c2c7d0" class=""></path>
                            </g>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Vendor</p>
                </a>
            </li>
            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;">
            <li class="nav-header">Data User</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="25" height="25" x="0" y="0" viewBox="0 0 32 32"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M4 29h2.5c1.65 0 3-1.35 3-3v-8.9c0-1.66-1.35-3-3-3H4c-1.65 0-3 1.34-3 3V26c0 1.65 1.35 3 3 3zM17.25 8.55h-2.5c-1.65 0-3 1.35-3 3V26c0 1.65 1.35 3 3 3h2.5c1.65 0 3-1.35 3-3V11.55c0-1.65-1.35-3-3-3zM28 3h-2.5c-1.65 0-3 1.35-3 3v20c0 1.65 1.35 3 3 3H28c1.65 0 3-1.35 3-3V6c0-1.65-1.35-3-3-3z"
                                fill="#c2c7d0" opacity="1" data-original="#c2c7d0"></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Data Level</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/opco') }}" class="nav-link {{ $activeMenu == 'opco' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="25" height="25" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M446.37 122c-36.25 0-65.64 29.39-65.64 65.63 0 53.7 65.64 113.37 65.64 113.37S512 241.33 512 187.63c0-36.24-29.39-65.63-65.63-65.63zm15 76h-30v-30h30zM65.64 122C29.39 122 0 151.39 0 187.63 0 241.33 65.64 301 65.64 301s65.63-59.67 65.63-113.37c0-36.24-29.39-65.63-65.63-65.63zm15 76h-30v-30h30zM22.47 470h128.44c.65-31.19 3.35-61.37 7.9-89.38H46.44C32.63 408.27 24.45 438.54 22.47 470zM90.54 319.54c-9.7 9.7-18.44 20.09-26.18 31.08H164.6c7.289-32.513 19.065-67.83 36.02-93.06-41.33 9.98-79.25 31.15-110.08 61.98zM316.61 350.62c-8.157-37.577-33.259-100.367-60.611-99.619-27.366-.728-52.45 62.043-60.609 99.619zM189.21 380.62c-4.78 27.72-7.61 57.95-8.29 89.38h150.16c-.68-31.43-3.51-61.66-8.29-89.38zM421.46 319.54c-30.83-30.83-68.75-52-110.08-61.98 16.965 25.255 28.722 60.522 36.02 93.06h100.24a236.664 236.664 0 0 0-26.18-31.08zM465.56 380.62H353.19c4.55 28.01 7.25 58.19 7.9 89.38h128.44c-1.98-31.46-10.16-61.73-23.97-89.38zM256 42c-36.25 0-65.63 29.39-65.63 65.63C190.37 161.33 256 221 256 221s65.63-59.67 65.63-113.37C321.63 71.39 292.25 42 256 42zm15 76h-30V88h30z"
                                fill="#c2c7d0" opacity="1" data-original="#c2c7d0"></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Data Opco</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ $activeMenu == 'admin' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="25" height="25" x="0" y="0" viewBox="0 0 511.999 511.999"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M438.09 273.32h-39.596c4.036 11.05 6.241 22.975 6.241 35.404v149.65c0 5.182-.902 10.156-2.543 14.782h65.461c24.453 0 44.346-19.894 44.346-44.346v-81.581c.001-40.753-33.155-73.909-73.909-73.909zM107.265 308.725c0-12.43 2.205-24.354 6.241-35.404H73.91c-40.754 0-73.91 33.156-73.91 73.91v81.581c0 24.452 19.893 44.346 44.346 44.346h65.462a44.144 44.144 0 0 1-2.543-14.783v-149.65zM301.261 234.815h-90.522c-40.754 0-73.91 33.156-73.91 73.91v149.65c0 8.163 6.618 14.782 14.782 14.782h208.778c8.164 0 14.782-6.618 14.782-14.782v-149.65c0-40.754-33.156-73.91-73.91-73.91zM256 38.84c-49.012 0-88.886 39.874-88.886 88.887 0 33.245 18.349 62.28 45.447 77.524 12.853 7.23 27.671 11.362 43.439 11.362s30.586-4.132 43.439-11.362c27.099-15.244 45.447-44.28 45.447-77.524 0-49.012-39.874-88.887-88.886-88.887zM99.918 121.689c-36.655 0-66.475 29.82-66.475 66.475 0 36.655 29.82 66.475 66.475 66.475a66.095 66.095 0 0 0 26.195-5.388c13.906-5.987 25.372-16.585 32.467-29.86a66.05 66.05 0 0 0 7.813-31.227c0-36.654-29.82-66.475-66.475-66.475zM412.082 121.689c-36.655 0-66.475 29.82-66.475 66.475a66.045 66.045 0 0 0 7.813 31.227c7.095 13.276 18.561 23.874 32.467 29.86a66.095 66.095 0 0 0 26.195 5.388c36.655 0 66.475-29.82 66.475-66.475 0-36.655-29.82-66.475-66.475-66.475z"
                                fill="#c2c7d0" opacity="1" data-original="#c2c7d0"></path>
                        </g>
                    </svg>
                    <p style="margin-left: 5px;">Data Admin</p>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }} mt-3">
                        <!-- Tambahkan kelas mt-3 -->
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>
