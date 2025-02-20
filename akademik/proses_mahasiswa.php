<?php
require 'koneksi.php';

// Proses Insert
if (isset($_GET['proses']) && $_GET['proses'] == 'insert') {
    if (isset($_POST["submit"])) {
        $nama = $_POST["nama"];
        $nim = $_POST["nim"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $hobi = implode(", ", $_POST['hobi']);
        $alamat = $_POST["alamat"];
        $prodi_id = $_POST['prodi_id'];


        //cek nim 
        $cek_nim = mysqli_query($koneksi, "SELECT nim FROM mahasiswa1 WHERE nim='$nim'");

        if (!$cek_nim) {
            die("Error pada query: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($cek_nim) > 0) {
            echo "<script>alert('NIM sudah terdaftar!');window.location='index.php?page=mahasiswa&aksi=create'</script>";
            exit();
        }

        // Cek Prodi ID
        $cek_prodi = mysqli_query($koneksi, "SELECT id FROM tb_prodi WHERE id = '$prodi_id'");
        if (mysqli_num_rows($cek_prodi) == 0) {
            echo "SQL Error: SELECT id FROM tb_prodi WHERE id = '$prodi_id'";  // Debugging line
            echo "<script>alert('Program studi tidak valid!');window.location='index.php?page=mahasiswa&aksi=create'</script>";
            exit();
        }
        

        $query = mysqli_query($koneksi, "INSERT INTO mahasiswa1 (nama, email, nim, gender, hobi, alamat, prodi_id) 
                                         VALUES ('$nama', '$email', '$nim', '$gender', '$hobi', '$alamat', '$prodi_id')");

   
        if ($query) {
            echo "<script>alert('Data berhasil disimpan');window.location='index.php?page=mahasiswa'</script>";
        } else {
            echo "<script>alert('Data gagal disimpan!!!!');window.location='index.php?page=mahasiswa'</script>";
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
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $hobi = implode(", ", $_POST['hobi']);
        $alamat = $_POST['alamat'];
        $prodi_id = $_POST['prodi_id'];

        $query = mysqli_query($koneksi, "UPDATE mahasiswa1 SET 
                                                nama='$nama', 
                                                email='$email', 
                                                nim='$nim', 
                                                gender='$gender', 
                                                hobi='$hobi', 
                                                alamat='$alamat',
                                                prodi_id='$prodi_id'  
                                                WHERE id='$id'");
        if ($query) {
            echo "<script>alert('Data berhasil diperbarui');window.location='index.php?page=mahasiswa'</script>";
        } else {
            echo "<script>alert('Data gagal diperbarui!!!!');window.location='index.php?page=mahasiswa'</script>";
        }
    }
}

// Proses Delete
if (isset($_GET['proses']) && $_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "DELETE FROM mahasiswa1 WHERE id='$id'");

        if ($query) {
            echo "<script>alert('Data berhasil dihapus');window.location='index.php?page=mahasiswa'</script>";
        } else {
            echo "<script>alert('Data gagal dihapus!!!!');window.location='index.php?page=mahasiswa'</script>";
        }
    } else {
        echo "<script>alert('ID tidak ditemukan!');window.location='index.php?page=mahasiswa'</script>";
    }
}
?>
