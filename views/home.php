<?php
session_start();

date_default_timezone_set('Asia/Jakarta');

// Array nama bulan dalam bahasa Indonesia
$nama_bulan = array(
  1 => "Januari",
  2 => "Februari",
  3 => "Maret",
  4 => "April",
  5 => "Mei",
  6 => "Juni",
  7 => "Juli",
  8 => "Agustus",
  9 => "September",
  10 => "Oktober",
  11 => "November",
  12 => "Desember"
);

// Mendapatkan bulan saat ini
$bulan_ini = date('n');

// Mendapatkan tahun saat ini
$tahun_ini = date('Y');

if (!isset($_SESSION['profile'])) {
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Beranda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <header class="navbar shadow-sm ">
    <div class="container-fluid">
      <div></div>
      <span class="navbar-brand mb-0 h1">Beranda</span>
      <div></div>
    </div>
  </header>
  <main>
    <section class="bg-primary">
      <div class="container text-white py-3">
        <h1 class="text-capitalize mb-4">Assalamu'alaikum <?php echo $_SESSION['profile']->nama ?></h1>
        <div id="carouselExampleIndicators" class="carousel slide pointer-event " data-bs-touch="true" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <h2 class="mb-3 fs-4">Laporan Kas Bulan <?php echo $nama_bulan[$bulan_ini] . " " . $tahun_ini ?></h2>
              <div class="d-flex justify-content-between">
                <div class="mb-3">
                  <h3 class="mb-2 fs-6">Pemasukan <i class="fa-solid fa-arrow-up ms-1"></i></h3>
                  <h3 class="fs-3">Rp 6.000.000</h3>
                </div>
                <div class="mb-3">
                  <h3 class="mb-2 fs-6">Pengeluaran <i class="fa-solid fa-arrow-down ms-1"></i></h3>
                  <h3 class="fs-5">Rp 3.000.000</h3>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="mb-3">
                <h2 class="mb-2 fs-4">Keanggotaan Bendahara <i class="fa-solid fa-user-group ms-1"></i></h2>
                <h3 class="fs-3">1 Anggota</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="py-2 heading-content mb-2">
        <div class="container">
          <h5 class="mb-0 fw-normal">Riwayat Kas</h5>
        </div>
      </div>
      <div class="container">
        <div class="row justify-content-between align-items-center mb-1">
          <div class="col">
            <h6>Uraian</h6>
            <p>20 Januari 2024 18:12</p>
          </div>
          <div class="col-auto">
            <p class="text-success fw-bold"><i class="fa-solid fa-arrow-up ms-1"></i> Rp2.000</p>
          </div>
        </div>
        <div class="row justify-content-between align-items-center mb-1 ">
          <div class="col">
            <h6>Uraian</h6>
            <p>20 Januari 2024 18:12</p>
          </div>
          <div class="col-auto">
            <p class="text-danger fw-bold"><i class="fa-solid fa-arrow-down ms-1"></i> Rp500</p>
          </div>
        </div>
      </div>
    </section>
    <nav class="nav shadow bottom-nav justify-content-between px-3 py-2 bg-white">
      <a href="home.php" class="text-center text-decoration-none ">
        <div>
          <i class="fa fa-home"></i>
        </div>
        <small>Beranda</small>
      </a>
      <a href="kas.php" class="text-center text-decoration-none  text-dark">
        <div>
          <i class="fa fa-wallet"></i>
        </div>
        <small>Kas</small>
      </a>
      <a href="profile.php" class="text-center text-decoration-none  text-dark">
        <div>
          <i class="fa fa-user"></i>
        </div>
        <small>Profil</small>
      </a>
    </nav>
  </main>
</body>

</html>