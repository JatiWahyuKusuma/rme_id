<style>
    /* Mengatur ukuran dropdown agar tidak terlalu panjang */
    .dropdown-menu {
        width: 350px;
        /* Atur lebar dropdown */
        max-height: 400px;
        /* Batasi tinggi dropdown */
        overflow-y: auto;
        /* Tambahkan scroll jika konten melebihi batas */
    }

    /* Mengatur padding dan wrapping agar teks tidak keluar dari kotak */
    .dropdown-item {
        white-space: normal !important;
        /* Pastikan teks tidak terpotong */
        word-wrap: break-word;
        /* Izinkan teks pindah baris jika terlalu panjang */
        padding: 10px;
        /* Beri ruang lebih agar lebih rapi */
    }

    .navbar-nav .nav-item .nav-link {
        position: relative;
    }

    .navbar-nav .nav-item .nav-link i.fa-bell {
        font-size: 27px;
        /* Perbesar ikon notifikasi */
        position: relative;
    }

    .navbar-nav .nav-item .nav-link i.fa-expand-arrows-alt {
        font-size: 25px;
        /* Sesuaikan ukuran */
        margin-left: 10px;
        /* Beri jarak dari ikon notifikasi */
    }

    .navbar-nav .navbar-badge {
        position: absolute;
        top: -5px;
        /* Geser ke atas */
        right: -3px;
        /* Geser ke kanan */
        font-size: 14px;
        /* Perbesar angka notifikasi */
        font-weight: bold;
        /* Buat angka lebih tebal */
        padding: 5px 8px;
        /* Sesuaikan ukuran */
        border-radius: 50%;
        /* Agar tetap berbentuk lingkaran */
        background-color: red;
        /* Pastikan warna background merah tetap terlihat */
        color: white;
        /* Warna angka */
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
            url: "{{ route('notifikasi') }}",
            type: "GET",
            success: function(response) {
                console.log("Notifikasi diterima:", response); // Debugging

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
                            notificationList.append(
                                `<div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <div style="display: flex; flex-direction: column;">
                                    <span><i class="fas fa-exclamation-circle mr-2"></i> Lokasi: ${notification.lokasi_iup}</span>
                                    <small class="text-muted"> Umur Cadangan: ${notification.umur_cadangan_thn} tahun</small>
                                </div>
                            </a>`
                            );
                        });
                    }

                    // **Notifikasi untuk Masa Berlaku Izin**
                    if (response.izin.length > 0) {
                        notificationList.append(
                            '<span class="dropdown-item text-bold text-warning">⚠️ Masa Berlaku Izin < 1 Tahun</span>'
                        );
                        response.izin.forEach(notification => {
                            notificationList.append(
                                `<div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <div style="display: flex; flex-direction: column;">
                                    <span><i class="fas fa-clock mr-2"></i> Lokasi: ${notification.lokasi_iup}</span>
                                    <small class="text-muted"> Umur Masa Izin: ${notification.umur_masa_berlaku_izin ? notification.umur_masa_berlaku_izin : 'Sudah Lewat'}</small>
                                </div>
                            </a>`
                            );
                        });
                    }
                } else {
                    notificationCount.text("0");
                    notificationList.append(
                        '<span class="dropdown-item dropdown-header">Tidak ada Notifikasi</span>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil notifikasi:", error);
            }
        });
    }

    $(document).ready(function() {
        fetchNotifications();
        setInterval(fetchNotifications, 60000); // Perbarui setiap 1 menit
    });
</script>
