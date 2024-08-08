<?php

// Inisialisasi variabel untuk menangkap id dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
  // Update status pengambilan baju dalam database
  $query = "UPDATE tb_laundry SET `status_pengambilan` = 1 WHERE id_laundry = '$id'";
  $result = mysqli_query($conn, $query);

  // Periksa apakah query berhasil dijalankan
  if ($result) {
    // Jika berhasil, tampilkan notifikasi menggunakan SweetAlert
    echo "
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Baju sudah diambil pelanggan.',
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
            text: 'Gagal mengupdate status pengambilan baju.'
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
        text: 'ID laundry tidak valid.'
      }).then(function() {
        // Redirect ke halaman laundry setelah notifikasi ditutup
        window.location.href = '?page=laundry';
      });
    </script>
    ";
}
