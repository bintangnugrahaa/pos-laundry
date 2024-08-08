<?php

// Ambil id dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Pastikan id tidak kosong
if (!empty($id)) {
    // Query untuk mengambil data transaksi sesuai id
    $query = "SELECT * FROM tb_laundry WHERE id_laundry = '$id'";
    $result = mysqli_query($conn, $query);

    // Memeriksa apakah query berhasil dieksekusi dan mendapatkan hasil
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Menyimpan data dari hasil query
        $tgl = $row['tgl_terima'];
        $pemasukan = $row['totalbayar'];
        $catatan = $row['catatan'];
        $ket_laporan = 1;

        // Ubah status_pembayaran transaksi laundry menjadi lunas
        $update_query = "UPDATE tb_laundry SET `status_pembayaran` = 1 WHERE id_laundry = '$id'";
        $result_update = mysqli_query($conn, $update_query);

        // Inisialisasi nilai pengeluaran untuk laporan (misalnya 0 atau nilai yang sesuai)
        $pengeluaran = 0;

        // Query untuk menambahkan data ke tb_laporan jika transaksi sudah lunas
        $insert_query = "INSERT INTO `tb_laporan` (`tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `pengeluaran`) 
                         VALUES ('$tgl', '$ket_laporan', '$catatan', '$id', '$pemasukan', '$pengeluaran')";
        $result_insert = mysqli_query($conn, $insert_query);

        // Jika keduanya berhasil, tampilkan pesan sukses
        if ($result_update && $result_insert) {
            echo "
                <script>
                // Tampilkan SweetAlert sukses dan redirect setelah 1 detik
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Transaksi laundry sudah dilunasi.',
                    timer: 1000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = '?page=laundry';
                });
                </script>
                ";
        } else {
            // Jika salah satu atau kedua query gagal
            display_error_notification();
        }
    } else {
        // Jika query untuk mengambil data tidak menghasilkan hasil
        display_error_notification();
    }
} else {
    // Jika id kosong atau tidak valid
    display_error_notification();
}

// Fungsi untuk menampilkan notifikasi error
function display_error_notification()
{
    echo "
    <script>
    // Tampilkan SweetAlert error jika terjadi kesalahan dalam proses
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Terjadi kesalahan saat memproses data.',
    }).then(function() {
        window.location.href = '?page=laundry';
    });
    </script>
    ";
}
