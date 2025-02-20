<?php
    
    //inisialisasi variabel koneksi
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "web_trpl2c";

    //membuat koneksi ke database 
    $koneksi = mysqli_connect($host, $user, $password, $database);

    // Memeriksa apakah koneksi berhasil atau tidak
    if (!$koneksi) {
        echo "Koneksi ke database gagal: " . mysqli_connect_error();
    } 
?>
