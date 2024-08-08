<?php
// Ambil id pengeluaran dari URL
$id_pengeluaran = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data pengeluaran dari tabel tb_pengeluaran
$query_p = mysqli_query($conn, "SELECT * FROM tb_pengeluaran WHERE id_pengeluaran = '$id_pengeluaran'");
$result = mysqli_fetch_assoc($query_p);

// Inisialisasi variabel dengan data yang diambil
$tanggal = $result['tgl_pengeluaran'];
$catatan = $result['catatan'];
$pengeluaran = $result['pengeluaran'];

// Proses form jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
  // Ambil dan bersihkan data dari form
  $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal"]);
  $catatan = mysqli_real_escape_string($conn, $_POST["catatan"]);
  $pengeluaran = mysqli_real_escape_string($conn, $_POST["pengeluaran"]);
  $pesan_error = "";

  // Update data pengeluaran pada tb_pengeluaran
  $query = mysqli_query($conn, "UPDATE tb_pengeluaran SET tgl_pengeluaran = '$tanggal', catatan = '$catatan', pengeluaran = '$pengeluaran' WHERE id_pengeluaran = '$id_pengeluaran'");

  // Update data pengeluaran pada tb_laporan
  $query2 = mysqli_query($conn, "UPDATE tb_laporan SET catatan = '$catatan', tgl_laporan = '$tanggal', pengeluaran = '$pengeluaran' WHERE id_pengeluaran = '$id_pengeluaran'");

  // Cek keberhasilan update
  if ($query && $query2) {
    // Jika berhasil, tampilkan pesan sukses dan redirect
    echo "
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data pengeluaran berhasil diubah.',
        timer: 1000,
        showConfirmButton: false
      }).then(function() {
        window.location.href = '?page=pengeluaran';
      });
    </script>
    ";
  } else {
    // Jika gagal, simpan pesan error
    $pesan_error .= "Data pengeluaran gagal diubah!";
  }
} else {
  $pesan_error = ""; // Inisialisasi pesan error jika tidak ada kesalahan
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
              <li class="breadcrumb-item active">Edit Data Pengeluaran</li>
            </ol>
          </div>
          <h4 class="page-title">Edit Data Pengeluaran</h4>
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
                  <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
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