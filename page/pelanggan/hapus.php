<?php
// Ambil id dari parameter GET
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Pastikan id tidak kosong
if (!$id) {
  die('ID tidak valid.');
}

// Ambil data pelanggan dari database berdasarkan id
$query = "SELECT * FROM tb_pelanggan WHERE pelangganid = $id";
$result = mysqli_query($conn, $query);

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $username = $row['pelanggannama'];

  // Hapus data pelanggan dari database
  $deleteQuery = "DELETE FROM tb_pelanggan WHERE pelangganid = $id";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  // Jika penghapusan berhasil, tampilkan pesan sukses
  if ($deleteResult) {
    echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data pelanggan berhasil dihapus.',
                timer: 1000,
                showConfirmButton: false
            }).then(function() {
                window.location.href = '?page=pelanggan';
            });
        </script>
        ";
  } else {
    // Jika terjadi kesalahan saat menghapus data
    echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menghapus data pelanggan.',
                timer: 1000,
                showConfirmButton: false
            }).then(function() {
                window.location.href = '?page=pelanggan';
            });
        </script>
        ";
  }
} else {
  // Jika data pelanggan tidak ditemukan
  echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Data pelanggan tidak ditemukan.',
            timer: 1000,
            showConfirmButton: false
        }).then(function() {
            window.location.href = '?page=pelanggan';
        });
    </script>
    ";
}
