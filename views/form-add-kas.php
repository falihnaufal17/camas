<?php
include '../controllers/kas.php';

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
  header('Location: index.php?page=login-page');
}
?>

<header class="navbar shadow-sm mb-3">
  <div class="container-fluid">
    <a href="index.php?page=kas-page&<?php echo "from=" . date('Y-m-01') . "&to=" . date('Y-m-d') ?>" class="text-dark">
      <i class="fa-solid fa-arrow-left fs-5"></i>
    </a>
    <h1 class="navbar-brand mb-0 h1">Catat Kas Baru</h1>
    <div></div>
  </div>
</header>
<main class="container">
  <ul class="nav nav-pills mb-3 justify-content-between border border-1 border-primary rounded" id="pills-tab" role="tablist">
    <li class="nav-item flex-grow-1" role="presentation">
      <a href="index.php?page=form-add-kas-page" class="nav-link w-100 text-center <?php echo isset($_GET['tab']) ? '' : 'active' ?>" id="pills-pemasukan-tab" data-bs-toggle="pill" data-bs-target="#pills-pemasukan" type="button" role="tab" aria-controls="pills-pemasukan" aria-selected="true">Pemasukan</a>
    </li>
    <li class="nav-item flex-grow-1" role="presentation">
      <a href="index.php?page=form-add-kas-page&tab=pengeluaran" class="nav-link w-100 text-center <?php echo isset($_GET['tab']) ? 'active' : '' ?>" id="pills-pengeluaran-tab" data-bs-toggle="pill" data-bs-target="#pills-pengeluaran" type="button" role="tab" aria-controls="pills-pengeluaran" aria-selected="false">Pengeluaran</a>
    </li>
  </ul>
  <?php if (isset($_COOKIE['kas_message'])) : ?>
    <div class="alert alert-success">
      <?php echo $_COOKIE['kas_message'] ?>
    </div>
  <?php endif; ?>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-pemasukan" role="tabpanel" aria-labelledby="pills-pemasukan-tab" tabindex="0">
      <form method="post">
        <input type="hidden" name="type" value="1">
        <div class="mb-3">
          <label>Tanggal</label>
          <input type="date" name="date" value="<?php echo $_POST['date'] ?? '' ?>" class="form-control <?php echo isset($error_messages['date']) ? 'border-danger' : '' ?>" />
          <small class="text-danger"><?php echo $error_messages['date'] ?? '' ?></small>
        </div>
        <div class="mb-3">
          <label>Uraian</label>
          <textarea name="uraian" class="form-control <?php echo isset($error_messages['uraian']) ? 'border-danger' : '' ?>"><?php echo $_POST['uraian'] ?? '' ?></textarea>
          <small class="text-danger"><?php echo $error_messages['uraian'] ?? '' ?></small>
        </div>
        <div class="mb-3">
          <label>Nominal</label>
          <input type="tel" name="nominal" value="<?php echo $_POST['nominal'] ?? '' ?>" class="form-control <?php echo isset($error_messages['nominal']) ? 'border-danger' : '' ?>" />
          <small class="text-danger"><?php echo $error_messages['nominal'] ?? '' ?></small>
        </div>
        <button class="btn btn-primary w-100" type="submit" name="simpan-pemasukan">Simpan</button>
      </form>
    </div>
    <div class="tab-pane fade" id="pills-pengeluaran" role="tabpanel" aria-labelledby="pills-pengeluaran-tab" tabindex="0">
      <form method="post">
        <input type="hidden" name="type-pengeluaran" value="2">
        <div class="mb-3">
          <label>Tanggal</label>
          <input type="date" name="date-pengeluaran" value="<?php echo $_POST['date-pengeluaran'] ?? '' ?>" class="form-control <?php echo $error_messages['date-pengeluaran'] ? 'border-danger' : '' ?>" />
          <small class="text-danger"><?php echo $error_messages['date-pengeluaran'] ?? '' ?></small>
        </div>
        <div class="mb-3">
          <label>Uraian</label>
          <textarea name="uraian-pengeluaran" class="form-control <?php echo isset($error_messages['uraian-pengeluaran']) ? 'border-danger' : '' ?>"><?php echo $_POST['uraian-pengeluaran'] ?? '' ?></textarea>
          <small class="text-danger"><?php echo $error_messages['uraian-pengeluaran'] ?? '' ?></small>
        </div>
        <div class="mb-3">
          <label>Nominal</label>
          <input type="tel" name="nominal-pengeluaran" value="<?php echo $_POST['nominal-pengeluaran'] ?? '' ?>" class="form-control <?php echo isset($error_messages['nominal-pengeluaran']) ? 'border-danger' : '' ?>" />
          <small class="text-danger"><?php echo $error_messages['nominal-pengeluaran'] ?? '' ?></small>
        </div>
        <button class="btn btn-primary w-100" type="submit" name="simpan-pengeluaran">Simpan</button>
      </form>
    </div>
  </div>
</main>