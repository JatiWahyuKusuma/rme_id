<style>
    /* Sidebar Background Color */
    .main-sidebar {
        position: fixed !important;
        width: 260px;
        /* Increased from default 250px */
        background-color: #f5f5f5;
        /* Change background to white */
        transition: all 0.3s;
        color: black;
        /* Set default font color to black */
    }

    .nav-babayo {
        color: #000;
        font-weight: bold;
        font-size: 1.1rem;
        padding: 10px 25px;
        margin-top: 20px;
        text-transform: uppercase;
        border-bottom: 2px solid rgb(0, 0, 0);
    }

    /* Nav Item Padding */
    .nav-sidebar .nav-item>.nav-link {
        padding: 0.80rem 1.5rem;
        color: rgb(0, 0, 0);
        /* Set font color for links to black */
    }


    .nav-sidebar .nav-item>.nav-link:hover {
        background-color: #dc0b0b !important;
        /* Hover background color */
        color: rgb(255, 255, 255) !important;
        /* Change text color to red on hover */
    }

    /* Icon and Text Alignment */
    .nav-sidebar .nav-item>.nav-link p {
        margin-left: 10px;
        display: inline-block;
        vertical-align: middle;
    }

    .nav-sidebar .nav-item .nav-link.active {
        background-color: #800000 !important;
        color: #e4e1e1 !important;
        font-weight: bold;
        /* Menebalkan teks */
    }

    /* Brand Logo Adjustment */
    .brand-link {
        padding: 15px 10px;
    }

    /* User Panel Adjustment */
    .user-panel {
        padding: 15px;
    }

    /* Nav Header Styling */
    .nav-header {
        font-size: 1.1rem;
        padding: 10px 25px;
        margin-top: 20px;
        color: #800000;

        /* Set header text color to black */
        text-transform: uppercase;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        /* Change border color to black */
    }

    /* Active Menu Styling */
    .nav-sidebar .nav-item>.nav-link.active {
        background-color: rgba(255, 0, 0, 0.1);
        /* Light red for active background */
        border-left: 3px solid red;
        /* Active item border color */
    }

    /* Logout Button Styling */
    .nav-logout .nav-link {
        background-color: #800000;
        /* Remove default background */
        color: rgb(255, 255, 255) !important;
        /* Set text color to red */
        border: 3px solid rgb(8, 8, 8);
        /* Set border color to red */
        font-weight: bold;
        /* Optional: Make text bold */
        display: flex;
        /* Align icon and text side by side */
        align-items: center;
        /* Center items vertically */
        padding: 0.80rem 1.5rem;
        /* Standard padding */
        position: relative;
    }

    .nav-logout .nav-icon {
        color: rgb(255, 255, 255);
        /* Set icon color to red */
        margin-right: 8px;
        /* Space between icon and text */
    }

    .nav-logout .nav-link.active {
        background-color: #dc0b0b !important;
        /* Active background color */
        color: #0e0e0e !important;
        /* White text when active */
    }
