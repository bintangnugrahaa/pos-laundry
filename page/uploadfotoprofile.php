<?php
// Ambil id dari parameter GET
$id = $_GET['id'];

// Inisialisasi pesan error
$pesan_error = "";

// Jika tombol simpan ditekan (POST request)
if (isset($_POST['simpan'])) {
  // Cek apakah ada file yang diunggah
  if ($_FILES['userfoto']['name'] !== "") {
    $namaFile = $_FILES["userfoto"]["name"];
    $ukuran = $_FILES["userfoto"]["size"];
    $error = $_FILES["userfoto"]["error"];
    $tmp = $_FILES["userfoto"]["tmp_name"];

    // Validasi error pada file yang diunggah
    if ($error === 4) {
      $pesan_error = "Silahkan pilih file gambar.";
    }

    // Validasi ekstensi file gambar yang diizinkan
    $gambarvalid = ["jpg", "jpeg", "png", "gif"];
    $ekstensigambar = pathinfo($namaFile, PATHINFO_EXTENSION);
    if (!in_array($ekstensigambar, $gambarvalid)) {
      $pesan_error = "File yang diunggah bukan gambar.";
    }

    // Validasi ukuran file maksimum 3MB
    if ($ukuran > 3000000) {
      $pesan_error = "Ukuran file gambar terlalu besar.";
    }

    // Jika tidak ada pesan error
    if ($pesan_error == "") {
      // Generate nama unik untuk file gambar
      $namafoto = uniqid() . '.' . $ekstensigambar;

      // Pindahkan file gambar ke folder foto user
      move_uploaded_file($tmp, 'fotouser/' . $namafoto);

      // Hapus foto sebelumnya jika ada
      $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE userid = $id");
      $row = mysqli_fetch_assoc($query);
      if ($row['userfoto'] != NULL || $row['userfoto'] != "") {
        unlink('fotouser/' . $row['userfoto']);
      }

      // Simpan nama file gambar ke database untuk user dengan id tertentu
      mysqli_query($conn, "UPDATE tb_users SET userfoto = '$namafoto' WHERE userid = $id");

      // Tampilkan pesan sukses menggunakan SweetAlert2 dan redirect ke halaman index.php
      echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Foto profile berhasil diupload.',
                timer: 1000,
                showConfirmButton: false
              }).then(function() {
                window.location.href = 'index.php';
              });
            </script>";
    }
  } else {
    $pesan_error = "Silahkan pilih file gambar.";
  }
}
?>

<!-- Tata letak HTML -->
<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <h4 class="page-title">Upload Foto User</h4>
        </div>
        <!-- Pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <h4 class="page-title">Upload Foto</h4>
            <!-- Form untuk upload foto -->
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <div class="col-sm-10">
                  <input class="form-control" type="file" id="foto" name="userfoto" />
                </div>
              </div>
              <!-- Tombol simpan untuk menyimpan foto -->
              <button class="btn btn-success" type="submit" name="simpan">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>