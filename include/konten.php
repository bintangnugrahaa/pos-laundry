<?php

// Menangkap nilai dari parameter page dan aksi dari URL
$page = isset($_GET['page']) ? $_GET['page'] : '';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

// Menampilkan halaman home atau dashboard jika parameter page kosong
if ($page == "") {
  include "home.php";
}

// Halaman untuk manajemen data pelanggan
if ($page == "pelanggan") {
  // Menampilkan halaman utama pelanggan jika aksi tidak ditentukan
  if ($aksi == "") {
    include "page/pelanggan/pelanggan.php";
  }
  // Menampilkan halaman tambah data pelanggan jika aksi tambah
  elseif ($aksi == "tambah") {
    include "page/pelanggan/tambah.php";
  }
  // Menghapus data pelanggan jika aksi hapus
  elseif ($aksi == "hapus") {
    include "page/pelanggan/hapus.php";
  }
  // Mengubah data pelanggan jika aksi ubah
  elseif ($aksi == "ubah") {
    include "page/pelanggan/ubah.php";
  }
  // Mengelola foto pelanggan jika aksi foto
  elseif ($aksi == "foto") {
    include "page/pelanggan/uploadfoto.php";
  }
}

// Hanya memungkinkan akses untuk level admin
if ($_SESSION['level'] == 'admin') {
  // Halaman manajemen pengguna (users)
  if ($page == "users") {
    // Menampilkan halaman pengguna jika aksi tidak ditentukan
    if ($aksi == "") {
      include "page/users/users.php";
    }
    // Menambah pengguna baru jika aksi tambah
    elseif ($aksi == "tambah") {
      include "page/users/tambah.php";
    }
    // Menghapus pengguna jika aksi hapus
    elseif ($aksi == "hapus") {
      include "page/users/hapus.php";
    }
    // Mengubah data pengguna jika aksi ubah
    elseif ($aksi == "ubah") {
      include "page/users/ubah.php";
    }
    // Mengelola foto pengguna jika aksi foto
    elseif ($aksi == "foto") {
      include "page/users/uploadfoto.php";
    }
  }

  // Halaman manajemen jenis data
  if ($page == "jenis") {
    // Menampilkan halaman jenis jika aksi tidak ditentukan
    if ($aksi == "") {
      include "page/jenis/jenis.php";
    }
    // Menambah jenis data baru jika aksi tambah
    elseif ($aksi == "tambah") {
      include "page/jenis/tambah.php";
    }
    // Menghapus jenis data jika aksi hapus
    elseif ($aksi == "hapus") {
      include "page/jenis/hapus.php";
    }
    // Mengubah jenis data jika aksi ubah
    elseif ($aksi == "ubah") {
      include "page/jenis/ubah.php";
    }
  }
}

// Halaman transaksi laundry
if ($page == "laundry") {
  // Menampilkan halaman laundry jika aksi tidak ditentukan
  if ($aksi == "") {
    include "page/laundry/laundry.php";
  }
  // Menampilkan data yang sudah lunas jika aksi laundrylunas
  elseif ($aksi == "laundrylunas") {
    include "page/laundry/laundrylunas.php";
  }
  // Menampilkan data yang belum lunas jika aksi laundrybelumlunas
  elseif ($aksi == "laundrybelumlunas") {
    include "page/laundry/laundrybelumlunas.php";
  }
  // Menambah transaksi laundry jika aksi tambah
  elseif ($aksi == "tambah") {
    include "page/laundry/tambah.php";
  }
  // Menghapus transaksi laundry jika aksi hapus
  elseif ($aksi == "hapus") {
    include "page/laundry/hapus.php";
  }
  // Melunasi transaksi laundry jika aksi lunasi
  elseif ($aksi == "lunasi") {
    include "page/laundry/lunasi.php";
  }
  // Menampilkan detail transaksi jika aksi detail
  elseif ($aksi == "detail") {
    include "page/detail_transaksi.php";
  }
  // Menandai baju telah diambil jika aksi diambil
  elseif ($aksi == "diambil") {
    include "page/laundry/diambil.php";
  }
}

// Halaman pengeluaran
if ($page == "pengeluaran") {
  // Menampilkan halaman pengeluaran jika aksi tidak ditentukan
  if ($aksi == "") {
    include "page/pengeluaran/pengeluaran.php";
  }
  // Menambah pengeluaran jika aksi tambah
  elseif ($aksi == "tambah") {
    include "page/pengeluaran/tambah.php";
  }
  // Menghapus pengeluaran jika aksi hapus
  elseif ($aksi == "hapus") {
    include "page/pengeluaran/hapus.php";
  }
  // Mengubah pengeluaran jika aksi ubah
  elseif ($aksi == "ubah") {
    include "page/pengeluaran/ubah.php";
  }
  // Menampilkan detail pengeluaran jika aksi detail
  elseif ($aksi == "detail") {
    include "page/detail_pengeluaran.php";
  }
}

// Halaman laporan
if ($page == "laporan") {
  // Menampilkan halaman laporan jika aksi tidak ditentukan
  if ($aksi == "") {
    include "page/laporan/laporan.php";
  }
}

// Halaman profile
if ($page == "profile") {
  // Menampilkan halaman profile jika aksi tidak ditentukan
  if ($aksi == "") {
    include "page/profile.php";
  }
  // Mengubah foto profile jika aksi ubahfoto
  elseif ($aksi == "ubahfoto") {
    include "page/uploadfotoprofile.php";
  }
}
