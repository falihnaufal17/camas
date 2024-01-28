<?php
include "../controllers/profile.php";

$error_message = [];

define("LABEL_FORM_UPDATE_PERSONAL", [
  'nama' => 'Nama',
  'no_hp' => 'No. Hp'
]);

define("LABEL_FORM_UPDATE_ADDRESS", [
  'alamat' => 'Alamat',
  'nama_masjid' => 'Nama Masjid',
  'alamat_masjid' => 'Alamat Masjid',
]);

if (isset($_POST['logout'])) {
  logout();
}

if (!isset($_SESSION['profile'])) {
  header('Location: index.php?page=login-page');
}

$dataProfile = getProfile($_SESSION['profile']->id);
$dataJabatan = getJabatan();

if (isset($_POST['update-personal'])) {
  if (!empty($_POST['nama']) && !empty($_POST['no_hp'])) {
    updateProfile($dataProfile);
  } else {
    foreach ($_POST as $key => $value) {
      if ($key !== 'update-personal' && empty($value)) {
        $error_message[$key] = LABEL_FORM_UPDATE_PERSONAL[$key] . ' harus diisi.';
      }
    }
  }
}

if (isset($_POST['update-address'])) {
  if (!empty($_POST['alamat']) && !empty($_POST['nama_masjid']) && !empty($_POST['alamat_masjid'])) {
    updateProfile($dataProfile);
  } else {
    foreach ($_POST as $key => $value) {
      if ($key !== 'update-address' && empty($value)) {
        $error_message[$key] = LABEL_FORM_UPDATE_ADDRESS[$key] . ' harus diisi.';
      }
    }
  }
}

?>

<header class="navbar shadow-sm mb-3">
  <div class="container-fluid">
    <div></div>
    <h1 class="navbar-brand mb-0 h1">Profil</h1>
    <div></div>
  </div>
</header>
<main class="container">
  <?php if (isset($_COOKIE['profile_message'])) : ?>
    <div class="alert alert-success">
      <?= $_COOKIE['profile_message'] ?>
    </div>
  <?php endif ?>
  <section class="card mb-3">
    <form method="POST">
      <div class="card-header d-flex justify-content-between align-items-center ">
        <h5 class="card-title mb-0">Informasi Pribadi</h5>
        <?php if (!isset($_GET['edit-address'])) : ?>
          <?php if (isset($_GET['edit-personal'])) : ?>
            <div>
              <button type="submit" name="update-personal" class="btn btn-success btn-sm">Simpan</button>
              <a href="index.php?page=profile-page" class="btn btn-danger btn-sm">Batal</a>
            </div>
          <?php else : ?>
            <a href="index.php?page=profile-page&edit-personal=true" class="btn btn-primary btn-sm">Ubah</a>
          <?php endif ?>
        <?php endif ?>
      </div>
      <div class="card-body">
        <div class="row row-gap-2">
          <div class="col-6">
            <label for="nama" class="fw-bold">Nama Pengguna</label>
          </div>
          <div class="col-6 text-capitalize ">
            <?php if (isset($_GET['edit-personal'])) : ?>
              <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $dataProfile->nama ?>">
              <small class="text-danger"><?= $error_message['nama'] ?? '' ?></small>
            <?php else : ?>
              <?= $dataProfile->nama ?>
            <?php endif ?>
          </div>
          <div class="col-6">
            <label for="no_hp" class="fw-bold">No. Hp</label>
          </div>
          <div class="col-6 text-capitalize ">
            <?php if (isset($_GET['edit-personal'])) : ?>
              <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo $dataProfile->no_hp ?>">
              <small class="text-danger"><?= $error_message['no_hp'] ?? '' ?></small>
            <?php else : ?>
              <?= $dataProfile->no_hp ?>
            <?php endif ?>
          </div>
          <div class="col-6">
            <label for="id_jabatan" class="fw-bold">Jabatan</label>
          </div>
          <div class="col-6 text-capitalize ">
            <?= $dataProfile->nama_jabatan ?>
          </div>
          <?php if ($dataProfile->id_jabatan === 1) : ?>
            <div class="col-6">
              <label for="jumlah_anggota" class="fw-bold">Jumlah Anggota</label>
            </div>
            <div class="col-6 text-capitalize ">
              <?= $dataProfile->jumlah_anggota ?> <a href="index.php?page=members-page">Lihat Semua</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </section>
  <section class="card mb-5">
    <form method="post">
      <div class="card-header d-flex justify-content-between align-items-center ">
        <h5 class="card-title mb-0">Informasi Alamat</h5>
        <?php if (!isset($_GET['edit-personal'])) : ?>
          <?php if (isset($_GET['edit-address'])) : ?>
            <div>
              <button type="submit" name="update-address" class="btn btn-success btn-sm">Simpan</button>
              <a href="index.php?page=profile-page" class="btn btn-danger btn-sm">Batal</a>
            </div>
          <?php else : ?>
            <a href="index.php?page=profile-page&edit-address=true" class="btn btn-primary btn-sm">Ubah</a>
          <?php endif ?>
        <?php endif ?>
      </div>
      <div class="card-body">
        <div class="row row-gap-2">
          <div class="col-6">
            <label class="fw-bold" for="alamat">Alamat</label>
          </div>
          <div class="col-6">
            <?php if (isset($_GET['edit-address'])) : ?>
              <textarea name="alamat" id="alamat" class="form-control"><?= $dataProfile->alamat ?></textarea>
              <small class="text-danger"><?= $error_message['alamat'] ?? '' ?></small>
            <?php else : ?>
              <?= $dataProfile->alamat ?>
            <?php endif ?>
          </div>
          <div class="col-6">
            <label class="fw-bold" for="nama_masjid">Nama Masjid</label>
          </div>
          <div class="col-6">
            <?php if (isset($_GET['edit-address'])) : ?>
              <input name="nama_masjid" id="nama_masjid" class="form-control" value="<?= $dataProfile->nama_masjid ?>">
              <small class="text-danger"><?= $error_message['nama_masjid'] ?? '' ?></small>
            <?php else : ?>
              <?= $dataProfile->nama_masjid ?>
            <?php endif ?>
          </div>
          <div class="col-6">
            <label class="fw-bold" for="alamat_masjid">Alamat Masjid</label>
          </div>
          <div class="col-6">
            <?php if (isset($_GET['edit-address'])) : ?>
              <textarea name="alamat_masjid" id="alamat_masjid" class="form-control"><?= $dataProfile->alamat_masjid ?></textarea>
              <small class="text-danger"><?= $error_message['alamat_masjid'] ?? '' ?></small>
            <?php else : ?>
              <?= $dataProfile->alamat_masjid ?>
            <?php endif ?>
          </div>
        </div>
      </div>
    </form>
  </section>
  <form method="post">
    <button type="submit" name="logout" class="btn btn-danger w-100">Keluar <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
  </form>
  <?php include '../components/bottom-nav.php' ?>
</main>