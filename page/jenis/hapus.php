<?php
// Inisialisasi pesan error
$pesan_error = "";

// Menangkap dan sanitasi nilai id dari URL
$id = isset($_GET['id']) ? htmlspecialchars(trim($_GET['id'])) : '';

// Memastikan id adalah bilangan bulat positif sebelum digunakan dalam query
if (!ctype_digit($id)) {
  die("Invalid ID");
}

// Query untuk mengambil data dari tabel tb_jenis berdasarkan id
$query = "SELECT jenis_laundry FROM tb_jenis WHERE kd_jenis = '$id'";
$result = mysqli_query($conn, $query);

// Memeriksa apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $jenis_laundry = $row['jenis_laundry'];

  // Query untuk menghapus data jenis laundry berdasarkan id
  $query_delete = "DELETE FROM tb_jenis WHERE kd_jenis = '$id'";
  $result_delete = mysqli_query($conn, $query_delete);

  // Memeriksa jika penghapusan berhasil
  if (mysqli_affected_rows($conn) > 0) {
    // Menampilkan notifikasi SweetAlert2 setelah berhasil menghapus
    echo "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data jenis layanan berhasil dihapus.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=jenis'; // Redirect ke halaman jenis layanan
        });
      </script>
    ";
  } else {
    $pesan_error = "Gagal menghapus data.";
  }
} else {
  $pesan_error = "Data tidak ditemukan.";
}

// Menampilkan pesan error jika terjadi kesalahan
if ($pesan_error !== "") {
  echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '$pesan_error',
        timer: 3000,
        showConfirmButton: false
      }).then(function() {
        window.location.href = '?page=jenis'; // Redirect ke halaman jenis layanan
      });
    </script>
  ";
}
