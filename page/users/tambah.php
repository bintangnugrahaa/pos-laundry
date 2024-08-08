<?php
// Inisialisasi pesan error
$pesan_error = "";
$pesan_error_user = "";
$pesan_error_foto = "";

// Jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
  // Ambil dan sanitasi data input
  $username = htmlspecialchars(trim($_POST["username"]));
  $nama = htmlspecialchars(trim($_POST["nama"]));
  $userpass = htmlspecialchars(trim($_POST["userpass"]));
  $alamat = htmlspecialchars(trim($_POST["alamat"]));
  $usertelp = htmlspecialchars(trim($_POST["usertelp"]));
  $level = "kasir"; // Set rolenya secara default ke "kasir"

  // Periksa apakah username sudah digunakan
  $query_username = "SELECT * FROM tb_users WHERE username = '$username'";
  $result_username = mysqli_query($conn, $query_username);
  if (mysqli_num_rows($result_username) > 0) {
    $pesan_error_user = "Username <b>$username</b> sudah digunakan.";
  }

  // Memeriksa apakah ada file yang diunggah
  if (!empty($_FILES['userfoto']['name'])) {
    $namaFile = $_FILES["userfoto"]["name"];
    $ukuran = $_FILES["userfoto"]["size"];
    $error = $_FILES["userfoto"]["error"];
    $tmp = $_FILES["userfoto"]["tmp_name"];

    // Validasi error upload file
    if ($error === 4) {
      $pesan_error_foto = "Silahkan pilih file gambar.";
    }

    // Validasi ekstensi file gambar
    $gambarvalid = ["jpg", "jpeg", "png", "gif"];
    $ekstensigambar = pathinfo($namaFile, PATHINFO_EXTENSION);
    if (!in_array(strtolower($ekstensigambar), $gambarvalid)) {
      $pesan_error_foto = "File yang diunggah bukan gambar.";
    }

    // Validasi ukuran file gambar (maksimum 2MB)
    if ($ukuran > 2000000) {
      $pesan_error_foto = "Ukuran file gambar terlalu besar.";
    }

    // Jika tidak ada error pada validasi file
    if ($pesan_error_foto == "") {
      // Generate nama unik untuk file gambar
      $namafoto = uniqid() . '.' . $ekstensigambar;
      // Pindahkan file gambar ke folder
      move_uploaded_file($tmp, 'fotouser/' . $namafoto);
    }
  } else {
    $namafoto = null;
  }

  // Jika tidak ada error pada username dan foto
  if ($pesan_error_user == "" && $pesan_error_foto == "") {
    // Enkripsi password
    $password = password_hash($userpass, PASSWORD_DEFAULT);

    // Insert data ke database
    $query_insert = "INSERT INTO tb_users (username, userpass, nama, alamat, usertelp, level, userfoto) VALUES ('$username', '$password', '$nama', '$alamat', '$usertelp', '$level', '$namafoto')";
    $result_insert = mysqli_query($conn, $query_insert);

    // Notifikasi sukses jika data berhasil ditambahkan
    if ($result_insert) {
      echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data karyawan berhasil ditambahkan.',
                timer: 1000,
                showConfirmButton: false
              }).then(function() {
                window.location.href = '?page=users';
              });
            </script>";
    } else {
      $pesan_error = "Data gagal disimpan!";
    }
  } else {
    $pesan_error = "Data gagal disimpan!";
  }
}

// Jika tidak ada aksi tambah atau aksi gagal
if (!$pesan_error && !isset($_POST['tambah'])) {
  $username = "";
  $nama = "";
  $userpass = "";
  $alamat = "";
  $usertelp = "";
  $pesan_error_user = "";
  $pesan_error_foto = "";
}
?>
<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="?page=users">Laundry</a></li>
              <li class="breadcrumb-item active"><a href="?page=users">Data Karyawan</a></li>
              <li class="breadcrumb-item active">Tambah Data Karyawan</li>
            </ol>
          </div>
          <h4 class="page-title">Tambah Data Karyawan</h4>
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

        <form action="" method="post" enctype="multipart/form-data">
          <div class="card m-b-100">
            <div class="card-body">

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                  <input class="form-control <?= ($pesan_error_user) ? 'is-invalid' : ''; ?>" type="text" id="example-text-input" name="username" placeholder="Masukkan username" autofocus required value="<?= $username; ?>" />
                  <div class="invalid-feedback">
                    <?= $pesan_error_user; ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                  <input class="form-control" type="password" id="example-text-input" name="userpass" placeholder="Masukkan password" required value="<?= $userpass; ?>" />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" id="example-text-input" name="nama" placeholder="Masukkan nama" value="<?= $nama; ?>" required />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="example-text-input" name="alamat" cols="20" rows="5" placeholder="Masukkan alamat" required><?= $alamat; ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number" id="example-text-input" name="usertelp" placeholder="Masukkan No.Telp" value="<?= $usertelp; ?>" required />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Foto</label>
                <div class="col-sm-10">
                  <input class="form-control <?= ($pesan_error_foto) ? 'is-invalid' : ''; ?>" type="file" id="example-text-input" name="userfoto" />
                  <div class="invalid-feedback">
                    <?= $pesan_error_foto; ?>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                  <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                  <a href="?page=users" class="btn btn-warning">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- End col -->
    </div>
    <!-- End row -->
  </div>
</div>