<?php
// Memulai session
session_start();

// Menghapus semua variabel session
session_unset();

// Menghapus session
session_destroy();

// Menampilkan SweetAlert2 setelah logout berhasil
echo "
<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Logout berhasil',
            icon: 'success',
            showConfirmButton: false,
            timer: 1000
        }).then(() => {
            window.location.href = 'login.php';
        });
    });
</script>
";
