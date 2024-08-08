<?php
// Menangkap nilai id dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data user berdasarkan ID
$query_select = "SELECT * FROM tb_users WHERE userid = '$id'";
$result_select = mysqli_query($conn, $query_select);

// Memeriksa apakah query berhasil dieksekusi
if ($result_select) {
  // Mengambil data user dari hasil query
  $row = mysqli_fetch_assoc($result_select);

  // Menyimpan username untuk informasi
  $username = $row['username'];

  // Menghapus foto profil jika ada
  if (!empty($row['userfoto'])) {
    $foto_path = 'fotouser/' . $row['userfoto'];
    if (file_exists($foto_path)) {
      unlink($foto_path); // Menghapus file foto dari direktori
    }
  }

  // Query untuk menghapus data users dari tabel tb_users
  $query_delete = "DELETE FROM tb_users WHERE userid = '$id'";
  $result_delete = mysqli_query($conn, $query_delete);

  // Memeriksa apakah penghapusan data berhasil
  if ($result_delete) {
    // Jika penghapusan berhasil, tampilkan pesan sukses dan redirect ke halaman users
    echo "
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data karyawan berhasil dihapus.',
        timer: 1000,
        showConfirmButton: false
      }).then(function() {
        window.location.href = '?page=users';
      });
    </script>
    ";
  } else {
    // Jika penghapusan gagal, tampilkan pesan error
    echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Gagal menghapus data karyawan.',
        timer: 1000,
        showConfirmButton: false
      }).then(function() {
        window.location.href = '?page=users';
      });
    </script>
    ";
  }
}
