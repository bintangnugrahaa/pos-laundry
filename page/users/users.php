<div class="page-content-wrapper">
  <div class="container-fluid">
    <!-- Bagian Header -->
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <!-- Navigasi Breadcrumb -->
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Data Karyawan</li>
            </ol>
          </div>
          <!-- Judul Halaman -->
          <h4 class="page-title">Data Karyawan</h4>
        </div>
      </div>
    </div>

    <!-- Bagian Konten Utama -->
    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">
              <!-- Bagian Tombol Tambah Data -->
              <h4 class="mt-0 header-title">
                <a href="?page=users&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Tambah Data Karyawan</a>
              </h4>
              <!-- Tabel Data Karyawan -->
              <table id="datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Loop PHP untuk Menampilkan Data Karyawan -->
                  <?php
                  $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE level != 'admin' ORDER BY userid DESC");
                  while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                      <!-- Kolom Foto -->
                      <th>
                        <!-- Menampilkan Foto jika Ada -->
                        <?php if ($row['userfoto'] != NULL && $row['userfoto'] != "") { ?>
                          <a href="<?= $row['userfoto']; ?>" target="_blank"><img src="fotouser/<?= $row['userfoto']; ?>" style="width: 120px;"></a>
                        <?php } ?>
                      </th>
                      <!-- Kolom Data -->
                      <td><?= $row['username']; ?></td>
                      <td><?= $row['nama']; ?></td>
                      <td><?= $row['alamat']; ?></td>
                      <td><?= $row['usertelp']; ?></td>
                      <!-- Kolom Aksi (Edit dan Hapus) -->
                      <td>
                        <a href="?page=users&aksi=ubah&id=<?= $row['userid']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger" onclick="confirmDelete(<?= $row['userid']; ?>)"><i class="fa fa-trash-o"></i></button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // Fungsi untuk Konfirmasi Penghapusan
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
        // Mengarahkan ke Halaman Penghapusan dengan ID
        window.location.href = `?page=users&aksi=hapus&id=${id}`;
      }
    })
  }
</script>