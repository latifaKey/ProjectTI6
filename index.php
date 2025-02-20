<?php
  //cek apakah sudah login atau belum 
  session_start();  
  if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="Latifa Keysha" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary"data-bs-theme="dark">
  <div class="container-fluid mb-3 mt-3">
    <a class="navbar-brand" href="#">Akademik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=mahasiswa">Mahasiswa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=dosen">Dosen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=prodi">Prodi</a>
        </li>
        <?php if($_SESSION['level'] == 'admin'){ ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=mata_kuliah">Mata Kuliah</a>
          </li>
        <?php }?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?=$_SESSION['nama']?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="logout.php">LOGOUT</a></li>

          </ul>
        </li>  
      </ul>
     
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      
        
    </div>
  </div>
</nav>

<div class="container">
     <?php
          $page = isset($_GET['page']) ? $_GET['page'] : 'home';
          if($page == 'home') include 'home.php';  
          if($page == 'mahasiswa') include 'mahasiswa.php';
          if($page == 'dosen') include 'dosen.php';
          if($page == 'prodi') include 'prodi.php';
          if ($page == 'users') include 'users.php';
          if ($page == 'mata_kuliah') include 'mata_kuliah.php';
          
        ?>
    </div>

    <footer class="bg-dark text-center text-white py-2 mt-5">
        Copyright &copy; 2024 Developed by Latifa Keysha
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>