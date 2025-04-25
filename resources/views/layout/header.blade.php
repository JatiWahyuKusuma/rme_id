<style>
    /* Navbar Background Color */
    .main-header {
        background-color: #880000 !important;
        /* Set header background to red */
        position: relative;
         bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        /* Tinggi tetap */
        margin-left: 250px;
        /* Sesuaikan dengan lebar sidebar */
        z-index: 1000;
    }

    /* Dropdown Menu Settings */
    .dropdown-menu {
        width: 350px;
        /* Set the dropdown width */
        max-height: 400px;
        /* Limit dropdown height */
        overflow-y: auto;
        /* Add scroll if content exceeds limit */
    }

    /* Header Text Styling */
    .nav-header {
        color: #fff !important;
        /* Ensure text in header is white */
        border-bottom: 1px solid #fff !important;
        /* White border on bottom */
        padding-bottom: 8px;
        margin: 15px 15px 10px 15px;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Dropdown Item Settings */
    .dropdown-item {
        white-space: normal !important;
        /* Prevent text clipping */
        word-wrap: break-word;
        /* Allow text to wrap */
        padding: 10px;
        /* Add padding for visual consistency */
    }

    /* Navbar Item Styles */
    .navbar-nav .nav-item .nav-link {
        position: relative;
    }
    /* Notification Icon Styles */
    .navbar-nav .nav-item .nav-link i.fa-bell,
    .navbar-nav .nav-item .nav-link i.fa-bars,
    .navbar-nav .nav-item .nav-link i.fa-expand-arrows-alt {
        color: white; /* Change icon color to white */
    }

    /* Notification Icon Styles */
    .navbar-nav .nav-item .nav-link i.fa-bell {
        font-size: 27px;
        /* Increase notification icon size */
        position: relative;
    }

    .navbar-nav .nav-item .nav-link i.fa-expand-arrows-alt {
        font-size: 25px;
        /* Adjust size */
        margin-left: 10px;
        /* Space from notification icon */
    }

    /* Notification Badge Styles */
    .navbar-nav .navbar-badge {
        position: absolute;
        top: -5px;
        /* Move up */
        right: -3px;
        /* Move right */
        font-size: 14px;
        /* Increase badge number font size */
        font-weight: bold;
        /* Make number bolder */
        padding: 5px 8px;
        /* Adjust size */
        border-radius: 50%;
        /* Keep circular shape */
        background-color: rgb(250, 250, 250);
        /* Ensure background color is visible */
        color: rgb(3, 3, 3);
        /* Badge number color */
    }
</style>

{{-- @include('layout.header') --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notification-icon">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-list">
                <span class="dropdown-item dropdown-header">No Notifications</span>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() {
        $.ajax({
            url: "{{ route('notifications') }}",
            type: "GET",
            success: function(response) {
                let notificationList = $("#notification-list");
                let notificationCount = $("#notification-count");

                notificationList.empty(); // Hapus notifikasi lama
                let totalNotifications = response.cadangan.length + response.izin.length;

                if (totalNotifications > 0) {
                    notificationCount.text(totalNotifications);
                    notificationList.append(
                        `<span class="dropdown-item dropdown-header">${totalNotifications} Notifikasi</span>`
                    );

                    // **Notifikasi untuk Umur Cadangan**
                    if (response.cadangan.length > 0) {
                        notificationList.append(
                            '<span class="dropdown-item text-bold text-danger">⚠️ Umur Cadangan < 5 Tahun</span>'
                        );
                        response.cadangan.forEach(notification => {
                            notificationList.append(`
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <div style="display: flex; flex-direction: column;">
                                        <span><i class="fas fa-exclamation-circle mr-2"></i> Opco ID: ${notification.opco_id} - ${notification.lokasi_iup}</span>
                                        <small class="text-muted"> Umur Cadangan: ${notification.umur_cadangan_thn} tahun</small>
                                    </div>
                                </a>
                            `);
                        });
                    }

                    // **Notifikasi untuk Masa Berlaku Izin**
                    if (response.izin.length > 0) {
                        notificationList.append(
                            '<span class="dropdown-item text-bold text-warning">⚠️ Masa Berlaku Izin < 1 Tahun</span>'
                        );
                        response.izin.forEach(notification => {
                            notificationList.append(`
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <div style="display: flex; flex-direction: column;">
                                        <span><i class="fas fa-clock mr-2"></i> Opco ID: ${notification.opco_id} - ${notification.lokasi_iup}</span>
                                        <small class="text-muted"> Umur Masa Izin: ${notification.umur_masa_berlaku_izin ? notification.umur_masa_berlaku_izin  : 'Sudah Lewat'}</small>
                                    </div>
                                </a>
                            `);
                        });
                    }

                    notificationList.append();
                } else {
                    notificationCount.text("0");
                    notificationList.append(
                        '<span class="dropdown-item dropdown-header">Tidak ada Notifikasi</span>');
                }
            }
        });
    }

    $(document).ready(function() {
        fetchNotifications();
        setInterval(fetchNotifications, 60000); // Perbarui setiap 1 menit
    });
</script>
