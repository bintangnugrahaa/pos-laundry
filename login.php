<?php
// Memulai sesi untuk menyimpan data pengguna yang login
session_start();

// Menyertakan file koneksi untuk menghubungkan ke database
include "include/koneksi.php";

// Inisialisasi variabel untuk pesan error
$pesan_error = "";

// Mengecek apakah tombol login sudah ditekan
if (isset($_POST['login'])) {
    // Memproses input username dan password dengan membersihkan dari karakter tidak aman
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $pass = htmlentities(strip_tags(trim($_POST["password"])));
    // Mengecek apakah checkbox "Remember Me" di centang
    $remember = isset($_POST['remember']);

    // Query untuk mendapatkan data user berdasarkan username
    $query = "SELECT * FROM tb_users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Mengecek apakah ada hasil query
    if ($result) {
        // Mendapatkan jumlah baris hasil query
        $cekUser = mysqli_num_rows($result);

        // Jika user ditemukan
        if ($cekUser > 0) {
            // Mendapatkan data user
            $row = mysqli_fetch_assoc($result);

            // Mengecek kecocokan password yang diinput dengan yang ada di database
            if (password_verify($pass, $row['userpass'])) {
                // Menyimpan data user ke sesi
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['level'] = $row['level'];
                $_SESSION['tgllogin'] = date('Y-m-d H:i:s');
                $_SESSION['login'] = true;

                // Jika checkbox "Remember Me" dicentang, menyimpan data user ke cookie
                if ($remember) {
                    setcookie('username', $username, time() + (86400 * 30), "/");
                    setcookie('userid', $row['userid'], time() + (86400 * 30), "/");
                    setcookie('level', $row['level'], time() + (86400 * 30), "/");
                } else {
                    // Jika tidak, menghapus cookie yang ada
                    if (isset($_COOKIE['username'])) {
                        setcookie('username', '', time() - 3600, "/");
                        setcookie('userid', '', time() - 3600, "/");
                        setcookie('level', '', time() - 3600, "/");
                    }
                }

                // Menampilkan pesan sukses menggunakan SweetAlert2 dan mengarahkan ke halaman index.php
                echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Login berhasil',
        showConfirmButton: false,
        timer: 1000
    }).then(() => {
        window.location.href = 'index.php';
    });
});
</script>
";
            } else {
                // Jika password salah, menambahkan pesan error
                $pesan_error .= "Username / Password anda salah";
            }
        } else {
            // Jika user tidak ditemukan, menambahkan pesan error
            $pesan_error .= "Username / Password anda salah";
        }
    } else {
        // Jika query tidak berhasil dieksekusi, menampilkan pesan error
        $pesan_error .= "Terjadi kesalahan dalam melakukan login";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="shortcut icon" href="assets/images/logo_sariwangi.png" type="image/png" />
    <title>Sariwangi Laundry - Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <section class="vh-100" style="background-image: url('assets/images/washing-machine.gif'); background-size: cover; background-position: center;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="assets/images/login.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;">
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post" action="login.php">
                                        <div class="centered">
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <img src="assets/images/logo_sariwangi.png" alt="Logo Sariwangi Laundry" style="height: 100px; padding-left: 4rem;">
                                            </div>
                                        </div>
                                        <hr style="height: 1.5px; background-color: black; border: none;">
                                        <?php if (!empty($pesan_error)) : ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?= $pesan_error ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control form-control-lg" required>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                                        </div>
                                        <div class="pt-1 mb-4">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>