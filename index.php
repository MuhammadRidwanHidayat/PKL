<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="../assets/img/srambipaudlogo.png" rel="icon">
  <link href="../assets/img/srambipaudlogo.png" rel="apple-touch-icon">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - SRAMBI PAUD</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="assets/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <style>
    /* Custom styles for the sidebar */
    .sb-sidenav {
      background-color: #212529;
    }

    .sb-sidenav-menu a.nav-link {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding: 12px 16px;
      text-align: center;
      font-size: 16px;
      color: rgba(255, 255, 255, 0.7);
      transition: background-color 0.3s;
    }

    .sb-sidenav-menu a.nav-link:hover {
      background-color: #343a40;
      color: rgba(255, 255, 255, 1);
    }

    .navbar .ml-auto {
      margin-left: auto;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">SRAMBI PAUD</a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link" href="index.php?page=dashboard">
              <div class="sb-nav-link-icon">
                <i class="fas fa-tachometer-alt"></i>
              </div>
              Dashboard
            </a>
            <a class="nav-link" href="index.php?page=guru">
              <div class="sb-nav-link-icon">
                <i class="fas fa-chalkboard-teacher"></i>
              </div>
              Data Guru
            </a>
            <a class="nav-link" href="index.php?page=berita">
              <div class="sb-nav-link-icon">
                <i class="fas fa-newspaper"></i>
              </div>
              Berita
            </a>
            <a class="nav-link" href="index.php?page=pengumuman">
              <div class="sb-nav-link-icon">
                <i class="fas fa-bullhorn"></i>
              </div>
              Pengumuman
            </a>
            <a class="nav-link" href="index.php?page=galeri">
              <div class="sb-nav-link-icon">
                <i class="fas fa-images"></i>
              </div>
              Galeri
            </a>
          </div>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <?php
          $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

          if ($page === 'dashboard') {
            include('dashboard.php');
          } elseif ($page === 'guru') {
            include('guru/guru.php');
          } elseif ($page === 'berita') {
            include('berita/berita.php');
          } elseif ($page === 'pengumuman') {
            include('pengumuman/pengumuman.php');
          } elseif ($page === 'galeri') {
            include('galeri/galeri.php');
          }
          ?>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>