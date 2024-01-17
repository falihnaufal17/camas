<?php

include '../controllers/home.php';

session_start();

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

$dataKas = getTotalKas($_SESSION['profile']->id);
$dataHistory = getHistoryKas($_SESSION['profile']->id);

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
              <h3>Total Kas</h3>
              <h2 class="fw-bold"><?php echo "Rp" . number_format($dataKas->total, 0, ',', '.') ?></h3>
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
        <?php if ($dataHistory) : ?>
          <div class="d-flex flex-column row-gap-3">
            <?php foreach ($dataHistory as $row) : ?>
              <div class="card">
                <div class="card-body row justify-content-between flex-md-row flex-column-reverse align-items-md-center">
                  <div class="col">
                    <h5><?php echo $row['uraian'] ?></h5>
                    <div>Tanggal: <?php echo date_format(date_create($row['tanggal']), 'd M Y'); ?></div>
                    <div>Dicatat oleh: <?php echo $row['nama'] ?></div>
                    <div>Dicatat pada: <?php echo date_format(date_create($row['created_at']), 'd M Y'); ?></div>
                  </div>
                  <div class="col-12 col-md-auto">
                    <h5 class="<?php echo $row['tipe'] === '1' ? 'text-success' : 'text-danger' ?>">
                      <i class="fa <?php echo $row['tipe'] === '1' ? 'fa-arrow-up' : 'fa-arrow-down' ?>"></i>
                      <?php echo 'Rp' . number_format($row['nominal'], 0, ',', '.') ?>
                    </h5>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <p class="text-center">Belum ada data kas yang tercatat</p>
        <?php endif; ?>
      </div>
    </section>
    <?php include '../components/bottom-nav.php' ?>
  </main>
</body>

</html>