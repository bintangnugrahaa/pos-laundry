<?php
// Memanggil koneksi
include "include\koneksi.php";

// Inisialisasi variabel
$pesan_error = "";
$pelangganid = "";
$jenis = "";
$tarif = "";
$tgl_selesai = "";
$jml_kilo = "";
$totalbayar = "";
$catatan = "";
$status = "";

// Jika tombol tambah ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {

  // Fungsi untuk membersihkan dan sanitasi input
  function clean_input($conn, $data)
  {
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
  }

  // Mengambil data dari form dan membersihkan input
  $idlaundry = clean_input($conn, $_POST['id_laundry']);
  $pelangganid = clean_input($conn, $_POST["pelangganid"]);
  $userid = clean_input($conn, $_SESSION['userid']);
  $jenis = clean_input($conn, $_POST["id_jenis"]);
  $tarif = clean_input($conn, $_POST["tarif"]);
  $tgl_selesai = clean_input($conn, $_POST["tgl_selesai"]);
  $jml_kilo = clean_input($conn, $_POST["jml_kilo"]);
  $totalbayar = clean_input($conn, $_POST["totalbayar"]);
  $catatan = clean_input($conn, $_POST["catatan"]);
  $status = clean_input($conn, $_POST["status"]);
  $status_pengambilan = 0;
  $tgl_terima = date('Y-m-d');
  $ket_laporan = 1;
  $pengeluaran = 0;

  // Query untuk input data transaksi ke tabel tb_laundry
  $query = "INSERT INTO `tb_laundry` (`id_laundry`, `pelangganid`, `userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`, `status_pengambilan`) 
            VALUES ('$idlaundry', '$pelangganid', '$userid', '$jenis', '$tgl_terima', '$tgl_selesai', '$jml_kilo', '$catatan', '$totalbayar', '$status', '$status_pengambilan')";

  // Eksekusi query
  $result = mysqli_query($conn, $query);

  // Jika transaksi sudah lunas, tambahkan data ke tabel tb_laporan
  if ($status == 1) {
    // Query untuk input data ke tb_laporan
    $insert_query = "INSERT INTO `tb_laporan` (`tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `pengeluaran`) 
                     VALUES ('$tgl_terima', '$ket_laporan', '$catatan', '$idlaundry', '$totalbayar', '$pengeluaran')";

    // Eksekusi query
    $result_insert = mysqli_query($conn, $insert_query);
  }

  // Tampilkan pesan sukses jika query berhasil dijalankan
  if ($result) {
    echo "
        <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Transaksi laundry berhasil ditambahkan.',
          timer: 1000,
          showConfirmButton: false
        }).then(function() {
          window.location.href = '?page=laundry';
        });
        </script>
        ";
  } else {
    $pesan_error .= "Data gagal disimpan!";
  }
}
?>

