<?php
require "koneksi.php";

// Pastikan proses ada
if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];

    // Insert data
    if ($proses == 'insert') {
        if (isset($_POST['submit'])) {
            $nip =  $_POST['nip'];
            $nama_dosen = $_POST['nama_dosen'];
            $prodi_id = $_POST['prodi_id'];
            $foto = $_FILES['foto']['name'];
            $tmp_name = $_FILES['foto']['tmp_name'];
            $folder = "uploads/";

            // Cek apakah NIP sudah ada
            $cek_nip = mysqli_query($koneksi, "SELECT nip FROM dosen WHERE nip='$nip'");
            if (mysqli_num_rows($cek_nip) > 0) {
                echo "<script>alert('NIP sudah terdaftar!');window.location='index.php?page=dosen&aksi=create';</script>";
                exit();
            }

            // Validasi format file foto
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
            if ($foto && !in_array($file_extension, $allowed_extensions)) {
                echo "<script>alert('Format file foto tidak valid (hanya jpg, jpeg, png)!');window.location='index.php?page=dosen&aksi=create';</script>";
                exit();
            }

            // Upload foto dengan nama unik
            $foto_baru = time() . "_" . $foto;
            $path_foto = $folder . $foto_baru;

            if ($foto && move_uploaded_file($tmp_name, $path_foto)) {
                $query = mysqli_query($koneksi, "INSERT INTO dosen (nip, nama_dosen, prodi_id, foto) VALUES ('$nip', '$nama_dosen', '$prodi_id', '$foto_baru')");
            } else {
                // Jika tidak ada foto diunggah
                $query = mysqli_query($koneksi, "INSERT INTO dosen (nip, nama_dosen, prodi_id) VALUES ('$nip', '$nama_dosen', '$prodi_id')");
            }

            if ($query) {
                echo "<script>alert('Data berhasil disimpan!');window.location='index.php?page=dosen';</script>";
            } else {
                echo "<script>alert('Data gagal disimpan!');window.location='index.php?page=dosen';</script>";
            }
        }
    }

    // Update data
    if ($proses == 'update') {
        if (isset($_POST['submit'])) {
            $nip =  $_POST['nip'];
            $nama_dosen = $_POST['nama_dosen'];
            $prodi_id = $_POST['prodi_id'];
            $foto = $_FILES['foto']['name'];
            $tmp_name = $_FILES['foto']['tmp_name'];
            $folder = "uploads/";

            if ($foto) {
                // Validasi format file foto
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "<script>alert('Format file foto tidak valid (hanya jpg, jpeg, png)!');window.location='index.php?page=dosen&aksi=update&nip=$nip';</script>";
                    exit();
                }

                // Ambil foto lama
                $result = mysqli_query($koneksi, "SELECT foto FROM dosen WHERE nip='$nip'");
                $data = mysqli_fetch_assoc($result);
                $old_foto = $data['foto'];

                // Hapus foto lama jika ada
                if ($old_foto && file_exists($folder . $old_foto)) {
                    unlink($folder . $old_foto);
                }

                // Upload foto baru
                $foto_baru = time() . "_" . $foto;
                move_uploaded_file($tmp_name, $folder . $foto_baru);

                // Update dengan foto baru
                $query = mysqli_query($koneksi, "UPDATE dosen SET nama_dosen='$nama_dosen', prodi_id='$prodi_id', foto='$foto_baru' WHERE nip='$nip'");
            } else {
                // Update tanpa foto
                $query = mysqli_query($koneksi, "UPDATE dosen SET nama_dosen='$nama_dosen', prodi_id='$prodi_id' WHERE nip='$nip'");
            }

            if ($query) {
                echo "<script>alert('Data berhasil diupdate!');window.location='index.php?page=dosen';</script>";
            } else {
                echo "<script>alert('Data gagal diupdate!');window.location='index.php?page=dosen';</script>";
            }
        }
    }

    // Delete data
    if ($proses == 'delete') {
        if (isset($_GET['nip'])) {
            $nip = $_GET['nip'];

            // Ambil foto yang terkait
            $result = mysqli_query($koneksi, "SELECT foto FROM dosen WHERE nip='$nip'");
            $data = mysqli_fetch_assoc($result);
            $foto = $data['foto'];
            $folder = "uploads/";

            // Hapus foto jika ada
            if ($foto && file_exists($folder . $foto)) {
                unlink($folder . $foto);
            }

            // Hapus data dari database
            $queryHapus = mysqli_query($koneksi, "DELETE FROM dosen WHERE nip='$nip'");

            if ($queryHapus) {
                echo "<script>alert('Data berhasil dihapus!');window.location='index.php?page=dosen';</script>";
            } else {
                echo "<script>alert('Data gagal dihapus!');window.location='index.php?page=dosen';</script>";
            }
        } else {
            echo "<script>alert('NIP tidak ditemukan!');window.location='index.php?page=dosen';</script>";
        }
    }
}
?>
