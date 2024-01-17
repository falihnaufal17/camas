<?php
include "../controllers/kas.php";

session_start();
setlocale(LC_ALL, 'id_ID');

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

$startDate = new DateTime($_GET['from']);
$startDateMonth = $startDate->format('n');
$startDateDay = $startDate->format('d');
$startDateYear = $startDate->format('Y');

$currentDate = new DateTime($_GET['to']);
$currentDateMonth = $currentDate->format('n');
$currentDateDay = $currentDate->format('d');
$currentDateYear = $currentDate->format('Y');

$startDate = "$startDateDay $nama_bulan[$startDateMonth] $startDateYear";
$currentDate = "$currentDateDay $nama_bulan[$currentDateMonth] $currentDateYear";

if (isset($_SESSION['profile'])) {
  $id_pengguna = $_SESSION['profile']->id;

  // mendapatkan total pemasukan kas
  $kas = getTotalKasByTipe($id_pengguna);
  $total = $kas->total;
  $totalDebit = $kas->pemasukan;
  $totalCredit = $kas->pengeluaran;

  // mendapatkan list kas
  $resultQueryGetAllKas = getAllKas($id_pengguna);
} else {
  header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Kas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <header class="navbar shadow-sm mb-3">
    <div class="container-fluid">
      <div></div>
      <h1 class="navbar-brand mb-0 h1">Kas</h1>
      <div></div>
    </div>
  </header>
  <main class="container">
    <?php if (isset($_COOKIE['kas_message'])) : ?>
      <div class="alert alert-success">
        <?php echo $_COOKIE['kas_message'] ?>
      </div>
    <?php endif; ?>
    <section class="mb-5">
      <div class="mb-3">
        <div class="row justify-content-between ">
          <div class="col-auto">
            <div class="dropdown">
              <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Urutkan</button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="kas.php?sort=terbaru">Terbaru</a></li>
                <li><a class="dropdown-item" href="kas.php?sort=terlama">Terlama</a></li>
              </ul>
            </div>
          </div>
          <div class="col-auto">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">Filter <i class="fa-solid fa-filter"></i></button>
            <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="filterModalLabel">Filter berdasarkan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form>
                    <div class="modal-body">
                      <div class="mb-3">
                        <h2 class="fs-5">Rentang tanggal</h2>
                        <div class="row row-gap-2 ">
                          <div class="col">
                            <label for="dari">Dari</label>
                            <input class="form-control" value="<?php echo $_GET['from'] ?? date('Y-m-01'); ?>" type="date" name="from" id="date-dari">
                          </div>
                          <div class="col">
                            <label for="dari">Sampai</label>
                            <input class="form-control" value="<?php echo $_GET['to'] ?? date('Y-m-d'); ?>" type="date" name="to" id="date-sampai">
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <h2 class="fs-5">Jenis</h2>
                        <input type="checkbox" <?php echo isset($_GET['pemasukan']) ? 'checked' : ''?> class="btn-check" name="pemasukan" value="1" id="pemasukan" />
                        <label for="pemasukan" class="btn btn-outline-primary">Pemasukan</label>
                        <input type="checkbox" <?php echo isset($_GET['pengeluaran']) ? 'checked' : ''?> class="btn-check" name="pengeluaran" value="2" id="pengeluaran">
                        <label for="pengeluaran" class="btn btn-outline-primary">Pengeluaran</label>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-secondary" name="reset-filter" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary" name="submit-filter">Simpan Perubahan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-between row-gap-3 ">
        <div class="col-12 text-center">
          <h2 class="fs-2">Total Saldo</h2>
          <div>Periode <?php echo "$startDate - $currentDate" ?></div>
          <div class="text-primary fw-bold mb-2 fs-1"><?php echo "Rp" . number_format($total, 0, ',', '.') ?></div>
        </div>
        <div class="col-auto">
          <h2 class="fs-6 text-center">Total Pemasukan</h2>
          <div class="text-success fw-bold mb-2 fs-5"><i class="fa fa-arrow-up"></i> <?php echo "Rp" . number_format($totalDebit, 0, ',', '.') ?></div>
        </div>
        <div class="col-auto">
          <h2 class="fs-6 text-center">Total Pengeluaran</h2>
          <div class="text-danger fw-bold mb-2 fs-5"><i class="fa fa-arrow-down"></i> <?php echo "Rp" . number_format($totalCredit, 0, ',', '.') ?></div>
        </div>
      </div>
      <a href="form-add-kas.php" class="btn btn-primary w-100 ">
        Catat kas baru
      </a>
    </section>
    <section>
      <?php if ($resultQueryGetAllKas) : ?>
        <div class="d-flex flex-column row-gap-3"> 
          <?php foreach ($resultQueryGetAllKas as $row) : ?>
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
    </section>
    <?php include '../components/bottom-nav.php' ?>
  </main>
</body>

</html>