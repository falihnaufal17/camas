<?php
  include '../controllers/kas.php';

  session_start();

  define("LABEL_FORM_PEMASUKAN", [
    'date' => 'Tanggal',
    'uraian' => 'Uraian',
    'nominal' => 'Nominal'
  ]);
  define("LABEL_FORM_PENGELUARAN", [
    'date-pengeluaran' => 'Tanggal',
    'uraian-pengeluaran' => 'Uraian',
    'nominal-pengeluaran' => 'Nominal'
  ]);
  $error_messages = [];

  if (isset($_SESSION['profile'])) {
    $pengguna_id = $_SESSION['profile']->id;
    $error_messages = addKas($pengguna_id);
  } else {
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Catat Kas Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <header class="navbar shadow-sm mb-3">
    <div class="container-fluid">
      <a href="./kas.php" class="text-dark">
        <i class="fa-solid fa-arrow-left fs-5"></i>
      </a>
      <h1 class="navbar-brand mb-0 h1">Catat Kas Baru</h1>
      <div></div>
    </div>
  </header>
  <main class="container">
    <ul class="nav nav-pills mb-3 justify-content-between border border-1 border-primary rounded" id="pills-tab" role="tablist">
      <li class="nav-item flex-grow-1" role="presentation">
        <button class="nav-link w-100 text-center active" id="pills-pemasukan-tab" data-bs-toggle="pill" data-bs-target="#pills-pemasukan" type="button" role="tab" aria-controls="pills-pemasukan" aria-selected="true">Pemasukan</button>
      </li>
      <li class="nav-item flex-grow-1" role="presentation">
        <button class="nav-link w-100 text-center" id="pills-pengeluaran-tab" data-bs-toggle="pill" data-bs-target="#pills-pengeluaran" type="button" role="tab" aria-controls="pills-pengeluaran" aria-selected="false">Pengeluaran</button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-pemasukan" role="tabpanel" aria-labelledby="pills-pemasukan-tab" tabindex="0">
        <form method="post">
          <input type="hidden" name="type" value="1">
          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" value="<?php echo $_POST['date'] ?>" class="form-control <?php echo $error_messages['date'] ? 'border-danger' : '' ?>" />
            <small class="text-danger"><?php echo $error_messages['date'] ?></small>
          </div>
          <div class="mb-3">
            <label>Uraian</label>
            <textarea name="uraian" class="form-control <?php echo $error_messages['uraian'] ? 'border-danger' : '' ?>"><?php echo $_POST['uraian'] ?></textarea>
            <small class="text-danger"><?php echo $error_messages['uraian'] ?></small>
          </div>
          <div class="mb-3">
            <label>Nominal</label>
            <input type="tel" name="nominal" value="<?php echo $_POST['nominal'] ?>" class="form-control <?php echo $error_messages['nominal'] ? 'border-danger' : '' ?>" />
            <small class="text-danger"><?php echo $error_messages['nominal'] ?></small>
          </div>
          <button class="btn btn-primary w-100" type="submit" name="simpan-pemasukan">Simpan</button>
        </form>
      </div>
      <div class="tab-pane fade" id="pills-pengeluaran" role="tabpanel" aria-labelledby="pills-pengeluaran-tab" tabindex="0">
        <form method="post">
          <input type="hidden" name="type-pengeluaran" value="2">
          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date-pengeluaran" value="<?php echo $_POST['date-pengeluaran'] ?>" class="form-control <?php echo $error_messages['date-pengeluaran'] ? 'border-danger' : '' ?>" />
            <small class="text-danger"><?php echo $error_messages['date-pengeluaran'] ?></small>
          </div>
          <div class="mb-3">
            <label>Uraian</label>
            <textarea name="uraian-pengeluaran" class="form-control <?php echo $error_messages['uraian-pengeluaran'] ? 'border-danger' : '' ?>"><?php echo $_POST['uraian-pengeluaran'] ?></textarea>
            <small class="text-danger"><?php echo $error_messages['uraian-pengeluaran'] ?></small>
          </div>
          <div class="mb-3">
            <label>Nominal</label>
            <input type="tel" name="nominal-pengeluaran" value="<?php echo $_POST['nominal-pengeluaran'] ?>" class="form-control <?php echo $error_messages['nominal-pengeluaran'] ? 'border-danger' : '' ?>" />
            <small class="text-danger"><?php echo $error_messages['nominal-pengeluaran'] ?></small>
          </div>
          <button class="btn btn-primary w-100" type="submit" name="simpan-pengeluaran">Simpan</button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>