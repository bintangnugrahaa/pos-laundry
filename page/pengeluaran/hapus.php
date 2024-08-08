<?php
// Ambil id pengeluaran dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Hapus data pengeluaran dari tabel tb_pengeluaran
$query1 = "DELETE FROM tb_pengeluaran WHERE id_pengeluaran = $id";
$result1 = mysqli_query($conn, $query1);

// Hapus data pengeluaran dari tabel tb_laporan yang terkait
$query2 = "DELETE FROM tb_laporan WHERE id_pengeluaran = $id";
$result2 = mysqli_query($conn, $query2);

// Cek keberhasilan penghapusan
if ($result1 && $result2) {
  // Jika berhasil, tampilkan notifikasi menggunakan SweetAlert
  echo "
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Data pengeluaran berhasil dihapus.',
      timer: 1000,
      showConfirmButton: false
    }).then(function() {
      window.location.href = '?page=pengeluaran';
    });
  </script>
  ";
}