</style>
<div class="sidebar">

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Sidebar user panel (optional) -->
            @if (Auth::user()->admin->opco_id === 1 ||
                    Auth::user()->admin->opco_id === 2 ||
                    Auth::user()->admin->opco_id === 3 ||
                    Auth::user()->admin->opco_id === 4 ||
                    Auth::user()->admin->opco_id === 5 ||
                    Auth::user()->admin->opco_id === 6 ||
                    Auth::user()->admin->opco_id === 7 ||
                    Auth::user()->admin->opco_id === 8 ||
                    Auth::user()->admin->opco_id === 9)
                <!-- Brand Logo -->
                <a href="{{ url('/dashboardcadpot') }}" class="brand-link d-flex justify-content-center">
                    <img src="{{ asset('images/logoSIG.png') }}" alt="AdminLTE Logo" class="brand-image"
                        style="width: 170px; height: auto; max-height: 100px; box-shadow: none;">
                </a>
                <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
                    <div class="image text-center"
                        style="margin-top: 5px; display: flex; align-items: center; justify-content: flex-start;">
                        <a href="#" class="d-block">
                            @if (Auth::user()->admin->opco_id === 1)
                                <img src="{{ asset('images/logoSIG.png') }}" style="width: 100px;">
                            @elseif (Auth::user()->admin->opco_id === 2)
                                <img src="{{ asset('images/sgrembang.png') }}" style="width: 100px;">
                            @elseif(Auth::user()->admin->opco_id === 3)
                                <img src="{{ asset('images/sbisolusibangunindonesia.png') }}"
                                    style="width: 150px; height: 70px; ">
                            @elseif(Auth::user()->admin->opco_id === 4)
                                <img src="{{ asset('images/semenTonasa.png') }}" style="width: 100px;">
                            @elseif(Auth::user()->admin->opco_id === 5)
                                <img src="{{ asset('images/sbisolusibangunindonesia.png') }}"
                                    style="width: 150px; height: 70px;">
                            @elseif(Auth::user()->admin->opco_id === 6)
                                <img src="{{ asset('images/sbisolusibangunindonesia.png') }}"
                                    style="width: 150px; height: 70px;">
                            @elseif(Auth::user()->admin->opco_id === 7)
                                <img src="{{ asset('images/sbisolusibangunindonesia.png') }}"
                                    style="width: 150px; height: 70px;">
                            @elseif(Auth::user()->admin->opco_id === 8)
                                <img src="{{ asset('images/SemenPadang.png') }}" style="width: 90px;">
                            @elseif(Auth::user()->admin->opco_id === 9)
                                <img src="{{ asset('images/SemenBaturaja.png') }}" style="width: 100px;">
                            @endif
                        </a>
                    </div>
                    <div class="info text-center mt-2">
                        <a href="#" class="d-block">
                            @if (Auth::user()->admin->opco_id === 1)
                                <p class="text-center" style="font-weight: bold; color:#000000;">Admin GHOPO Tuban</p>
                            @elseif (Auth::user()->admin->opco_id === 2)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin SG Rembang</p>
                            @elseif(Auth::user()->admin->opco_id === 3)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin SBI Tuban</p>
                            @elseif(Auth::user()->admin->opco_id === 4)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin Semen Tonasa</p>
                            @elseif(Auth::user()->admin->opco_id === 5)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin SBI Narogong</p>
                            @elseif(Auth::user()->admin->opco_id === 6)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin SBI Cilacap</p>
                            @elseif(Auth::user()->admin->opco_id === 7)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin SBI Lhoknga</p>
                            @elseif(Auth::user()->admin->opco_id === 8)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin Semen Padang</p>
                            @elseif(Auth::user()->admin->opco_id === 9)
                                <p class="text-center" style="font-weight: bold;color:#000000;">Admin Semen Baturaja</p>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- <li class="nav-header">Dashboard</li> --}}
                <li class="nav-item">
                    <a href="{{ url('/dashboardcad') }}"
                        class="nav-link {{ $activeMenu == 'dashboardcad' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M22.25 0H1.75C.785 0 0 .785 0 1.75v2.5C0 5.215.785 6 1.75 6h20.5C23.215 6 24 5.215 24 4.25v-2.5C24 .785 23.215 0 22.25 0zM1.75 24h7.5c.965 0 1.75-.785 1.75-1.75V9.75C11 8.785 10.215 8 9.25 8h-7.5C.785 8 0 8.785 0 9.75v12.5C0 23.215.785 24 1.75 24zM22.25 8h-7.5C13.785 8 13 8.785 13 9.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5C24 8.785 23.215 8 22.25 8zM22.25 17h-7.5c-.965 0-1.75.785-1.75 1.75v3.5c0 .965.785 1.75 1.75 1.75h7.5c.965 0 1.75-.785 1.75-1.75v-3.5c0-.965-.785-1.75-1.75-1.75z"
                                    fill="#00000" opacity="1" data-original="#c2c7d0" class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/umurcadanganadmin') }}"
                        class="nav-link {{ $activeMenu == 'umurcadanganadmin' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path fill-rule="evenodd"
                                    d="M496 263.926v24.479l-39.771 15.309a204.837 204.837 0 0 1-24.865 59.977l17.309 38.973-45.933 45.934-38.962-17.304a204.812 204.812 0 0 1-59.992 24.868l-15.305 39.763h-64.96l-15.309-39.772a204.826 204.826 0 0 1-59.977-24.865l-38.973 17.309-45.935-45.933 17.304-38.962a204.834 204.834 0 0 1-24.868-59.993L16 288.406v-24.48h100.699C120.846 337.264 181.624 395.46 256 395.46c74.375 0 135.154-58.196 139.301-131.534zm-166.522-81.478-89.066 57.892c-8.609 8.609-8.609 22.565 0 31.174s22.565 8.609 31.174 0zM263.999 16.074c37.892 1.243 73.563 11.261 105.038 28.102l-50.286 87.098c-16.62-8.384-35.145-13.539-54.752-14.649zm68.567 123.195a140.304 140.304 0 0 1 40.089 40.089l87.097-50.286a241.27 241.27 0 0 0-76.901-76.9zm48.085 53.904 87.099-50.287c16.843 31.478 26.876 67.145 28.118 105.04H395.307c-1.109-19.608-6.269-38.133-14.656-54.753zM16.132 247.926c1.242-37.893 11.277-73.56 28.117-105.039l87.098 50.286a138.75 138.75 0 0 0-14.656 54.753zm123.211-68.567a140.304 140.304 0 0 1 40.089-40.089l-50.285-87.097a241.23 241.23 0 0 0-76.901 76.9zm53.904-48.085-50.286-87.098c31.476-16.838 67.146-26.86 105.038-28.102v100.551c-19.607 1.109-38.133 6.263-54.752 14.649z"
                                    clip-rule="evenodd" fill="#00000" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Umur Cadangan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/umurizinadmin') }}"
                        class="nav-link {{ $activeMenu == 'umurizinadmin' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M389.513 87.422c0-12.012-4.688-23.32-13.184-31.816l-42.422-42.422C325.529 4.805 313.636 0 301.8 0h-2.578v90h90.292l-.001-2.578z"
                                    fill="#00000" opacity="1" data-original="#000000" class=""></path>
                                <path
                                    d="M273.937 309.537c2.871-8.716 7.881-16.831 14.414-23.408l101.562-101.153V120h-105.4c-8.291 0-14.513-6.709-14.513-15V0H45C20.186 0 0 20.186 0 45v422c0 24.814 20.186 45 45 45h299.513c24.814 0 45.4-20.186 45.4-45V355.049l-16.484 16.084c-6.679 6.621-14.501 11.44-23.32 14.385l-47.695 15.923-7.266.396c-12.012 0-23.379-5.845-30.439-15.63-7.002-9.741-8.906-22.368-5.098-33.779l14.326-42.891zM75 270h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15s6.709-15 15-15zm-15-45c0-8.291 6.709-15 15-15h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15zm0 120c0-8.291 6.709-15 15-15h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15zm224.513 75c8.291 0 15 6.709 15 15s-6.708 15-15 15h-90c-8.291 0-15-6.709-15-15s6.709-15 15-15h90zM75 180c-8.291 0-15-6.709-15-15s6.709-15 15-15h209.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75z"
                                    fill="#00000" opacity="1" data-original="#000000" class=""></path>
                                <path
                                    d="m301.111 322.808-13.05 39.151c-1.956 5.865 3.625 11.444 9.49 9.485l39.128-13.068-35.568-35.568zM417.609 199.307l-98.789 98.789 42.605 42.605c22.328-22.332 65.773-65.783 98.784-98.794l-42.6-42.6zM503.185 156.284c-5.273-5.303-13.037-8.335-21.27-8.335-8.233 0-15.996 3.032-21.299 8.35l-21.797 21.797 42.598 42.598 21.799-21.799c11.717-11.735 11.716-30.849-.031-42.611z"
                                    fill="#00000" opacity="1" data-original="#000000" class=""></path>
                                <path
                                    d="m503.215 198.896.002-.002.086-.086a3.634 3.634 0 0 1-.088.088zM503.303 198.808l.133-.133-.133.133zM503.436 198.675c.097-.097.099-.099 0 0z"
                                    fill="#00000" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Masa Berlaku Izin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/rekomendasiadmin') }}"
                        class="nav-link {{ $activeMenu == 'rekomendasiadmin' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M58.25 26.71c-4.88-3.23.35-8-2.38-12-1.87-2.74-6.54-1.81-9-3.17-2-1.9-2.59-6.63-5.78-7.55C38 2.84 34.78 6.37 32 6.65c-2.78-.27-6-3.82-9.12-2.71-3.19.92-3.75 5.64-5.78 7.55-2.43 1.37-7.1.43-9 3.17-2 2.61.32 6.77-.25 9.5-1.2 2.51-5.5 4.5-5.38 7.84-.11 3.34 4.17 5.33 5.38 7.84.57 2.73-1.77 6.89.25 9.5 1.87 2.74 6.54 1.81 9 3.17 3.63 4.8 3.67 10.67 11.6 6.14 2.6-1.63 4-1.62 6.6 0 4.6 2.9 7.8 1.74 9.8-3.27 1.63-5.74 7.66-2.13 10.77-6 2-2.61-.32-6.77.25-9.5a8.1 8.1 0 0 1 2.13-2.55c4.24-3.55 4.27-7.1 0-10.62zm-9.81 3.55-2.19 9.84a4.59 4.59 0 0 1-4.51 3.61 56.78 56.78 0 0 1-14-1.76 4.69 4.69 0 0 1-4.41 2.69H19a1.5 1.5 0 0 1-1.5-1.5v-17a1.5 1.5 0 0 1 1.5-1.5h7.6a1.5 1.5 0 0 1 1.4 1.05 22.62 22.62 0 0 0 7.83-8.47c1.86-3.54 7.33-1.55 7.1 2.2a10.74 10.74 0 0 1-1.39 5.22h2.37a4.66 4.66 0 0 1 4.53 5.62z"
                                    data-name="Layer 57" fill="#00000" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Hasil Rekomendasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/history') }}" class="nav-link {{ $activeMenu == 'history' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M58.25 26.71c-4.88-3.23.35-8-2.38-12-1.87-2.74-6.54-1.81-9-3.17-2-1.9-2.59-6.63-5.78-7.55C38 2.84 34.78 6.37 32 6.65c-2.78-.27-6-3.82-9.12-2.71-3.19.92-3.75 5.64-5.78 7.55-2.43 1.37-7.1.43-9 3.17-2 2.61.32 6.77-.25 9.5-1.2 2.51-5.5 4.5-5.38 7.84-.11 3.34 4.17 5.33 5.38 7.84.57 2.73-1.77 6.89.25 9.5 1.87 2.74 6.54 1.81 9 3.17 3.63 4.8 3.67 10.67 11.6 6.14 2.6-1.63 4-1.62 6.6 0 4.6 2.9 7.8 1.74 9.8-3.27 1.63-5.74 7.66-2.13 10.77-6 2-2.61-.32-6.77.25-9.5a8.1 8.1 0 0 1 2.13-2.55c4.24-3.55 4.27-7.1 0-10.62zm-9.81 3.55-2.19 9.84a4.59 4.59 0 0 1-4.51 3.61 56.78 56.78 0 0 1-14-1.76 4.69 4.69 0 0 1-4.41 2.69H19a1.5 1.5 0 0 1-1.5-1.5v-17a1.5 1.5 0 0 1 1.5-1.5h7.6a1.5 1.5 0 0 1 1.4 1.05 22.62 22.62 0 0 0 7.83-8.47c1.86-3.54 7.33-1.55 7.1 2.2a10.74 10.74 0 0 1-1.39 5.22h2.37a4.66 4.66 0 0 1 4.53 5.62z"
                                    data-name="Layer 57" fill="#00000" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Riwayat</p>
                    </a>
                </li>
                <li class="nav-header">
                    @if (Auth::user()->admin->opco_id === 1)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;">Data GHOPO Tuban</p>
                    @elseif (Auth::user()->admin->opco_id === 2)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;">Data SG Rembang</p>
                    @elseif (Auth::user()->admin->opco_id === 3)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data SBI Tuban</p>
                    @elseif(Auth::user()->admin->opco_id === 4)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data Semen Tonasa</p>
                    @elseif(Auth::user()->admin->opco_id === 5)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data SBI Narogong</p>
                    @elseif(Auth::user()->admin->opco_id === 6)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data SBI Cilacap</p>
                    @elseif(Auth::user()->admin->opco_id === 7)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data SBI Lhoknga</p>
                    @elseif(Auth::user()->admin->opco_id === 8)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data Semen Padang</p>
                    @elseif(Auth::user()->admin->opco_id === 9)
                        <p class="text-absolute" style="font-weight: bold; color:#000000;"> Data Semen Baturaja</p>
                    @endif
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admincadanganbb') }}"
                        class="nav-link {{ $activeMenu == 'admincadanganbb' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="27" height="27" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path fill-rule="evenodd"
                                    d="M136.121 105.976h66.7c3.664 0 6.662 2.998 6.662 6.662v47.329H129.46v-47.329c0-3.664 2.997-6.662 6.661-6.662zm347.668 42.169c8.684 0 14.492 8.795 11.345 16.71l-10.606 34.385C491.919 231.362 496 266.553 496 303.453s-4.083 72.086-11.474 104.206l10.608 34.393c3.147 7.915-2.661 16.71-11.345 16.71H268.136c-8.684 0-14.492-8.794-11.345-16.71l10.608-34.393c-7.391-32.12-11.474-67.306-11.474-104.206 0-36.901 4.08-72.091 11.471-104.213l-10.606-34.385c-3.147-7.915 2.661-16.71 11.345-16.71zM315.992 415.659h119.94a8 8 0 0 0 0-16h-119.94a8 8 0 0 0 0 16zm99.939-55.507h-79.938a8 8 0 0 0 0 16h79.938a8 8 0 0 0 0-16zM315.992 207.24h119.94a8 8 0 0 0 0-16h-119.94a8 8 0 0 0 0 16zm99.939 23.507h-79.938a8 8 0 0 0 0 16h79.938a8 8 0 0 0 0-16zM140.374 370.789c24.293 0 43.986 19.693 43.986 43.986s-19.693 43.986-43.986 43.986-43.986-19.693-43.986-43.986 19.693-43.986 43.986-43.986zm0 26.077c-9.891 0-17.909 8.018-17.909 17.909s8.018 17.909 17.909 17.909 17.909-8.018 17.909-17.909-8.018-17.909-17.909-17.909zm108.086 17.909 2.394-7.762c-7.453-33.92-10.929-68.86-10.929-103.56 0-25.67 1.902-51.471 5.908-76.894H33.655L77.34 368.19c2.191 7.103 5.452 13.603 9.576 19.35 9.925-19.438 30.139-32.751 53.458-32.751 33.124 0 59.986 26.862 59.986 59.986zM22 175.967h221.475l7.377 23.919a448.588 448.588 0 0 0-2.207 10.673H22c-3.3 0-6-2.7-6-6v-22.593c0-3.299 2.7-5.999 6-5.999zm203.482-48.864v32.864h14.435c.216-14.741 12.201-27.822 28.219-27.822h13.226c-.728-2.888-3.355-5.042-6.461-5.042zm-186.141-1.478 57.764-33.35c3.173-1.832 7.268-.735 9.1 2.439l7.718 13.368a22.524 22.524 0 0 0-.463 4.556v47.329H51.477l-14.574-25.242c-1.832-3.173-.735-7.268 2.438-9.1zm124.275-35.649h39.205c11.948 0 21.812 9.371 22.608 21.127h18.21V59.901c0-3.664-2.998-6.662-6.662-6.662h-66.7c-3.664 0-6.662 2.998-6.662 6.662v30.075z"
                                    clip-rule="evenodd" fill="#00000" opacity="1" data-original="#c2c7d0">
                                </path>
                            </g>
                        </svg>
                        <p style="margin-left: 5px;">Cadangan Bahan Baku</p>
                    </a>
                </li>
            @endif
            <li class="nav-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-link {{ $activeMenu == 'logout' ? 'active' : '' }} mt-3">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>
