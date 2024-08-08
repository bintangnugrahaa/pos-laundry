<div class="page-content-wrapper">
  <div class="container-fluid">

    <!-- Bagian Judul Halaman dan Breadcrumb -->
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Data Transaksi Laundry</li>
            </ol>
          </div>
          <h4 class="page-title">Data Transaksi Laundry Belum Lunas</h4>
        </div>
      </div>
    </div>
    <!-- Akhir Bagian Judul Halaman dan Breadcrumb -->

    <!-- Bagian Tabel Data Transaksi -->
    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">
              <h4 class="mt-0 header-title">
                <a href="?page=laundry&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Transaksi Laundry</a>
              </h4>
              <h4 class="mt-0 header-title">
                <a href="?page=laundry&aksi=laundrylunas" class="btn btn-success">Status Lunas</a>
                <a href="?page=laundry&aksi=laundrybelumlunas" class="btn btn-danger disabled">Status Belum Lunas</a>
              </h4>
              <table id="datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Pelanggan</th>
                    <th>Jenis Layanan</th>
                    <th>Tgl. Terima</th>
                    <th>Tgl. Selesai</th>
                    <th>Status</th>
                    <th>Status Baju</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query untuk menampilkan data transaksi yang belum lunas
                  $query = "SELECT * FROM `tb_laundry` 
                            INNER JOIN `tb_pelanggan` ON `tb_laundry`.`pelangganid` = `tb_pelanggan`.`pelangganid` 
                            INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` 
                            INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` 
                            WHERE `tb_laundry`.`status_pembayaran` = 0";
                  $result = mysqli_query($conn, $query); ?>
                  <?php $i = 1; ?>
                  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                      <td><?= $row['pelanggannama']; ?></td>
                      <td><?= $row['jenis_laundry']; ?></td>
                      <td><?= $row['tgl_terima']; ?></td>
                      <td><?= $row['tgl_selesai']; ?></td>
                      <td><?= ($row['status_pembayaran'] == 1) ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-danger">Belum lunas</span>'; ?></td>
                      <td>
                        <?php if ($row['status_pengambilan'] == 0) { ?>
                          <a href="?page=laundry&aksi=diambil&id=<?= $row['id_laundry']; ?>" class="btn btn-danger pickup-btn <?= ($row['status_pembayaran'] == 0) ? 'disabled' : ''; ?>" data-id="<?= $row['id_laundry']; ?>">Belum diambil</a>
                        <?php } elseif ($row['status_pengambilan'] == 1) { ?>
                          <a href="#" class="btn btn-warning disabled">Sudah diambil</a>
                        <?php } ?>
                      </td>
                      <td>Rp. <?= number_format($row['totalbayar']); ?></td>
                      <td>
                        <?php if ($row['status_pembayaran'] == 1) { ?>
                          <a href="?page=laundry&aksi=detail&id=<?= $row['id_laundry']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                        <?php } elseif ($row['status_pembayaran'] == 0) { ?>
                          <a href="?page=laundry&aksi=detail&id=<?= $row['id_laundry']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                          <a href="?page=laundry&aksi=lunasi&id=<?= $row['id_laundry']; ?>" class="btn btn-success payoff-btn" data-id="<?= $row['id_laundry']; ?>"><i class="fa fa-money"></i></a>
                          <a href="?page=laundry&aksi=hapus&id=<?= $row['id_laundry']; ?>" class="btn btn-danger delete-btn" data-id="<?= $row['id_laundry']; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- Akhir Bagian Tabel Data Transaksi -->

  </div>
  <!-- container -->
</div>

<script>
  // Ambil semua anchor dengan kelas 'pickup-btn'
  const pickupButtons = document.querySelectorAll('.pickup-btn');

  // Loop melalui setiap anchor dan tambahkan event listener untuk setiap anchor
  pickupButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      // Jika tombol dalam keadaan disabled, tidak melakukan apa-apa
      if (this.classList.contains('disabled')) {
        return;
      }

      event.preventDefault(); // Mencegah perilaku default dari tautan

      const id = this.getAttribute('data-id'); // Ambil id dari data-id attribute

      // Tampilkan konfirmasi SweetAlert
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Apakah anda yakin Baju sudah diambil?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sudah Diambil',
        cancelButtonText: 'Belum'
      }).then((result) => {
        // Jika tombol konfirmasi ditekan
        if (result.isConfirmed) {
          // Redirect ke URL yang sesuai untuk menandai baju sebagai sudah diambil
          window.location.href = `?page=laundry&aksi=diambil&id=${id}`;
        }
      });
    });
  });

  // Ambil semua anchor dengan kelas 'payoff-btn'
  const payoffButtons = document.querySelectorAll('.payoff-btn');

  // Loop melalui setiap anchor dan tambahkan event listener untuk setiap anchor
  payoffButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Mencegah perilaku default dari tautan

      const id = this.getAttribute('data-id'); // Ambil id dari data-id attribute

      // Tampilkan konfirmasi SweetAlert
      Swal.fire({
        title: 'Anda yakin?',
        text: "Transaksi ini sudah dilunasi?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Lunas',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        // Jika tombol konfirmasi ditekan
        if (result.isConfirmed) {
          // Redirect ke URL yang sesuai untuk menandai transaksi sebagai lunas
          window.location.href = `?page=laundry&aksi=lunasi&id=${id}`;
        }
      });
    });
  });

  // Ambil semua anchor dengan kelas 'delete-btn'
  const deleteButtons = document.querySelectorAll('.delete-btn');

  // Loop melalui setiap anchor dan tambahkan event listener untuk setiap anchor
  deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Mencegah perilaku default dari tautan

      const id = this.getAttribute('data-id'); // Ambil id dari data-id attribute

      // Tampilkan konfirmasi SweetAlert
      Swal.fire({
        title: 'Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        // Jika tombol konfirmasi ditekan
        if (result.isConfirmed) {
          // Redirect ke URL yang sesuai untuk menghapus data
          window.location.href = `?page=laundry&aksi=hapus&id=${id}`;
        }
      });
    });
  });
</script>