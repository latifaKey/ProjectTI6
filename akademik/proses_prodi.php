<?php
require 'koneksi.php';

// Proses Insert
if (isset($_GET['proses']) && $_GET['proses'] == 'insert') {
    if (isset($_POST["submit"])) {
        $nama_prodi = $_POST["nama_prodi"];
        $jenjang = $_POST["jenjang"];
        $keterangan = $_POST["keterangan"];



        $query = mysqli_query($koneksi, "INSERT INTO tb_prodi (nama_prodi, jenjang, keterangan) 
                                         VALUES ('$nama_prodi', '$jenjang', '$keterangan')");
    
        if ($query) {
            echo "<script>alert('Data berhasil disimpan');window.location='index.php?page=prodi'</script>";
        } else {
            echo "<script>alert('Data gagal disimpan!!!!');window.location='index.php?page=prodi'</script>";
        }
    } else {
        header("Location: form.php");
        exit;
    }
}
// Proses Update
if (isset($_GET['proses']) && $_GET['proses'] == 'update') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nama_prodi = $_POST['nama_prodi'];
        $jenjang = $_POST['jenjang'];
        $keterangan = $_POST['keterangan'];
        

        $query = mysqli_query($koneksi, "UPDATE tb_prodi SET 
                                          nama_prodi='$nama_prodi', 
                                          jenjang='$jenjang', 
                                          keterangan='$keterangan' 
                                          WHERE id='$id'");

        if ($query) {
            echo "<script>alert('Data berhasil diperbarui');window.location='index.php?page=prodi'</script>";
        } else {
            echo "<script>alert('Data gagal diperbarui!!!!');window.location='index.php?page=prodi'</script>";
        }
    }
}

// Proses Delete
if (isset($_GET['proses']) && $_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "DELETE FROM tb_prodi WHERE id='$id'");

        if ($query) {
            echo "<script>alert('Data berhasil dihapus');window.location='index.php?page=prodi'</script>";
        } else {
            echo "<script>alert('Data gagal dihapus!!!!');window.location='index.php?page=prodi'</script>";
        }
    } else {
        echo "<script>alert('ID tidak ditemukan!');window.location='index.php?page=prodi'</script>";
    }
}
?>

?>