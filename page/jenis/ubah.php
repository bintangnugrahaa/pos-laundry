<?php
// Ambil nilai id dari URL
$id = $_GET['id'];

// Query untuk menampilkan data jenis berdasarkan id
$query = "SELECT * FROM tb_jenis WHERE kd_jenis = '$id'";
$result = mysqli_query($conn, $query);

// Inisialisasi variabel dengan data dari database
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $jenis_laundry = $row['jenis_laundry'];
  $lama_proses = $row['lama_proses'];
  $tarif = $row['tarif'];
} else {
  // Jika data tidak ditemukan, tampilkan pesan error
  $pesan_error = "Data tidak ditemukan.";
}

// Inisialisasi pesan error
$pesan_error = "";

// Jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
  // Ambil dan bersihkan nilai input
  $jenis_laundry = htmlspecialchars(strip_tags(trim($_POST["jenis_laundry"])));
  $lama_proses = intval($_POST["lama_proses"]);
  $tarif = floatval($_POST["tarif"]);

  // Mengecek apakah jenis laundry yang diinputkan tidak sama dengan jenis laundry yang sudah ada
  if ($row['jenis_laundry'] !== $jenis_laundry) {
    // Query untuk mengecek apakah jenis laundry sudah ada
    $query_cek = "SELECT * FROM tb_jenis WHERE jenis_laundry = '$jenis_laundry'";
    $result_cek = mysqli_query($conn, $query_cek);

    // Jika sudah ada, tambahkan pesan error
    if (mysqli_num_rows($result_cek) > 0) {
      $pesan_error = "Jenis Laundry <b>$jenis_laundry</b> sudah ada <br>";
    }
  }

  // Jika tidak ada pesan error, lakukan update data
  if ($pesan_error == "") {
    $query_update = "UPDATE tb_jenis SET jenis_laundry = '$jenis_laundry', lama_proses = $lama_proses, tarif = $tarif WHERE kd_jenis = '$id'";
    $result_update = mysqli_query($conn, $query_update);

    // Jika query berhasil dijalankan, tampilkan notifikasi dan redirect ke halaman jenis layanan
    if ($result_update) {
      echo "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data jenis layanan berhasil diubah.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=jenis';
        });
      </script>";
    } else {
      // Jika gagal disimpan, tambahkan pesan error
      $pesan_error .= "Data gagal disimpan !";
    }
  } else {
    // Jika ada pesan error sebelumnya, tambahkan pesan error
    $pesan_error .= "Data gagal disimpan !";
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
              <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
              <li class="breadcrumb-item"><a href="?page=jenis">Data Jenis Laundry</a></li>
              <li class="breadcrumb-item active">Edit Jenis Laundry</li>
            </ol>
          </div>
          <h4 class="page-title">Edit Jenis Laundry</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Menampilkan notifikasi pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Jenis Layanan Laundry</label>
                <div class="col-sm-10">
                  <!-- Input untuk jenis layanan -->
                  <input class="form-control" type="text" id="example-text-input" name="jenis_laundry" placeholder="Masukkan jenis laundry" value="<?= htmlspecialchars($jenis_laundry); ?>" required autofocus />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Lama Proses (hari)</label>
                <div class="col-sm-10">
                  <!-- Input untuk lama proses -->
                  <input class="form-control" type="number" id="example-text-input" name="lama_proses" placeholder="Masukkan lama proses" value="<?= $lama_proses; ?>" required />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Tarif (Per Kg)</label>
                <div class="col-sm-10">
                  <!-- Input untuk tarif per Kg -->
                  <input class="form-control" type="number" id="example-text-input" name="tarif" placeholder="Masukkan tarif" value="<?= $tarif; ?>" required />
                  <br>
                  <!-- Tombol untuk submit dan kembali -->
                  <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                  <a href="?page=jenis" class="btn btn-warning">Kembali</a>
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
<!-- end page-content-wrapper -->