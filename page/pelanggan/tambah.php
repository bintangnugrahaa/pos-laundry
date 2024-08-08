<?php
// Inisialisasi variabel pesan error dan data input
$pesan_error = "";
$nama = "";
$alamat = "";
$pelanggantelp = "";

// Jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
  // Ambil dan bersihkan data dari form
  $nama = mysqli_real_escape_string($conn, strip_tags(trim($_POST["pelanggannama"])));
  $alamat = mysqli_real_escape_string($conn, strip_tags(trim($_POST["alamat"])));
  $pelanggantelp = mysqli_real_escape_string($conn, strip_tags(trim($_POST["pelanggantelp"])));

  // Validasi data, misalnya validasi required bisa ditambahkan di sini
  if (empty($nama) || empty($alamat) || empty($pelanggantelp)) {
    $pesan_error = "Semua kolom harus diisi.";
  } else {
    // Input data ke database
    $query = "INSERT INTO `tb_pelanggan` (`pelanggannama`, `pelangganalamat`, `pelanggantelp`) VALUES ('$nama', '$alamat', '$pelanggantelp')";

    if (mysqli_query($conn, $query)) {
      echo "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data pelanggan berhasil ditambahkan.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=pelanggan';
        });
      </script>
      ";
    } else {
      $pesan_error = "Data gagal disimpan.";
    }
  }
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
              <li class="breadcrumb-item active">Tambah Data Pelanggan</li>
            </ol>
          </div>
          <h4 class="page-title">Tambah Data Pelanggan</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Menampilkan pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="card m-b-30">
            <div class="card-body">
              <div class="form-group row">
                <label for="pelanggannama" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-10">
                  <!-- Input nama pelanggan -->
                  <input type="text" class="form-control" id="pelanggannama" name="pelanggannama" placeholder="Masukkan nama pelanggan" value="<?= htmlspecialchars($nama); ?>" required autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <!-- Input alamat pelanggan -->
                  <textarea class="form-control" id="alamat" name="alamat" rows="5" placeholder="Masukkan alamat" required><?= htmlspecialchars($alamat); ?></textarea>
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
                  <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
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