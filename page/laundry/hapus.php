<?php

// Memanggil koneksi
include "../../include/koneksi.php";

// Inisialisasi variabel untuk menangkap id dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (!empty($id)) {
  // Hapus data transaksi laundry berdasarkan id
  $query = "DELETE FROM tb_laundry WHERE id_laundry = '$id'";
  $result = mysqli_query($conn, $query);

  // Periksa apakah query berhasil dijalankan
  if ($result) {
    // Jika berhasil, tampilkan notifikasi menggunakan SweetAlert
    echo "
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Transaksi laundry berhasil dihapus.',
            timer: 1000,
            showConfirmButton: false
          }).then(function() {
            // Redirect ke halaman laundry setelah notifikasi ditutup
            window.location.href = '?page=laundry';
          });
        </script>
        ";
  } else {
    // Jika query tidak berhasil
    echo "
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Gagal menghapus transaksi laundry.'
          }).then(function() {
            // Redirect ke halaman laundry setelah notifikasi ditutup
            window.location.href = '?page=laundry';
          });
        </script>
        ";
  }
} else {
  // Jika id kosong atau tidak valid
  echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'ID transaksi laundry tidak valid.'
      }).then(function() {
        // Redirect ke halaman laundry setelah notifikasi ditutup
        window.location.href = '?page=laundry';
      });
    </script>
    ";
}
