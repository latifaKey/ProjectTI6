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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Program Studi</title>
    
    <!-- jQuery dan DataTables CSS & JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body>

<h2 class="mt-3">Data Dosen</h2>
<a href="index.php?page=dosen&aksi=create" class="btn btn-outline-primary mb-3">Tambah Dosen</a>

<table id="dosenTable" class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIP</th>
            <th scope="col">Nama Dosen</th>
            <th scope="col">Foto</th>
            <th scope="col">Program Studi</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $queryMhs = mysqli_query($koneksi, "
            SELECT dosen.*, tb_prodi.nama_prodi
            FROM dosen
            LEFT JOIN tb_prodi ON dosen.prodi_id = tb_prodi.id
        ");
        $no = 1;
        while ($data = mysqli_fetch_array($queryMhs)) {
        ?>
        <tr>
            <th scope="row"><?= $no++ ?></th>
            <td><?= $data['nip'] ?></td>
            <td><?= $data['nama_dosen'] ?></td>
            <td><img src="uploads/<?= $data['foto'] ?>" alt="Foto" width="150"></td>

            <td><?= isset($data['nama_prodi']) ? $data['nama_prodi'] : 'Tidak Ada' ?></td>
            <td>
              <a href="index.php?page=dosen&aksi=delete&nip=<?= $data['nip'] ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
              <a href="index.php?page=dosen&aksi=update&nip=<?= $data['nip'] ?>" class="btn btn-outline-warning">Update</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<!-- Inisialisasi DataTables -->
<script>
  $(document).ready(function () {
    $('#dosenTable').DataTable();
  });
</script>

</body>
</html>

<?php
break;

case 'create':
    $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
?>
<h2>Input Dosen</h2>
<form action="proses_dosen.php?proses=insert" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nip" class="form-label">NIP</label>
        <input type="text" class="form-control" id="nip" name="nip" required>
    </div>
    <div class="mb-3">
        <label for="nama_dosen" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>
    <div class="mb-3">
        <label for="prodi_id" class="form-label">Program Studi</label>
        <select class="form-select" id="prodi_id" name="prodi_id" required>
            <option value="">Pilih Program Studi</option>
            <?php while ($tb_prodi = mysqli_fetch_array($queryProdi)) : ?>
                <option value="<?= $tb_prodi['id'] ?>"><?= $tb_prodi['nama_prodi'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
</form>

<?php
break;

case 'update':
    $nip = $_GET['nip'];
    $queryDsn = mysqli_query($koneksi, "SELECT * FROM dosen WHERE nip='$nip'");
    $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
    $data = mysqli_fetch_array($queryDsn);
?>
<h2>Update Data Dosen</h2>
<form action="proses_dosen.php?proses=update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="nip" value="<?= $data['nip'] ?>">
    
    <div class="mb-3">
        <label for="nama_dosen" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?= $data['nama_dosen'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" id="foto" name="foto">
    </div>
    <div class="mb-3">
        <label for="prodi_id" class="form-label">Program Studi</label>
        <select class="form-select" id="prodi_id" name="prodi_id" required>
            <option value="">Pilih Program Studi</option>
            <?php while ($prodi = mysqli_fetch_array($queryProdi)) : ?>
                <option value="<?= $prodi['id'] ?>" <?= $data['prodi_id'] == $prodi['id'] ? 'selected' : '' ?>>
                    <?= $prodi['nama_prodi'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-primary">
</form>

<?php
    break;

case 'delete':
    $nip = $_GET['nip'];
    $queryDelete = mysqli_query($koneksi, "DELETE FROM dosen WHERE nip='$nip'");
    if ($queryDelete) {
        echo "<script>alert('Data berhasil dihapus!');window.location.href='index.php?page=dosen';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!');window.location.href='index.php?page=dosen';</script>";
    }
    break;
}
?>
