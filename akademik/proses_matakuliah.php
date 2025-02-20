<?php
require 'koneksi.php';

if(isset($_GET['proses'])) {
    $proses = $_GET['proses'];
    
    if($proses == 'simpan') {
        if(isset($_POST['submit'])) {
            $kode_mk = $_POST['kode_mk'];
            $nama_mk = $_POST['nama_mk'];
            $sks = $_POST['sks'];
            $prodi_id = $_POST['prodi_id'];
            $semester = $_POST['semester'];
            
            $cek_kode = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode_mk'");
            if (!$cek_kode) {
                DIE("Error pada query: " . mysqli_error($cek_kode));
            }
            if(mysqli_num_rows($cek_kode) > 0) {
                echo "<script>alert('Data gagal disimpan! Kode Mata Kuliah sudah terdaftar'); window.location='index.php?page=mata_kuliah&aksi=create'</script>";
                exit();
            }
            
            $query = mysqli_query($koneksi, "INSERT INTO mata_kuliah (kode_mk, nama_mk, sks, prodi_id, semester) 
                                             VALUES ('$kode_mk', '$nama_mk', '$sks', '$prodi_id', '$semester')");
            
            if($query) {
                echo "<script>alert('Data Berhasil Disimpan'); window.location='index.php?page=mata_kuliah'</script>";
            } else {
                echo "<script>alert('Data Gagal Disimpan'); window.location='index.php?page=mata_kuliah&aksi=create'</script>";
            }
        }
    }
    if (isset($_GET['proses']) && $_GET['proses'] == 'update') {
        if(isset($_POST['submit'])) {
            $kode_mk = $_POST['kode_mk'];
            $nama_mk = $_POST['nama_mk'];
            $sks = $_POST['sks'];
            $prodi_id = $_POST['prodi_id'];
            $semester = $_POST['semester'];
            
            $query = mysqli_query($koneksi, "UPDATE mata_kuliah SET 
                     nama_mk='$nama_mk',
                     sks='$sks',
                     prodi_id='$prodi_id',
                     semester='$semester'
                     WHERE kode_mk='$kode_mk'");
                     
            if($query) {
                echo "<script>alert('Data Berhasil Diupdate'); window.location='index.php?page=mata_kuliah'</script>";
            } else {
                echo "<script>alert('Data Gagal Diupdate'); window.location='index.php?page=mata_kuliah'</script>";
            }
        }
    }
    elseif($proses == 'delete') {
        session_start();
        if($_SESSION['level'] != 'admin') {
            echo "<script>alert('Anda tidak memiliki izin untuk menghapus data.'); window.location='index.php?page=mata_kuliah'</script>";
            exit;
        }
        
        $kode = $_GET['kode'];
        $query = mysqli_query($koneksi, "DELETE FROM mata_kuliah WHERE kode_mk = '$kode'");
        
        if($query) {
            echo "<script>alert('Data Berhasil Dihapus'); window.location='index.php?page=mata_kuliah'</script>";
        } else {
            echo "<script>alert('Data Gagal Dihapus'); window.location='index.php?page=mata_kuliah'</script>";
        }
    }
}
?>
