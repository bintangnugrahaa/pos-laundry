<?php
// Menggunakan koneksi.php untuk mengakses database
include "../include/koneksi.php";

// Ambil id laundry dari URL
$id_laundry = $_GET['id'];

// Query untuk mendapatkan data transaksi laundry beserta detailnya
$query = "SELECT * 
          FROM tb_laundry 
          INNER JOIN tb_pelanggan ON tb_laundry.pelangganid = tb_pelanggan.pelangganid 
          INNER JOIN tb_users ON tb_users.userid = tb_laundry.userid 
          INNER JOIN tb_jenis ON tb_jenis.kd_jenis = tb_laundry.kd_jenis 
          WHERE tb_laundry.id_laundry = '$id_laundry'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Menutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice <?= htmlspecialchars($row['id_laundry']); ?></title>
  <link rel="shortcut icon" href="../assets/images/sariwangi_logo.png" type="image/png" />
  <link href="../assets/plugins/morris/morris.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body onload="window.print()">
  <!-- Logo dan Informasi Laundry -->
  <img src="../assets/images/sariwangi_logo.png" alt="Sariwangi Logo" width="100px" style="margin-bottom: 10px;">
  <table width='100%'>
    <tr>
      <td>
        Jl. Sirsak Jakarta Selatan <br>
        No. Hp / WA : 0813 1676 8382 <br>
        Email : sariwangilaundry@gmail.com <br>
        Jam Operasional : Senin - Minggu : 08.00 - 19.00 WIB
      </td>
      <td align="right">
        <p style="text-align: right;"> <b>Tanggal : </b> <?= date('Y-m-d H:i:s'); ?></p>
      </td>
    </tr>
  </table>
  <hr style="border:0; border-top: 5px double #8c8c8c;">

  <!-- Detail Transaksi -->
  <table>
    <tr>
      <th align="left">No. Order</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['id_laundry']); ?></td>
    </tr>
    <tr>
      <th align="left">Nama Pelanggan</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['pelanggannama']); ?></td>
    </tr>
    <tr>
      <th align="left">Alamat</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['pelangganalamat']); ?></td>
    </tr>
    <tr>
      <th align="left">No. Telp</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['pelanggantelp']); ?></td>
    </tr>
    <tr>
      <th align="left">Tanggal Selesai</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['tgl_selesai']); ?></td>
    </tr>
    <tr>
      <th align="left">Catatan Laundry</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['catatan']); ?></td>
    </tr>
    <tr>
      <th align="left">Status Pembayaran</th>
      <td>:</td>
      <td><?= ($row['status_pembayaran'] == 1) ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-danger">Belum Lunas</span>'; ?></td>
    </tr>
    <tr>
      <th align="left">Status Pengambilan Baju</th>
      <td>:</td>
      <td><?= ($row['status_pengambilan'] == 1) ? '<span class="badge badge-success">Sudah Diambil</span>' : '<span class="badge badge-danger">Belum Diambil</span>'; ?></td>
    </tr>
    <tr>
      <th align="left">Kasir</th>
      <td>:</td>
      <td><?= htmlspecialchars($row['nama']); ?></td>
    </tr>
  </table>
  <br>

  <!-- Detail Layanan Laundry -->
  <table width='100%' cellpadding='5' cellspacing='0' border="1">
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

  <!-- Syarat dan Ketentuan -->
  <h3>Perhatian :</h3>
  <ol>
    <li>Pengambilan barang harus disertai nota dan dibayar lunas</li>
    <li>Nota ini berlaku 40 hari dari tanggal diberikan nota</li>
    <li>Kami tidak bertanggung jawab atas luntur atau kusut bahan</li>
    <li>Kami bertanggung jawab atas kerusakan atau kehilangan</li>
    <li>Claim hanya berlaku 1x24 jam setelah pengambilan laundry</li>
    <li>Konsumen dianggap setuju dengan isi perjanjian di atas</li>
  </ol>

  <script src="../assets/plugins/datatables/vfs_fonts.js"></script>
</body>

</html>