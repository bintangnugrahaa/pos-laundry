<?php
// Ambil data dari URL berdasarkan id
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data dari tabel tb_pelanggan berdasarkan id
$query = "SELECT * FROM tb_pelanggan WHERE pelangganid = $id";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);

  // Inisialisasi variabel dengan data yang diambil
  $nama = $row['pelanggannama'];
  $alamat = $row['pelangganalamat'];
  $pelanggantelp = $row['pelanggantelp'];

  // Jika tombol ubah ditekan
  if (isset($_POST['ubah'])) {
    // Tangkap data dari form dan bersihkan
    $nama = mysqli_real_escape_string($conn, strip_tags(trim($_POST["pelanggannama"])));
    $alamat = mysqli_real_escape_string($conn, strip_tags(trim($_POST["pelangganalamat"])));
    $pelanggantelp = mysqli_real_escape_string($conn, strip_tags(trim($_POST["pelanggantelp"])));
    $pesan_error = "";

    // Query untuk update data
    $query = "UPDATE `tb_pelanggan` SET
              `pelanggannama` = '$nama',
              `pelangganalamat` = '$alamat',
              `pelanggantelp` = '$pelanggantelp'
              WHERE `pelangganid` = $id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
      echo "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data pelanggan berhasil diubah.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=pelanggan';
        });
      </script>
      ";
    } else {
      $pesan_error = "Data gagal diubah.";
    }
  }
} else {
  $pesan_error = "Data pelanggan tidak ditemukan.";
}
?>

<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <!-- Breadcrumb untuk navigasi -->
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="?page=pelanggan">Laundry</a></li>
              <li class="breadcrumb-item"><a href="?page=pelanggan">Data Pelanggan</a></li>
              <li class="breadcrumb-item active">Edit Pelanggan</li>
            </ol>
          </div>
          <h4 class="page-title">Edit Pelanggan</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">

        <!-- Menampilkan pesan error jika ada -->
        <?php if (!empty($pesan_error)) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <div class="form-group row">
                <label for="pelanggannama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <!-- Input nama pelanggan -->
                  <input type="text" class="form-control" id="pelanggannama" name="pelanggannama" placeholder="Masukkan nama" value="<?= htmlspecialchars($nama); ?>" required autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <!-- Input alamat pelanggan -->
                  <textarea class="form-control" id="alamat" name="pelangganalamat" rows="5" placeholder="Masukkan alamat" required><?= htmlspecialchars($alamat); ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="pelanggantelp" class="col-sm-2 col-form-label">No. Telp</label>
                <div class="col-sm-10">
                  <!-- Input nomor telepon pelanggan -->
                  <input type="number" class="form-control" id="pelanggantelp" name="pelanggantelp" placeholder="Masukkan No.Telp" value="<?= htmlspecialchars($pelanggantelp); ?>" required>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-12">
                  <!-- Tombol untuk submit form dan kembali -->
                  <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                  <a href="?page=pelanggan" class="btn btn-warning">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  <!-- end container-fluid -->
</div>