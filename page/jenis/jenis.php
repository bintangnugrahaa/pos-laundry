<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <!-- Breadcrumb untuk navigasi -->
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="?page=jenis">Laundry</a></li>
              <li class="breadcrumb-item active">Data Jenis Layanan</li>
            </ol>
          </div>
          <h4 class="page-title">Jenis Layanan</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">
              <!-- Tombol untuk tambah jenis layanan -->
              <h4 class="mt-0 header-title">
                <a href="?page=jenis&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Jenis Layanan</a>
              </h4>
              <!-- Tabel untuk menampilkan data jenis layanan -->
              <table id="datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Jenis Layanan</th>
                    <th>Lama Proses</th>
                    <th>Harga (per Kg)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Menampilkan data jenis laundry dari database
                  $query = "SELECT kd_jenis, jenis_laundry, lama_proses, tarif FROM tb_jenis";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) :
                  ?>
                    <tr>
                      <!-- Kolom untuk jenis layanan -->
                      <td><?= htmlspecialchars($row['jenis_laundry']); ?></td>
                      <!-- Kolom untuk lama proses -->
                      <td><?= htmlspecialchars($row['lama_proses']); ?> Hari</td>
                      <!-- Kolom untuk harga per Kg -->
                      <td>Rp. <?= number_format($row['tarif']); ?></td>
                      <!-- Kolom untuk aksi (edit dan hapus) -->
                      <td>
                        <a href="?page=jenis&aksi=ubah&id=<?= htmlspecialchars($row['kd_jenis']); ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger" onclick="confirmDelete(<?= htmlspecialchars($row['kd_jenis']); ?>)"><i class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Kolom untuk end col -->
    </div>
    <!-- Kolom untuk end row -->
    <!-- Kolom untuk end page title end breadcrumb -->
  </div>
  <!-- Kolom untuk end container -->
</div>

<script>
  // Fungsi untuk konfirmasi hapus data dengan SweetAlert2
  function confirmDelete(id) {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke halaman aksi hapus dengan membawa id jenis layanan
        window.location.href = `?page=jenis&aksi=hapus&id=${id}`;
      }
    })
  }
</script>