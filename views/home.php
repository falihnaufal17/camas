<?php

include '../controllers/home.php';

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
  header('Location: index.php?page=login-page');
}

$dataKas = getTotalKas($_SESSION['profile']->id);
$dataHistory = getHistoryKas($_SESSION['profile']->id);
$dataCountAnggota = countAnggota($_SESSION['profile']->id);

?>
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
          <?php if ($_SESSION['profile']->id_jabatan === 1) : ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <?php endif; ?>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <h2 class="mb-3 fs-4">Laporan Kas Bulan <?php echo $nama_bulan[$bulan_ini] . " " . $tahun_ini ?></h2>
            <h3>Total Kas</h3>
            <h2 class="fw-bold"><?php echo "Rp" . number_format($dataKas->total, 0, ',', '.') ?></h3>
          </div>
          <?php if ($_SESSION['profile']->id_jabatan === 1) : ?>
            <div class="carousel-item">
              <div class="mb-3">
                <h2 class="mb-2 fs-4">Keanggotaan Bendahara <i class="fa-solid fa-user-group ms-1"></i></h2>
                <h3 class="fs-3"><?= $dataCountAnggota ?> Anggota</h3>
              </div>
            </div>
          <?php endif ?>
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
                  <div>Dicatat oleh: <?php echo $row['nama_pembuat'] ?></div>
                  <div>Diubah oleh: <?php echo $row['nama_pengubah'] ?></div>
                  <div>Dicatat pada: <?php echo date_format(date_create($row['created_at']), 'd M Y H:i:s'); ?></div>
                  <div>Diubah pada: <?php echo date_format(date_create($row['updated_at']), 'd M Y H:i:s'); ?></div>
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