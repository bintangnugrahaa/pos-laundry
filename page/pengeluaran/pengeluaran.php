<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="#">Laundry</a></li>
              <li class="breadcrumb-item active">Data Pengeluaran</li>
            </ol>
          </div>
          <h4 class="page-title">Data Pengeluaran</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">
              <h4 class="mt-0 header-title">
                <a href="?page=pengeluaran&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Pengeluaran</a>
                <a href="" class="btn btn-primary" style="margin-left: 59.2rem;" onclick="printContent('pengeluaran');"><i class="fa fa-download"></i> Cetak Pengeluaran</a>
              </h4>

              <!-- Daftar Pengeluaran -->
              <div id="pengeluaran" class="">
                <table id="datatable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Catatan</th>
                      <th>Pengeluaran</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Loop PHP untuk menampilkan data pengeluaran -->
                    <?php
                    $query = "SELECT * FROM tb_pengeluaran";
                    $result = mysqli_query($conn, $query); ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                      <tr>
                        <td><?= $row['tgl_pengeluaran']; ?></td>
                        <td><?= $row['catatan']; ?></td>
                        <td>Rp. <?= number_format($row['pengeluaran']); ?></td>
                        <td>
                          <!-- Tombol Aksi -->
                          <a href="?page=pengeluaran&aksi=ubah&id=<?= $row['id_pengeluaran']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                          <a href="?page=pengeluaran&aksi=hapus&id=<?= $row['id_pengeluaran']; ?>" class="btn btn-danger delete-btn" data-id="<?= $row['id_pengeluaran']; ?>"><i class="fa fa-trash-o"></i></a>
                          <a href="page/cetak_pengeluaran.php?id=<?= $row['id_pengeluaran']; ?>" class="btn btn-primary"><i class="fa fa-download"></i></a>
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
</div>
<script>
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
          window.location.href = `?page=pengeluaran&aksi=hapus&id=${id}`;
        }
      });
    });
  });

  // Fungsi untuk mencetak konten laporan
  function printContent(el) {
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
  }
</script>