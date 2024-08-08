<?php

// Variabel untuk menyimpan informasi koneksi ke database
$host = "localhost";
$username = "root";
$password = "root";
$database = "db_sariwangi_laundry";

// Membuat koneksi ke database menggunakan mysqli
$conn = mysqli_connect($host, $username, $password, $database);