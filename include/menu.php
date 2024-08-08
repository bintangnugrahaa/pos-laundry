<div id="sidebar-menu">
  <ul>
    <!-- Judul Menu -->
    <li class="menu-title">Sariwangi Laundry</li>

    <!-- Menu Dashboard -->
    <li>
      <a href="index.php" class="waves-effect">
        <i class="mdi mdi-airplay"></i><span> Dashboard</span>
      </a>
    </li>

    <!-- Menu Data Karyawan (Hanya untuk Admin) -->
    <?php if ($_SESSION['level'] == 'admin') : ?>
      <?php
      // Menghitung jumlah data karyawan kecuali admin
      $dataUser = mysqli_query($conn, "SELECT * FROM tb_users WHERE level != 'admin'");
      $jmlDataUser = mysqli_num_rows($dataUser);
      ?>
      <li>
        <a href="?page=users" class="waves-effect">
          <i class="fa fa-users"></i>
          <span>Data Karyawan<span class="badge badge-pill badge-primary float-right"><?= $jmlDataUser; ?></span></span>
        </a>
      </li>

      <!-- Menu Jenis Layanan -->
      <?php
      // Menghitung jumlah data jenis layanan
      $jenis = mysqli_query($conn, "SELECT * FROM tb_jenis");
      $jmljenis = mysqli_num_rows($jenis);
      ?>
      <li>
        <a href="?page=jenis" class="waves-effect">
          <i class="fa fa-shopping-basket"></i>
          <span>Jenis Layanan<span class="badge badge-pill badge-primary float-right"><?= $jmljenis; ?></span></span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Menu Data Pelanggan (Hanya untuk Admin dan Kasir) -->
    <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'kasir') : ?>
      <?php
      // Menghitung jumlah data pelanggan
      $dataPelanggan = mysqli_query($conn, "SELECT * FROM tb_pelanggan");
      $jmlDataPelanggan = mysqli_num_rows($dataPelanggan);
      ?>
      <li>
        <a href="?page=pelanggan" class="waves-effect">
          <i class="fa fa-user"></i>
          <span>Data Pelanggan<span class="badge badge-pill badge-primary float-right"><?= $jmlDataPelanggan; ?></span></span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Menu Transaksi Laundry -->
    <?php
    // Menghitung jumlah data transaksi laundry
    $laundry = mysqli_query($conn, "SELECT * FROM tb_laundry");
    $jmllaundry = mysqli_num_rows($laundry);
    ?>
    <li>
      <a href="?page=laundry" class="waves-effect">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi Laundry<span class="badge badge-pill badge-primary float-right"><?= $jmllaundry; ?></span></span>
      </a>
    </li>

    <!-- Menu Data Pengeluaran -->
    <?php
    // Menghitung jumlah data pengeluaran
    $pengeluaran = mysqli_query($conn, "SELECT * FROM tb_pengeluaran");
    $jmlpengeluaran = mysqli_num_rows($pengeluaran);
    ?>
    <li>
      <a href="?page=pengeluaran" class="waves-effect">
        <i class="fa fa-money"></i>
        <span>Data Pengeluaran<span class="badge badge-pill badge-primary float-right"><?= $jmlpengeluaran; ?></span></span>
      </a>
    </li>

    <!-- Menu Data Laporan -->
    <?php
    //  Menghitung jumlah data laporan
    $laporan = mysqli_query($conn, "SELECT * FROM tb_laporan");
    $jmllaporan = mysqli_num_rows($laporan);
    ?>
    <li>
      <a href="?page=laporan" class="waves-effect">
        <i class="fa fa-book"></i>
        <span>Data Laporan<span class="badge badge-pill badge-primary float-right"><?= $jmllaporan; ?></span></span>
      </a>
    </li>

    <!-- Menu Logout dengan SweetAlert2 -->
    <li>
      <a href="#" id="logout" class="waves-effect">
        <i class="mdi mdi-logout m-r-5 text-muted"></i>
        <span>Logout</span>
      </a>
    </li>

  </ul>
</div>

<script>
  // Event listener untuk link Logout dengan SweetAlert2
  document.getElementById('logout').addEventListener('click', function(e) {
    e.preventDefault(); // Menghentikan default action dari link

    // Tampilkan SweetAlert2 untuk konfirmasi logout
    Swal.fire({
      title: 'Apakah anda ingin logout?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, logout',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke login.php jika konfirmasi dilakukan
        window.location.href = 'login.php';
      }
    });
  });
</script>