<?php
// Include koneksi.php untuk mengakses database
include "../include/koneksi.php";

// Ambil id_pengeluaran dari URL
$id_pengeluaran = $_GET['id'];

// Query untuk mengambil data pengeluaran berdasarkan id_pengeluaran
$query = "SELECT * FROM tb_pengeluaran WHERE id_pengeluaran = '$id_pengeluaran'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Menutup koneksi
mysqli_close($conn);
?>

<!-- Struktur HTML -->
<div class="page-content-wrapper">
  <div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Detail Pengeluaran Laundry</li>
            </ol>
          </div>
          <h4 class="page-title">Detail Pengeluaran Laundry</h4>
        </div>
      </div>
    </div>

    <!-- Isi Konten -->
    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <!-- Tanggal Sekarang -->
            <p>
              <b>Tanggal : </b> <?= htmlspecialchars(date('Y-m-d')); ?>
            </p>

            <!-- Tabel Detail Pengeluaran -->
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Tanggal Pengeluaran</th>
                    <th>Catatan</th>
                    <th>Pengeluaran</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= htmlspecialchars($row['tgl_pengeluaran']); ?></td>
                    <td><?= htmlspecialchars($row['catatan']); ?></td>
                    <td>Rp. <?= number_format($row['pengeluaran']); ?></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="2" style="text-align: center;">TOTAL PENGELUARAN</th>
                    <th>Rp. <?= number_format($row['pengeluaran']); ?></th>
                  </tr>
                </tfoot>
              </table>

              <!-- Tombol Aksi -->
              <a href="page/cetak_pengeluaran.php?id=<?= htmlspecialchars($row['id_pengeluaran']); ?>" class="btn btn-primary" target="_blank">Cetak Pengeluaran</a>
              <a href="?page=pengeluaran" class="btn btn-warning">Kembali</a>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

  </div>
  <!-- container -->
</div>