<?php
// Ambil ID dari parameter GET
$id = $_GET['id'];

// Inisialisasi pesan error
$pesan_error = "";
$pesan_error_user = "";

// Query untuk mendapatkan data user berdasarkan ID
$query = "SELECT * FROM tb_users WHERE userid = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  // Mengambil data dari hasil query untuk ditampilkan di form
  $username = $row['username'];
  $nama = $row['nama'];
  $alamat = $row['alamat'];
  $usertelp = $row['usertelp'];

  // Jika tombol ubah ditekan
  if (isset($_POST['ubah'])) {
    // Ambil nilai dari form
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $alamat = htmlentities(strip_tags(trim($_POST["alamat"])));
    $usertelp = htmlentities(strip_tags(trim($_POST["usertelp"])));

    // Validasi username baru dengan username yang sudah ada
    if ($row['username'] !== $username) {
      $query_username = "SELECT * FROM tb_users WHERE username = '$username'";
      $result_username = mysqli_query($conn, $query_username);
      if (mysqli_num_rows($result_username) > 0) {
        $pesan_error_user = "Username <b>$username</b> sudah digunakan.";
      }
    }

    // Jika tidak ada error pada validasi username, lakukan update data
    if ($pesan_error_user === "") {
      $query_update = "UPDATE tb_users SET username = '$username', nama = '$nama', alamat = '$alamat', usertelp = '$usertelp' WHERE userid = '$id'";
      $result_update = mysqli_query($conn, $query_update);

      // Jika query berhasil dieksekusi, tampilkan notifikasi sukses
      if ($result_update) {
        echo "
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data karyawan berhasil diubah.',
            timer: 1000,
            showConfirmButton: false
          }).then(function() {
            window.location.href = '?page=users';
          });
        </script>
        ";
      } else {
        $pesan_error .= "Data gagal diubah!";
      }
    } else {
      $pesan_error .= "Data gagal diubah!";
    }
  }
} else {
  $pesan_error .= "Data tidak ditemukan.";
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
              <li class="breadcrumb-item active">Data Users</li>
              <li class="breadcrumb-item active">Edit User</li>
            </ol>
          </div>
          <h4 class="page-title">Edit Users</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">

        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                  <input type="hidden" name="userid" value="<?= $row['userid']; ?>">
                  <input class="form-control <?= ($pesan_error_user) ? 'is-invalid' : ''; ?>" type="text" id="example-text-input" name="username" placeholder="Masukkan username" autofocus required value="<?= $username; ?>" />
                  <div class="invalid-feedback">
                    <?= $pesan_error_user; ?>
                  </div>
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
                <div class="col-sm-10 offset-sm-2">
                  <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                  <a href="?page=users" class="btn btn-warning">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>