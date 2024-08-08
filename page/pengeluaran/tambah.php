<?php
// Proses form tambah data pengeluaran
if (isset($_POST['tambah'])) {
  // Ambil data dari form dan bersihkan
  $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal"]);
  $catatan = mysqli_real_escape_string($conn, $_POST["catatan"]);
  $pengeluaran = mysqli_real_escape_string($conn, $_POST["pengeluaran"]);
  $ket_laporan = 2;
  $pesan_error = "";

  // Input ke tabel tb_pengeluaran
  $query = mysqli_query($conn, "INSERT INTO `tb_pengeluaran` (`tgl_pengeluaran`, `catatan`, `pengeluaran`) VALUES ('$tanggal', '$catatan', '$pengeluaran')");

  // Ambil id_pengeluaran terakhir yang di-generate
  $id_pengeluaran = mysqli_insert_id($conn);

  // Input ke tabel tb_laporan
  $query2 = mysqli_query($conn, "INSERT INTO `tb_laporan` (`tgl_laporan`, `ket_laporan`, `catatan`, `id_pengeluaran`, `pengeluaran`, `pemasukan`) VALUES ('$tanggal', '$ket_laporan', '$catatan', '$id_pengeluaran', '$pengeluaran', 0)");

  // Cek keberhasilan input
  if ($query && $query2) {
    // Jika berhasil, tampilkan pesan sukses dan redirect
    echo "
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data pengeluaran berhasil ditambahkan.',
        timer: 1000,
        showConfirmButton: false
      }).then(function() {
        window.location.href = '?page=pengeluaran';
      });
    </script>
    ";
  } else {
    // Jika gagal, simpan pesan error
    $pesan_error .= "Data pengeluaran gagal disimpan!";
  }
} else {
  // Inisialisasi variabel jika tidak ada data yang disubmit
  $pesan_error = "";
  $tanggal = "";
  $catatan = "";
  $pengeluaran = "";
}
?>

<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
              <li class="breadcrumb-item active">Data Pengeluaran</li>
              <li class="breadcrumb-item active">Tambah Data Pengeluaran</li>
            </ol>
          </div>
          <h4 class="page-title">Tambah Pengeluaran</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">

        <?php if ($pesan_error !== "") : ?>
          <!-- Tampilkan pesan error jika ada -->
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">
              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-10">
                  <input class="form-control" type="date" id="example-text-input" name="tanggal" value="<?= htmlspecialchars($tanggal); ?>" required autofocus />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="example-text-input" name="catatan" cols="20" rows="5" placeholder="Masukkan catatan" required><?= htmlspecialchars($catatan); ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-number-input" class="col-sm-2 col-form-label">Pengeluaran (Rp)</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="pengeluaran" id="pengeluaran" value="<?= htmlspecialchars($pengeluaran); ?>" required>
                  <br>
                  <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                  <a href="?page=pengeluaran" class="btn btn-warning">Kembali</a>
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
</div>