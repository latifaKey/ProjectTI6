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
    <title>Data Program Studi</title>
    
    <!-- jQuery dan DataTables CSS & JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <h2 class="mt-3">Data Mahasiswa</h2>
    <a href="index.php?page=mahasiswa&aksi=create"class="btn btn-outline-primary mb-3">Tambah Mahasiswa</a>
   
    <table id="mahasiswaTable" class="table table-striped table-bordered ">      
    <thead class="table-dark">
        <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Email</th>
        <th scope="col">Nim</th>
        <th scope="col">Jenis Kelamin</th>
        <th scope="col">Hobi</th>
        <th scope="col">Alamat</th>
        <th scope="col">Program Studi</th>
        <th scandir="col">Aksi</th>
        
        
        </tr>
    </thead>
    <tbody>
        <?php
        $queryMhs = mysqli_query($koneksi, "
        SELECT mahasiswa1.*, tb_prodi.nama_prodi
        FROM mahasiswa1
        LEFT JOIN tb_prodi ON mahasiswa1.prodi_id = tb_prodi.id
        ");
        $no = 1;
        while($data = mysqli_fetch_array($queryMhs))
        {
    
        ?>
        <tr>
        <th scope="row"><?= $no++ ?></th>
        <td><?= $data['nama'] ?></td>
        <td><?= $data ['email'] ?></td>
        <td><?= $data ['nim']?></td>
        <td><?= $data ['gender'] == 'L' ? 'Laki-Laki' : 'Perempuan'  ?></td>
        <td><?= $data ['hobi'] ?></td>
        <td><?= $data ['alamat'] ?></td>
        <td><?= isset($data['nama_prodi']) ? $data['nama_prodi'] : 'Tidak Ada' ?></td>
        <td scope="row">
            <a href="index.php?page=mahasiswa&aksi=delete&id=<?= $data['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
            <a href="index.php?page=mahasiswa&aksi=update&id=<?= $data['id'] ?>" class="btn btn-outline-warning btn-sm">Update</a>
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
    $('#mahasiswaTable').DataTable();
  });
</script>

</body>
</html>


<?php
break;
case 'create' :
// Ambil data dari tabel tb_prodi
$queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
?>



    <h2>Input Mahasiwa</h2>
    <form action="proses_mahasiswa.php?proses=insert" method="POST">
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
          <label for="nim" class="form-label">NO BP</label>
          <input type="nim" class="form-control" id="nim" name="nim" required>
        </div>
        <div class="mb-3 ">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
        <div class="mb-3">
			<label>Jenis Kelamin</label><br>
			    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="L">
                    <label class="form-check-label" for="inlineRadio1">L</label>
				</div>
				<div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="P">
                    <label class="form-check-label" for="inlineRadio2">P</label>
				</div> <br>
            <label>Hobi</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobi[]" id="inlineCheckbox1" value="Menggambar">
                    <label class="form-check-label" for="inlineCheckbox1">Menggambar</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobi[]" id="inlineCheckbox1" value="BasketBall">
                    <label class="form-check-label" for="inlineCheckbox1">BasketBall</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobi[]" id="inlineCheckbox1" value="Melukis">
                    <label class="form-check-label" for="inlineCheckbox1">Melukis</label>
                </div>
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea class="form-control" id="alamt" name="alamat" rows="3"></textarea>
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
  

        <br><br>
        <input type="submit" name="submit" value="Simpan" class = "btn btn-primary">
      </form>
      
<?php
    break;

    case 'update':
        $id = $_GET['id'];
        $queryMhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa1 WHERE id='$id'");
        $queryProdi = mysqli_query($koneksi, "SELECT * FROM tb_prodi");
        $data = mysqli_fetch_array($queryMhs);
?>

    <h2>Update Data Mahasiswa</h2>
    <form action="proses_mahasiswa.php?proses=update" method="POST">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <div class="mb-3">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
      </div>
      
        <div class="mb-3">
            <label for="nim" class="form-label">NO BP</label>
            <input type="text" class="form-control" id="nim" name="nim" value="<?= $data['nim'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $data['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="L" <?= $data['gender'] == 'L' ? 'checked' : '' ?>>
                <label class="form-check-label">L</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="P" <?= $data['gender'] == 'P' ? 'checked' : '' ?>>
                <label class="form-check-label">P</label>
            </div>
        </div>
        <div class="mb-3">
            <label>Hobi</label><br>
            <?php
            $hobi = explode(',', $data['hobi']);
            ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="hobi[]" value="Menggambar" <?= in_array('Menggambar', $hobi) ? 'checked' : '' ?>>
                <label class="form-check-label">Menggambar</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="hobi[]" value="BasketBall" <?= in_array('BasketBall', $hobi) ? 'checked' : '' ?>>
                <label class="form-check-label">BasketBall</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="hobi[]" value="Melukis" <?= in_array('Melukis', $hobi) ? 'checked' : '' ?>>
                <label class="form-check-label">Melukis</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= $data['alamat'] ?></textarea>
        </div>

        <div class="mb-3">
        <label for="prodi_id" class="form-label">Program Studi</label>
        <select class="form-select" id="prodi_id" name="prodi_id" required>
            <option value="">Pilih Program Studi</option>
            <?php while ($prodi = mysqli_fetch_array($queryProdi)) : ?>
                <option value="<?= $prodi['id'] ?>  " <?= $data['prodi_id'] == $prodi['id'] ? 'selected' : '' ?>>
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
        $id = $_GET['id'];
        $queryDelete = mysqli_query($koneksi, "DELETE FROM mahasiswa1 WHERE id='$id'");
        if ($queryDelete) {
            echo "<script>alert('Data berhasil dihapus!');window.location.href='index.php?page=mahasiswa';</script>";
        } else {
            echo "<script>alert('Data gagal dihapus!');window.location.href='index.php?page=mahasiswa';</script>";
        }
    break;
}
?>