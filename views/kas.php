<?php
include '../configs/db.php';

session_start();
$total = 0;
$totalCredit = 0;
$error_messages = [];

define('LABEL_FORM_FILTER', [
  'from' => 'Tanggal dari',
  'to' => 'Tanggal sampai'
]);

if (isset($_SESSION['profile'])) {
  $id_pengguna = $_SESSION['profile']['id'];

  // mendapatkan total pemasukan kas
  $sqlGetTotalKas = "SELECT
    SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END) AS pemasukan,
    SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END) AS pengeluaran
  FROM kas
  WHERE dibuat_oleh_id_pengguna = $id_pengguna
    AND tipe IN (1, 2);";
  $resultQueryGetTotalKas = $conn->query($sqlGetTotalKas);
  $rowGetTotalKas = $resultQueryGetTotalKas->fetch_assoc();
  $total = $rowGetTotalKas['pemasukan'];
  $totalCredit = $rowGetTotalKas['pengeluaran'];

  // mendapatkan list kas
  $sortDirection = 'DESC';
  $whereClause = '';

  if (isset($_GET['sort'])) {
    if ($_GET['sort'] === 'terlama') {
      $sortDirection = 'ASC';
    } else {
      $sortDirection = 'DESC';
    }
  }

  if (isset($_GET['submit-filter'])) {
    if (!empty($_GET['to'])) {
      $whereClause .= " AND kas.tanggal BETWEEN " . $_GET['from'] . " AND " . $_GET['to'] . "";
      if (isset($_GET['pemasukan'])) {
        if ($_GET['pemasukan'] === "1") {
          $whereClause .= " AND kas.tipe = 1";
        }
      }
    
      if (isset($_GET['pengeluaran'])) {
        if ($_GET['pengeluaran'] === "2") {
          $whereClause .= " AND kas.tipe = 2";
        }
      }
    } else {
      $error_messages['to'] = LABEL_FORM_FILTER['to'] . " harus diisi";
    }
  }

  $orderByClause = "ORDER BY kas.created_at $sortDirection";
  $sqlGetAllKas = "SELECT 
      kas.tipe AS tipe, kas.nominal AS nominal, kas.uraian AS uraian, kas.tanggal AS tanggal, pengguna.nama AS nama
      FROM kas 
      LEFT JOIN pengguna
      ON pengguna.id = kas.dibuat_oleh_id_pengguna
      WHERE kas.dibuat_oleh_id_pengguna = $id_pengguna"
    . $whereClause . " "
    . $orderByClause;
  $resultQueryGetAllKas = $conn->query($sqlGetAllKas);

  $conn->close();
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
    <section class="mb-5">
      <div class="row justify-content-between">
        <div class="col-auto">
          <h2 class="fs-6">Total Pemasukan</h2>
          <div class="text-primary fw-bold mb-2 fs-5"><?php echo "Rp" . number_format($total, 0, ',', '.') ?></div>
        </div>
        <div class="col-auto">
          <h2 class="fs-6">Total Pengeluaran</h2>
          <div class="text-primary fw-bold mb-2 fs-5"><?php echo "Rp" . number_format($totalCredit, 0, ',', '.') ?></div>
        </div>
      </div>
      <a href="form-add-kas.php" class="btn btn-primary w-100 ">
        Catat kas baru
      </a>
    </section>
    <section class="mb-3">
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
          <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
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
                          <input class="form-control" value="<?php echo $_GET['from'] ?>" type="date" name="from" id="date-dari" required>
                        </div>
                        <div class="col">
                          <label for="dari">Sampai</label>
                          <input class="form-control <?php echo isset($error_messages['to']) ? 'border-danger' : '' ?>" value="<?php echo $_GET['to'] ?>" type="date" name="to" id="date-sampai" required>
                          <small class="text-danger"><?php echo isset($error_messages['to']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_messages['to'] : '' ?></small>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="submit-filter">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="d-flex flex-column row-gap-3">
      <?php foreach ($resultQueryGetAllKas as $row) : ?>
        <div class="card">
          <div class="card-body row justify-content-between  align-items-center">
            <div class="col">
              <h5><?php echo $row['uraian'] ?></h5>
              <div>Tanggal: <?php echo date_format(date_create($row['tanggal']), 'd M Y'); ?></div>
              <div>Dicatat oleh: <?php echo $row['nama'] ?></div>
            </div>
            <div class="col-auto">
              <h5 class="<?php echo $row['tipe'] === '1' ? 'text-success' : 'text-danger' ?>">
                <i class="fa <?php echo $row['tipe'] === '1' ? 'fa-arrow-up' : 'fa-arrow-down' ?>"></i>
                <?php echo 'Rp' . number_format($row['nominal'], 0, ',', '.') ?>
              </h5>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
    <nav class="nav shadow bottom-nav justify-content-between px-3 py-2 bg-white ">
      <a href="home.php" class="text-center text-decoration-none text-dark">
        <div>
          <i class="fa fa-home"></i>
        </div>
        <small>Beranda</small>
      </a>
      <a href="kas.php" class="text-center text-decoration-none">
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