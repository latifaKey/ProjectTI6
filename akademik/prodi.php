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

<h2 class="mt-3">Data Program Studi</h2>
<a href="index.php?page=prodi&aksi=create" class="btn btn-outline-primary mb-3">Tambah Prodi</a>

  <table id="prodiTable" class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Prodi</th>
        <th scope="col">Jenjang</th>
        <th scope="col">Keterangan</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $queryMhs = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
        $no = 1;
        while ($data = mysqli_fetch_array($queryMhs)) {
      ?>
      <tr>
        <th scope="row"><?= $no++ ?></th>
        <td><?= $data['nama_prodi'] ?></td>
        <td><?= $data['jenjang'] ?></td>
        <td><?= $data['keterangan'] ?></td>
        <td scope="row">
          <a href="index.php?page=prodi&aksi=delete&id=<?= $data['id'] ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
          <a href="index.php?page=prodi&aksi=update&id=<?= $data['id'] ?>" class="btn btn-outline-warning">Update</a>
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
    $('#prodiTable').DataTable();
  });
</script>

</body>
</html>

<?php
break;

case 'create':
?>

<h2>Input Prodi</h2>
  <form action="proses_prodi.php?proses=insert" method="POST">
      <div class="mb-3">
        <label for="nama_prodi" class="form-label">Nama Prodi</label>
        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" required>
      </div>

      <label>Jenjang</label><br>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio1" value="D2">
          <label class="form-check-label" for="inlineRadio1">D2</label>
      </div><br>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio2" value="D3">
          <label class="form-check-label" for="inlineRadio2">D3</label>
      </div><br>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio3" value="D4">
          <label class="form-check-label" for="inlineRadio3">D4</label>
      </div><br>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio4" value="S1">
          <label class="form-check-label" for="inlineRadio4">S1</label>
      </div><br>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio5" value="S2">
          <label class="form-check-label" for="inlineRadio5">S2</label>
      </div><br>

      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
      </div>
      <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
  </form>
               
    <?php
    break;

    case 'update':
        $id = $_GET['id'];
        $queryMhs = mysqli_query($koneksi, "SELECT * FROM tb_prodi WHERE id='$id'");
        $data = mysqli_fetch_array($queryMhs);
    ?>
    <h2>Update Data Mahasiswa</h2>
    <form action="proses_prodi.php?proses=update" method="POST">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <div class="mb-3">
          <label for="nama_prodi" class="form-label">Nama Prodi</label>
          <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="<?= $data['nama_prodi'] ?>" required>
      </div>
      
      <label>Jenjang</label><br>
			    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio1" value="D2" <?= $data['jenjang'] == 'D2' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inlineRadio1">D2</label>
                </div><br>
				<div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio2" value="D3" <?= $data['jenjang'] == 'D3' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inlineRadio2">D3</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio3" value="D4" <?= $data['jenjang'] == 'D4' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inlineRadio3">D4</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio4" value="S1" <?= $data['jenjang'] == 'S1' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inlineRadio4">S1</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenjang" id="inlineRadio5" value="S2" <?= $data['jenjang'] == 'S2' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inlineRadio5">S2</label>
          </div><br>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" rows="3" value="<?= $data['keterangan'] ?>" required>
        </div>
        <input type="submit" name="submit" value="Update" class="btn btn-primary">
    </form>
<?php
    break;

    case 'delete':
        $id = $_GET['id'];
        $queryDelete = mysqli_query($koneksi, "DELETE FROM tb_prodi WHERE id='$id'");
        if ($queryDelete) {
            echo "<script>alert('Data berhasil dihapus!');window.location.href='index.php?page=prodi';</script>";
        } else {
            echo "<script>alert('Data gagal dihapus!');window.location.href='index.php?page=prodi';</script>";
        }
    break;
}
?>