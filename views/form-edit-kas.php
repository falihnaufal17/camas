<?php
  include '../controllers/kas.php';

  $error_messages = [];

  define("LABEL_FORM_UPDATE_KAS", [
    'tipe' => 'Tipe',
    'tanggal' => 'Tanggal',
    'uraian' => 'Uraian',
    'nominal' => 'Nominal'
  ]);

  if (isset($_GET['id'])) {
    $detail = getDetailKas($_GET['id']);
  }

  if (isset($_POST['update'])) {
    if (!empty($_POST['tipe']) && !empty($_POST['tanggal']) && !empty($_POST['uraian']) && !empty($_POST['nominal'])) {
      updateKas($_GET['id'], $_SESSION['profile']->id);
    } else {
      foreach ($_POST as $key => $value) {
        if ($key !== 'update' && empty($value)) {
          $error_messages[$key] = LABEL_FORM_UPDATE_KAS[$key] . " harus diisi";
        }
      }
    }
  }

?>
<header class="navbar shadow-sm mb-3">
  <div class="container-fluid">
    <a href="index.php?page=kas-page&<?php echo "from=" . date('Y-m-01') . "&to=" . date('Y-m-d') ?>" class="text-dark">
      <i class="fa-solid fa-arrow-left fs-5"></i>
    </a>
    <h1 class="navbar-brand mb-0 h1">Ubah Kas</h1>
    <div></div>
  </div>
</header>
<main class="container">
  <form method="post">
    <div class="mb-3">
      <label for="tipe">Tipe</label>
      <select class="form-select" name="tipe" id="tipe" value="<?php echo $detail['tipe'] ?? "" ?>">
        <option value="" <?php echo !isset($detail['tipe']) ? 'selected' : '' ?>>Pilih tipe</option>
        <option value="1" <?php echo isset($detail['tipe']) && $detail['tipe'] === "1" ? 'selected' : '' ?>>Pemasukan</option>
        <option value="2" <?php echo isset($detail['tipe']) && $detail['tipe'] === "2" ? 'selected' : '' ?>>Pengeluaran</option>
      </select>
      <small class="text-danger"><?php echo $error_messages['tipe'] ?? '' ?></small>
    </div>
    <div class="mb-3">
      <label for="tanggal">Tanggal</label>
      <input class="form-control" type="date" name="tanggal" id="tanggal" value="<?php echo explode(' ', $detail['tanggal'])[0] ?? '' ?>">
      <small class="text-danger"><?php echo $error_messages['tanggal'] ?? '' ?></small>
    </div>
    <div class="mb-3">
      <label for="uraian">Uraian</label>
      <textarea class="form-control" name="uraian" id="uraian"><?php echo $detail['uraian'] ?? '' ?></textarea>
      <small class="text-danger"><?php echo $error_messages['uraian'] ?? '' ?></small>
    </div>
    <div class="mb-3">
      <label for="nominal">Nominal</label>
      <input class="form-control" type="tel" name="nominal" id="nominal" value="<?php echo $detail['nominal'] ?? '' ?>">
      <small class="text-danger"><?php echo $error_messages['nominal'] ?? '' ?></small>
    </div>
    <button class="btn btn-outline-primary w-100" type="submit" name="update">Ubah</button>
  </form>
</main>