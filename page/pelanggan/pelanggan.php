<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <!-- Breadcrumb untuk navigasi -->
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Data Pelanggan</li>
            </ol>
          </div>
          <h4 class="page-title">Data Pelanggan</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">
              <h4 class="mt-0 header-title">
                <!-- Tombol untuk tambah data pelanggan -->
                <a href="?page=pelanggan&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Pelanggan</a>
              </h4>
              <table id="datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query untuk menampilkan data pelanggan
                  $query = "SELECT * FROM tb_pelanggan ORDER BY pelangganid DESC";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) :
                  ?>
                    <tr>
                      <td><?= htmlspecialchars($row['pelanggannama']); ?></td>
                      <td><?= htmlspecialchars($row['pelangganalamat']); ?></td>
                      <td><?= htmlspecialchars($row['pelanggantelp']); ?></td>
                      <td>
                        <!-- Tombol untuk ubah dan hapus data pelanggan -->
                        <a href="?page=pelanggan&aksi=ubah&id=<?= $row['pelangganid']; ?>" class="btn btn-warning mb-2"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger mb-2" onclick="confirmDelete(<?= $row['pelangganid']; ?>)"><i class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
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

<script>
  // Fungsi untuk konfirmasi penghapusan data pelanggan
  function confirmDelete(id) {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect ke halaman untuk menghapus data pelanggan
        window.location.href = `?page=pelanggan&aksi=hapus&id=${id}`;
      }
    })
  }
</script>