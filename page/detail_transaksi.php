<?php

// Ambil id_laundry dari URL
$id_laundry = $_GET['id'];

// Query untuk mengambil data transaksi laundry
$query = "SELECT * FROM tb_laundry 
          INNER JOIN tb_pelanggan ON tb_laundry.pelangganid = tb_pelanggan.pelangganid
          INNER JOIN tb_users ON tb_users.userid = tb_laundry.userid
          INNER JOIN tb_jenis ON tb_jenis.kd_jenis = tb_laundry.kd_jenis
          WHERE tb_laundry.id_laundry = '$id_laundry'";
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
              <li class="breadcrumb-item active">Detail Transaksi Laundry</li>
            </ol>
          </div>
          <h4 class="page-title">Detail Transaksi Laundry</h4>
        </div>
      </div>
    </div>

    <!-- Isi Konten -->
    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <!-- Informasi Umum -->
            <p>
              <b>Tanggal : </b> <?= htmlspecialchars(date('Y-m-d')); ?>
            </p>

            <!-- Detail Informasi Transaksi -->
            <table class="table table-bordered">
              <tr>
                <th>No. Order</th>
                <td><?= htmlspecialchars($row['id_laundry']); ?></td>
              </tr>
              <tr>
                <th>Pelanggan</th>
                <td><?= htmlspecialchars($row['pelanggannama']); ?></td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td><?= htmlspecialchars($row['pelangganalamat']); ?></td>
              </tr>
              <tr>
                <th>No. Telp</th>
                <td><?= htmlspecialchars($row['pelanggantelp']); ?></td>
              </tr>
              <tr>
                <th>Tanggal Selesai</th>
                <td><?= htmlspecialchars($row['tgl_selesai']); ?></td>
              </tr>
              <tr>
                <th>Catatan Laundry</th>
                <td><?= htmlspecialchars($row['catatan']); ?></td>
              </tr>
              <tr>
                <th>Status Pembayaran</th>
                <td><?= ($row['status_pembayaran'] == 1) ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-danger">Belum Lunas</span>'; ?></td>
              </tr>
              <tr>
                <th>Status Pengambilan Baju</th>
                <td><?= ($row['status_pengambilan'] == 1) ? '<span class="badge badge-success">Sudah Diambil</span>' : '<span class="badge badge-danger">Belum Diambil</span>'; ?></td>
              </tr>
              <tr>
                <th>Kasir</th>
                <td><?= htmlspecialchars($row['nama']); ?></td>
              </tr>
            </table>

            <!-- Detail Transaksi Laundry -->
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Tanggal Terima</th>
                    <th>Jenis Layanan</th>
                    <th>Tanggal Selesai</th>
                    <th>Berat Cucian</th>
                    <th>Harga/Kg</th>
                    <th>Total Bayar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= htmlspecialchars($row['tgl_terima']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_laundry']); ?></td>
                    <td><?= htmlspecialchars($row['tgl_selesai']); ?></td>
                    <td><?= htmlspecialchars($row['jml_kilo']); ?> Kg</td>
                    <td>Rp. <?= number_format($row['tarif']); ?></td>
                    <td>Rp. <?= number_format($row['totalbayar']); ?></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5" style="text-align: center;">TOTAL PESANAN</th>
                    <th>Rp. <?= number_format($row['totalbayar']); ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- Tombol Aksi -->
            <a href="page/cetak_transaksi.php?id=<?= htmlspecialchars($row['id_laundry']); ?>" class="btn btn-primary" target="_blank">Cetak Invoice</a>
            <a href="?page=laundry" class="btn btn-warning">Kembali</a>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

  </div>
  <!-- container -->
</div>