<!-- HTML Form untuk input data transaksi -->
<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <!-- Breadcrumb untuk navigasi -->
          <div class="btn-group float-right">
            <ol class="breadcrumb hide-phone p-0 m-0">
              <li class="breadcrumb-item"><a href="?page=laundry">Laundry</a></li>
              <li class="breadcrumb-item active"><a href="?page=laundry">Data Transaksi Laundry</a></li>
              <li class="breadcrumb-item active">Tambah Transaksi Laundry</li>
            </ol>
          </div>
          <h4 class="page-title">Tambah Transaksi Laundry</h4>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Tampilkan pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

        <!-- Form untuk input data transaksi -->
        <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <!-- Input hidden untuk userid -->
              <input type="hidden" name="userid" value=<?= $_SESSION['userid']; ?>>

              <?php
              // Mencari id_laundry otomatis
              $q = mysqli_query($conn, "SELECT MAX(RIGHT(id_laundry,4)) AS kd_max FROM tb_laundry");
              $jml = mysqli_num_rows($q);
              $kd = "";
              if ($jml > 0) {
                while ($result = mysqli_fetch_assoc($q)) {
                  $tmp = ((int) $result['kd_max']) + 1;
                  $kd = sprintf("%04s", $tmp);
                }
              } else {
                $kd = "0001";
              }
              $id_laundry = 'LD-' . $kd;
              ?>
              <!-- Input hidden untuk id_laundry -->
              <input type="hidden" name="id_laundry" value="<?= $id_laundry; ?>">

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-10">
                  <!-- Select untuk memilih pelanggan -->
                  <select name="pelangganid" class="select2 form-control">
                    <?php
                    $query2 = mysqli_query($conn, "SELECT * FROM tb_pelanggan");
                    while ($pelanggan = mysqli_fetch_assoc($query2)) :
                      $selected = ($pelanggan['pelangganid'] == $pelangganid) ? 'selected' : '';
                    ?>
                      <option value="<?= $pelanggan['pelangganid']; ?>" <?= $selected; ?>><?= $pelanggan['pelanggannama']; ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Jenis Laundry</label>
                <div class="col-sm-10">
                  <!-- Select untuk memilih jenis laundry -->
                  <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="id_jenis" id="id_jenis" onchange="jenis();">
                    <option>--Pilih jenis---</option>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM tb_jenis");
                    while ($result = mysqli_fetch_assoc($query)) :
                      $selected = ($result['kd_jenis'] == $jenis) ? 'selected' : '';
                    ?>
                      <option value="<?= $result['kd_jenis']; ?>" <?= $selected; ?>><?= $result['jenis_laundry']; ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Tarif (Hari)</label>
                <div class="col-sm-10">
                  <!-- Input untuk menampilkan tarif -->
                  <input class="form-control" type="text" id="tarif" name="tarif" value="<?= $tarif; ?>" required readonly />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Tgl. Selesai</label>
                <div class="col-sm-10">
                  <!-- Input untuk menampilkan tanggal selesai -->
                  <input class="form-control" type="text" id="tgl_selesai" name="tgl_selesai" value="<?= $tgl_selesai; ?>" required readonly />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-number-input" class="col-sm-2 col-form-label">Jumlah (Kg)</label>
                <div class="col-sm-10">
                  <!-- Input untuk memasukkan berat laundry -->
                  <input class="form-control" type="number" id="jml_kilo" name="jml_kilo" value="<?= $jml_kilo; ?>" onkeyup="sum();" required />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-number-input" class="col-sm-2 col-form-label">Total Bayar</label>
                <div class="col-sm-10">
                  <!-- Input untuk menampilkan total bayar -->
                  <input class="form-control" type="number" value="<?= $totalbayar; ?>" id="totalbayar" name="totalbayar" readonly required />
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10">
                  <!-- Textarea untuk memasukkan catatan -->
                  <textarea class="form-control" id="example-text-input" name="catatan" cols="20" rows="5" placeholder="Masukkan catatan" required><?= $catatan; ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <!-- Select untuk memilih status pembayaran -->
                  <select name="status" class="select2 form-control">
                    <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Belum lunas</option>
                    <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Lunas</option>
                  </select>
                </div>
              </div>

              <!-- Tombol untuk submit form dan kembali -->
              <div class="form-group row">
                <div class="col-sm-12 text-right">
                  <button type="submit" name="tambah" class="btn btn-primary mt-4">Tambah</button>
                  <a href="?page=laundry" class="btn btn-warning mt-4">Kembali</a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</div>

<!-- JavaScript untuk menghitung total bayar dan autofill -->
<script>
  // Fungsi untuk menghitung total bayar berdasarkan berat laundry dan tarif
  function sum() {
    var jmlKilo = document.getElementById('jml_kilo').value;
    var tarif = document.getElementById('tarif').value;

    // Menghitung total bayar
    var total = parseInt(jmlKilo) * parseInt(tarif);

    // Memeriksa apakah hasilnya adalah angka
    if (!isNaN(total)) {
      document.getElementById('totalbayar').value = total;
    } else {
      document.getElementById('totalbayar').value = '';
    }
  }

  // Fungsi untuk autofill tarif dan tanggal selesai berdasarkan jenis laundry yang dipilih
  function jenis() {
    var id = $("#id_jenis").val();

    // Menggunakan AJAX untuk mengambil data dari autofill.php
    $.ajax({
      url: "page/laundry/autofill.php",
      data: 'idjenis=' + id,
      success: function(data) {
        var json = data,
          obj = JSON.parse(json);

        // Jika sukses mendapatkan data, mengisi nilai tarif dan tanggal selesai
        if (obj.sukses) {
          $('#tarif').val(obj.sukses.tarif);
          $('#tgl_selesai').val(obj.sukses.tgl_selesai);
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        } else if (obj.gagal) {
          // Jika gagal, mengosongkan nilai tarif dan tanggal selesai
          $('#tarif').val('');
          $('#tgl_selesai').val('');
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        }
      }
    });
  }
</script>