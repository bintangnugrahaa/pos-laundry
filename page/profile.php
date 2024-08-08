<?php

// Ambil id dari parameter GET
$id = $_GET['id'];

// Query untuk mengambil data dari database berdasarkan id
$query = "SELECT * FROM tb_users WHERE userid = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Inisialisasi variabel dengan data yang diambil, menghindari XSS dengan htmlspecialchars
$username = htmlspecialchars($row['username']);
$nama = htmlspecialchars($row['nama']);
$alamat = htmlspecialchars($row['alamat']);
$usertelp = htmlspecialchars($row['usertelp']);

// Jika tombol ubah ditekan (POST request)
if (isset($_POST['ubah'])) {
  // Ambil dan bersihkan data dari form
  $username = htmlentities(strip_tags(trim($_POST["username"])));
  $nama = htmlentities(strip_tags(trim($_POST["nama"])));
  $alamat = htmlentities(strip_tags(trim($_POST["alamat"])));
  $usertelp = htmlentities(strip_tags(trim($_POST["usertelp"])));
  $pesan_error = "";
  $pesan_error_user = "";

  // Validasi perubahan username
  if ($row['username'] !== $username) {
    // Periksa apakah username sudah digunakan dengan query
    $query_username = "SELECT * FROM tb_users WHERE username = '$username'";
    $result_username = mysqli_query($conn, $query_username);
    $count_username = mysqli_num_rows($result_username);
    if ($count_username > 0) {
      $pesan_error_user = "Username <b>$username</b> sudah digunakan <br>";
    }
  }

  // Jika tidak ada pesan error username, lakukan update data
  if ($pesan_error_user == "") {
    $query_update = "UPDATE tb_users SET
      username = '$username',
      nama = '$nama',
      alamat = '$alamat',
      usertelp = '$usertelp'
      WHERE userid = '$id'";
    $result_update = mysqli_query($conn, $query_update);

    // Cek keberhasilan update
    if ($result_update) {
      echo "
      <script>
        // Tampilkan pesan berhasil dan redirect ke halaman index.php
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Profile berhasil diubah.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = 'index.php';
        });
      </script>
      ";
    } else {
      $pesan_error .= "Data gagal diubah !";
    }
  } else {
    $pesan_error .= "Data gagal diubah !";
  }
} else {
  // Pesan error default jika tidak ada aksi POST
  $pesan_error = "";
  $pesan_error_user = "";
}
?>

<!-- Struktur HTML -->
<div class="page-content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb dan Judul Halaman -->
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
          <h4 class="page-title">Profile Users</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">

        <!-- Tampilkan pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <!-- Form untuk mengubah profile -->
        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <!-- Tampilkan foto user -->
              <p align="center">
                <a href="fotouser/<?= htmlspecialchars($row['userfoto']); ?>" target="_blank"><img src="fotouser/<?= htmlspecialchars($row['userfoto']); ?>" style="display: block; margin:auto; height:200px;" class="img-thumbnail img-preview mb-1"></a>

                <!-- Tombol untuk mengubah foto -->
                <a href="?page=profile&aksi=ubahfoto&id=<?= htmlspecialchars($row['userid']); ?>" class="btn btn-primary">Ubah Foto</a>
              </p>

              <!-- Form input untuk username -->
              <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                  <input type="hidden" name="userid" value="<?= htmlspecialchars($row['userid']); ?>">
                  <input class="form-control <?= ($pesan_error_user) ? 'is-invalid' : ''; ?>" type="text" id="username" name="username" placeholder="Masukkan username" autofocus required value="<?= htmlspecialchars($username); ?>" />
                  <!-- Tampilkan pesan error jika username sudah digunakan -->
                  <div class="invalid-feedback">
                    <?= $pesan_error_user; ?>
                  </div>
                </div>
              </div>

              <!-- Form input untuk nama lengkap -->
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" id="nama" name="nama" placeholder="Masukkan nama" value="<?= htmlspecialchars($nama); ?>" required />
                </div>
              </div>

              <!-- Form input untuk alamat -->
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="alamat" name="alamat" cols="20" rows="5" placeholder="Masukkan alamat" required><?= htmlspecialchars($alamat); ?></textarea>
                </div>
              </div>

              <!-- Form input untuk nomor telepon -->
              <div class="form-group row">
                <label for="usertelp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input class="form-control" type="tel" id="usertelp" name="usertelp" placeholder="Masukkan No.Telp" value="<?= htmlspecialchars($usertelp); ?>" required />
                  <br>
                  <!-- Tombol untuk menyimpan perubahan dan kembali -->
                  <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                  <a href="index.php" class="btn btn-warning">Kembali</a>
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
  <!-- end container -->
</div>