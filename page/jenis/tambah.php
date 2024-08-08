<?php
// Inisialisasi variabel pesan error dan data input
$pesan_error = "";
$jenis_laundry = "";
$lama_proses = "";
$tarif = "";

// Jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
  // Mengambil dan membersihkan nilai input
  $jenis_laundry = htmlspecialchars(strip_tags(trim($_POST["jenis_laundry"])));
  $lama_proses = intval($_POST["lama_proses"]);
  $tarif = floatval($_POST["tarif"]);

  // Query untuk mengecek apakah jenis laundry sudah ada
  $query_cek = "SELECT * FROM tb_jenis WHERE jenis_laundry = '$jenis_laundry'";
  $result_cek = mysqli_query($conn, $query_cek);

  // Jika jenis laundry sudah ada, tambahkan pesan error
  if (mysqli_num_rows($result_cek) > 0) {
    $pesan_error .= "Jenis <b>$jenis_laundry</b> sudah ada <br>";
  }

  // Jika tidak ada error, lakukan penyimpanan data
  if ($pesan_error == "") {
    // Query untuk menyimpan data
    $query_insert = "INSERT INTO tb_jenis (jenis_laundry, lama_proses, tarif) VALUES ('$jenis_laundry', $lama_proses, $tarif)";
    $query = mysqli_query($conn, $query_insert);

    // Jika penyimpanan berhasil, tampilkan notifikasi dan redirect ke halaman jenis layanan
    if ($query) {
      echo "
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data jenis layanan berhasil ditambahkan.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=jenis';
        });
      </script>";
    } else {
      // Jika penyimpanan gagal, tambahkan pesan error
      $pesan_error .= "Data gagal disimpan !";
    }
  } else {
    // Jika ada error sebelumnya, tambahkan pesan error
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
              <li class="breadcrumb-item"><a href="?page=jenis">Laundry</a></li>
              <li class="breadcrumb-item"><a href="?page=jenis">Data Jenis Layanan</a></li>
              <li class="breadcrumb-item active">Tambah Jenis Layanan</li>
            </ol>
          </div>
          <h4 class="page-title">Tambah Jenis Layanan</h4>
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
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama Jenis Layanan</label>
                <div class="col-sm-10">
                  <!-- Input untuk jenis layanan -->
                  <input class="form-control" type="text" id="example-text-input" name="jenis_laundry" placeholder="Masukkan nama jenis layanan" value="<?= htmlspecialchars($jenis_laundry); ?>" required autofocus />
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
                <label for="example-text-input" class="col-sm-2 col-form-label">Harga (Per Kg)</label>
                <div class="col-sm-10">
                  <!-- Input untuk harga per Kg -->
                  <input class="form-control" type="number" id="example-text-input" name="tarif" placeholder="Masukkan harga" value="<?= $tarif; ?>" required />
                  <br>
                  <!-- Tombol untuk submit dan kembali -->
                  <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                  <a href="?page=jenis" class="btn btn-warning">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- Kolom untuk end col -->
    </div>
    <!-- Kolom untuk end row -->
  </div>
  <!-- Kolom untuk end container -->
</div>