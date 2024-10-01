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
                    <img src="{{ asset('images/admin.png') }}" class="elevation-2" alt="User Image"> <!-- Removed img-circle -->
                </div> 
                <div class="info"> 
                    <a href="#" class="d-block">Admin SG Rembang</a> 
                </div> 
            </div> 

            <!-- Removed the horizontal line after the user panel --> 

            <li class="nav-item"> 
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}"> 
                    <i class="nav-icon fas fa-tachometer-alt"></i> 
                    <p>Dashboard</p> 
                </a> 
            </li> 

            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 10px 0;"> <!-- Horizontal line after Dashboard --> 

            <li class="nav-header">SG Rembang</li> 
            <li class="nav-item"> 
                <a href="{{ url('/cadangansg') }}" class="nav-link {{ $activeMenu == 'cadangansg' ? 'active' : '' }}"> 
                    <i class="nav-icon far fa-address-card"></i> 
                    <p>Cadangan dan Potensi</p> 
                </a> 
            </li> 

            <li class="nav-item"> 
                <a href="{{ url('/vendorsg') }}" class="nav-link {{ $activeMenu == 'vendorsg' ? 'active' : '' }}"> 
                    <i class="nav-icon far fa-address-card"></i> 
                    <p>Vendor</p> 
                </a> 
            </li> 

            <hr style="border: none; border-top: 1px solid rgb(100, 100, 100); margin: 20px 0;"> <!-- Horizontal line after Data Cadangan dan Potensi -->  
        </ul> 
    </nav> 
</div> 
