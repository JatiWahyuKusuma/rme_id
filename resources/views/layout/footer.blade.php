<style>
    /* Footer Fixed Position */
    .main-footer {
        position: fixed !important;
        bottom: 0;
        left: 250px;
        right: 0;
        z-index: 1000;
        background-color: #ffffff;
        color: #000000;
        padding: 10px 20px;
        margin-left: 0 !important;
    }

    /* Adjust content padding to account for fixed footer */
    .content-wrapper {
        padding-bottom: 60px !important;
    }

    /* Existing footer styles */
    .main-footer.float-right.d-none.d-sm-block {
        color: #000000;
        font-weight: 800;
    }

    /* New style for Raw Material Expansion text */
    .material-expansion-text {
        color: #800000 !important;
    }
</style>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b id="jakarta-time"></b><br>
    </div>
    <strong>Copyright &copy; <a class="material-expansion-text">Raw Material Expansion</a> | PT Semen Indonesia
        (Persero). Tbk </strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script>
    function updateJakartaTime() {
        const options = {
            timeZone: 'Asia/Jakarta',
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };

        const now = new Date();
        const jakartaTime = now.toLocaleDateString('id-ID', options);
        document.getElementById('jakarta-time').textContent = jakartaTime;
    }

    // Update time immediately
    updateJakartaTime();

    // Update time every second
    setInterval(updateJakartaTime, 1000);
</script>
