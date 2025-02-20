<?php
require 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

switch ($aksi) {
    case 'read':
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="latifa keysha" content="width=device-width, initial-scale=1.0">
    <title>Data MATA KULIAH</title>
    
    <!-- jQuery dan DataTables CSS & JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body>


    <h2 class="mt-3">Data Mata Kuliah</h2>
    <a href="index.php?page=mata_kuliah&aksi=create" class="btn btn-outline-primary mb-3">Tambah Mata Kuliah</a>
   
    <table id="mataKuliahTable" class="table table-striped table-bordered">      
        <thead class="table-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode MatKul</th>
                <th scope="col">Nama MatKul</th>
                <th scope="col">SKS</th>
                <th scope="col">Program Studi</th>
                <th scope="col">Semester</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $queryMhs = mysqli_query($koneksi, "SELECT mata_kuliah.*, tb_prodi.nama_prodi FROM mata_kuliah 
                                             LEFT JOIN tb_prodi ON mata_kuliah.prodi_id = tb_prodi.id");
                $no = 1;
                while ($data = mysqli_fetch_array($queryMhs)) {
                ?>
            <tr>
                <th scope="row"><?= $no++ ?></th>
                <td><?= $data['kode_mk'] ?></td>
                <td><?= $data['nama_mk'] ?></td>
                <td><?= $data['sks'] ?></td>
                <td><?= isset($data['nama_prodi']) ? $data['nama_prodi'] : 'Tidak Ada' ?></td>
                <td><?= $data['semester'] ?></td>
                <td>
                    <a href="index.php?page=mata_kuliah&aksi=delete&id=<?= $data['kode_mk'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                    <a href="index.php?page=mata_kuliah&aksi=update&id=<?= $data['kode_mk'] ?>" class="btn btn-outline-warning btn-sm">Update</a>
                </td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>

    <!-- Inisialisasi DataTables -->
    <script>
      $(document).ready(function () {
        $('#mataKuliahTable').DataTable();
      });
    </script>

</body>
</html>

<?php
break;
case 'create':
    $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
?>

<h2>Input Mata Kuliah</h2>
<form action="proses_matakuliah.php?proses=simpan" method="POST">
    <div class="mb-3">
        <label for="kode_mk" class="form-label">Kode Mata Kuliah</label>
        <input type="text" class="form-control" id="kode_mk" name="kode_mk" required>
    </div>
    <div class="mb-3">
        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
        <input type="text" class="form-control" id="nama_mk" name="nama_mk" required>
    </div>
    <div class="mb-3">
        <label for="sks" class="form-label">SKS</label>
        <input type="number" class="form-control" id="sks" name="sks" required>
    </div>
    <div class="mb-3">
            <label class="form-label">Program Studi:</label>
            <select class="form-control" name="prodi_id" required>
                <option value="">Pilih Program Studi</option>
                <?php
                $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
                while($tb_prodi = mysqli_fetch_array($queryProdi)) {
                    echo "<option value='".$tb_prodi['id']."'>".$tb_prodi['nama_prodi']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
        <label for="semester" class="form-label">Semester</label>
        <input type="number" class="form-control" id="semester" name="semester" required>
    </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Simpan">
</form>

<?php
break;

case 'update':
    $kode_mk = $_GET['id'];
    $queryMK = mysqli_query($koneksi, "SELECT * FROM mata_kuliah WHERE kode_mk='$kode_mk'");
    $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
    $data = mysqli_fetch_array($queryMK);
?>

<h2>Update Mata Kuliah</h2>
<form action="proses_matakuliah.php?proses=update" method="POST">
    <input type="hidden" name="kode_mk" value="<?= $data['kode_mk'] ?>">
    <div class="mb-3">
        <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
        <input type="text" class="form-control" id="nama_mk" name="nama_mk" value="<?= $data['nama_mk'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="sks" class="form-label">SKS</label>
        <input type="number" class="form-control" id="sks" name="sks" value="<?= $data['sks'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="semester" class="form-label">Semester</label>
        <input type="number" class="form-control" id="semester" name="semester" value="<?= $data['semester'] ?>" required>
    </div>
    <div class="mb-3">
            <label class="form-label">Program Studi:</label>
            <select class="form-control" name="prodi_id" required>
                <option value="">Pilih Program Studi</option>
                <?php
                $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
                while($prodi = mysqli_fetch_array($queryProdi)) {
                    echo "<option value='".$prodi['id']."'>".$prodi['nama_prodi']."</option>";
                }
                ?>
            </select>
        </div>
    <input type="submit" name="submit" value="Update" class="btn btn-primary">
</form>

<?php
break;

case 'delete':
    $kode_mk = $_GET['id'];
    $queryDelete = mysqli_query($koneksi, "DELETE FROM mata_kuliah WHERE kode_mk='$kode_mk'");
    if ($queryDelete) {
        echo "<script>alert('Data berhasil dihapus!');window.location.href='index.php?page=mata_kuliah';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!');window.location.href='index.php?page=mata_kuliah';</script>";
    }
    break;
}
?>

