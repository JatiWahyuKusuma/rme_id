<div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Sidebar user panel (optional) -->
            @if (Auth::user()->admin->opco_id === 1 || Auth::user()->admin->opco_id === 2 || Auth::user()->admin->opco_id === 3)
                <!-- Brand Logo -->
                <a href="{{ url('/dashboardcadpot') }}" class="brand-link d-flex justify-content-center">
                    <img src="{{ asset('images/SIGputihMerah.png') }}" alt="AdminLTE Logo" class="brand-image"
                        style="width: 170px; height: auto; max-height: 100px; box-shadow: none;">
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
                            @elseif(Auth::user()->admin->opco_id === 3)
                                Admin SBI Tuban
                            @endif
                        </a>
                    </div>
                </div>

                <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="{{ url('/dashboardcadpot') }}"
                        class="nav-link {{ $activeMenu == 'dashboardcadpot' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
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
                    <a href="{{ url('/dashboardvendorbb') }}"
                        class="nav-link {{ $activeMenu == 'dashboardvendorbb' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M22.25 0H1.75C.785 0 0 .785 0 1.75v2.5C0 5.215.785 6 1.75 6h20.5C23.215 6 24 5.215 24 4.25v-2.5C24 .785 23.215 0 22.25 0zM1.75 24h7.5c.965 0 1.75-.785 1.75-1.75V9.75C11 8.785 10.215 8 9.25 8h-7.5C.785 8 0 8.785 0 9.75v12.5C0 23.215.785 24 1.75 24zM22.25 8h-7.5C13.785 8 13 8.785 13 9.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5C24 8.785 23.215 8 22.25 8zM22.25 17h-7.5c-.965 0-1.75.785-1.75 1.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5c0-.965-.785-1.75-1.75-1.75z"
                                    fill="#c2c7d0" opacity="1" data-original="#c2c7d0" class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Vendor</p>
                    </a>
                </li>

                <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;">

                <li class="nav-header">
                    @if (Auth::user()->admin->opco_id === 1)
                        Data GHOPO Tuban
                    @elseif (Auth::user()->admin->opco_id === 2)
                        Data SG Rembang
                    @elseif (Auth::user()->admin->opco_id === 3)
                        Data SBI Tuban
                    @endif
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admincadpot') }}"
                        class="nav-link {{ $activeMenu == 'admincadpot' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="27" height="27" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
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
                    <a href="{{ url('/adminvendorbb') }}"
                        class="nav-link {{ $activeMenu == 'adminvendorbb' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" x="0" y="0"
                            viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
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
