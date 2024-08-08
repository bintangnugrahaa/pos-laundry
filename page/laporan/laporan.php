<?php

// Inisialisasi variabel untuk total masuk, keluar, dan saldo
$masuk = 0;
$keluar = 0;
$total = 0;

// Koneksi ke database (asumsikan variabel $conn sudah terhubung)

// Jika mencari data berdasarkan tanggal
if (isset($_POST['cari'])) {
  // Ambil tanggal awal dan akhir dari form
  $tglAwal = $_POST['tanggalawal'];
  $tglAkhir = $_POST['tanggalakhir'];

  // Query untuk mencari data transaksi dalam rentang tanggal tertentu
  $query = "SELECT tb_laporan.*, tb_laundry.id_laundry, tb_laundry.totalbayar 
              FROM tb_laporan 
              LEFT JOIN tb_laundry ON tb_laporan.id_laundry = tb_laundry.id_laundry 
              WHERE tb_laporan.tgl_laporan BETWEEN '$tglAwal' AND '$tglAkhir'";
  $result = mysqli_query($conn, $query);
} else {
  // Jika tidak mencari, tampilkan semua data transaksi
  $query = "SELECT * FROM tb_laporan";
  $result = mysqli_query($conn, $query);
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
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Data Laporan</li>
            </ol>
          </div>
          <h4 class="page-title">Data Laporan</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">

            <!-- Form untuk pencarian berdasarkan tanggal -->
            <form class="form-inline mr-auto w-100 navbar-search" action="" method="POST">
              <div class="input-group">
                <label for="" class="form-control-label">Tanggal Awal</label>
                <input type="date" class="form-control bg-light border-0 small ml-3 mr-3" name="tanggalawal" id="tanggalawal" required>

                <label for="" class="form-control-label">Tanggal Akhir</label>
                <input type="date" class="form-control bg-light border-0 small ml-3" name="tanggalakhir" id="tanggalakhir" required>

                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit" name="cari">
                    <i class="fa fa-search fa-sm"></i> Cari
                  </button>
                </div>
              </div>
            </form>

            <div class="table-responsive">
              <h4 class="mt-0 header-title" style="text-align: right;">
                <!-- Tombol untuk cetak laporan -->
                <a href="" class="btn btn-primary mt-2" onclick="printContent('laporan');"><i class="fa fa-download"></i> Cetak
                  Laporan</a>
              </h4>

              <div class="" id="laporan">
                <h4 class="mt-0 header-title" style="text-align: center;">Data Laporan Pemasukan dan
                  Pengeluaran</h4>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                      <th>Catatan</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Menghitung total pemasukan dan pengeluaran
                    while ($row = mysqli_fetch_assoc($result)) :
                      $masuk += $row['pemasukan'];
                      $keluar += $row['pengeluaran'];
                    ?>
                      <tr>
                        <td><?= htmlspecialchars($row['tgl_laporan']); ?></td>
                        <td><?= ($row['ket_laporan'] == 1 ? 'Pemasukan' : 'Pengeluaran'); ?></td>
                        <td><?= htmlspecialchars($row['catatan']); ?></td>
                        <td>Rp. <?= number_format($row['pemasukan']); ?></td>
                        <td>Rp. <?= number_format($row['pengeluaran']); ?></td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3" style="text-align: center;">Total Pemasukan dan
                        Pengeluaran</th>
                      <td>Rp. <?= number_format($masuk); ?></td>
                      <td>Rp. <?= number_format($keluar); ?></td>
                    </tr>
                    <tr>
                      <th colspan="3" style="text-align: center;">Saldo Akhir</th>
                      <td colspan="2">Rp. <?= number_format($masuk - $keluar); ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  <!-- end container-fluid -->
</div>
<!-- end page-content-wrapper -->

<script>
  // Fungsi untuk mencetak konten laporan
  function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
  }
</script>