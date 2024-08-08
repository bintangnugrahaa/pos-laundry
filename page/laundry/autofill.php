<?php
// Memanggil koneksi
include "../../include/koneksi.php";

// Inisialisasi variabel untuk menampung data
$data = [];

// Menangkap dan membersihkan data idjenis dari laundry/tambah.php
$idjenis = isset($_GET['idjenis']) ? mysqli_real_escape_string($conn, $_GET['idjenis']) : '';

if (!empty($idjenis)) {
  // Query untuk mengambil data jenis laundry berdasarkan kd_jenis
  $query = "SELECT * FROM tb_jenis WHERE kd_jenis = '$idjenis'";
  $result = mysqli_query($conn, $query);

  // Jika jenis laundry ditemukan
  if (mysqli_num_rows($result) > 0) {
    $hasil_jenis = mysqli_fetch_assoc($result);

    // Mengambil nilai lama proses dari hasil query
    $lama_proses = $hasil_jenis['lama_proses'];

    // Menghitung tanggal selesai berdasarkan tanggal hari ini ditambah lama proses
    $tglselesai = date('Y-m-d', strtotime('+' . $lama_proses . ' day'));

    // Menyiapkan data untuk dikirim kembali dalam bentuk JSON
    $data = [
      'sukses' => [
        'tarif' => $hasil_jenis['tarif'],
        'tgl_selesai' => $tglselesai
      ]
    ];
  } else {
    // Jika jenis laundry tidak ditemukan
    $data = [
      'gagal' => 'gagal'
    ];
  }
} else {
  // Jika idjenis kosong atau tidak valid
  $data = [
    'gagal' => 'gagal'
  ];
}

// Mengirim data dalam format JSON kembali ke laundry/tambah.php
echo json_encode($data);
