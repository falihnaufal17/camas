<?php
include "../configs/db.php";
include "../controllers/member.php";

$error_message = [];

define("LABEL_FORM_SAVE_MEMBER", [
  'nama' => 'Nama',
  'no_hp' => 'No Hp',
  'alamat' => 'Alamat',
  'password' => 'Password'
]);

if (!isset($_SESSION['profile'])) {
  header('Location: index.php?page=login-page');
}

if (isset($_POST['save'])) {
  $nama = $_POST['nama'];
  $no_hp = $_POST['no_hp'];
  $alamat = $_POST['alamat'];
  $password = $_POST['password'];
  if (
    !empty($nama) &&
    !empty($no_hp) &&
    !empty($alamat) &&
    !empty($password)
  ) {
    try {
      // cari nomor hp yang sudah terdaftar
      $sqlGetUserByPhone = "SELECT COUNT(*) AS total FROM pengguna WHERE no_hp = ?";
      $stmtGetUserByPhone = $conn->prepare($sqlGetUserByPhone);
      $stmtGetUserByPhone->execute([$no_hp]);
      $rowGetUserByPhone = $stmtGetUserByPhone->fetchObject();
      $userExists = intval($rowGetUserByPhone->total);

      if ($userExists > 0) {
        $error_message['no_hp'] = LABEL_FORM_SAVE_MEMBER['no_hp'] . " Nomor Hp sudah terdaftar";
      } else {
        saveMember();
      }

    } catch (PDOException $e) {
      setcookie('member_message', "ERROR: " . $e->getMessage() . "", time() + 5);
    }
  } else {
    foreach ($_POST as $key => $value) {
      if ($key !== 'save' && empty($value)) {
        $error_message[$key] = LABEL_FORM_SAVE_MEMBER[$key] . ' harus diisi.';
      }
    }
  }
}

?>

<header class="navbar shadow-sm mb-3">
  <div class="container-fluid">
    <a href="index.php?page=members-page" class="text-dark">
      <i class="fa-solid fa-arrow-left fs-5"></i>
    </a>
    <h1 class="navbar-brand mb-0 h1">Tambah Anggota</h1>
    <div></div>
  </div>
</header>
<main class="container">
  <?php if (isset($_COOKIE['member_message'])) : ?>
    <div class="alert alert-success">
      <?= $_COOKIE['member_message'] ?>
    </div>
  <?php endif ?>
  <section class="card mb-3">
    <div class="card-body">
      <form method="POST">
        <input type="hidden" value="2" name="id_jabatan" />
        <input type="hidden" value="<?= $_SESSION['profile']->id ?>" name="id_dkm" />
        <input type="hidden" value="<?= $_SESSION['profile']->nama_masjid ?>" name="nama_masjid" />
        <input type="hidden" value="<?= $_SESSION['profile']->alamat_masjid ?>" name="alamat_masjid" />
        <div class="mb-3">
          <label for="nama">Nama Lengkap</label>
          <input type="text" class="form-control" placeholder="Masukan nama lengkap" value="<?= $_POST['nama'] ?? '' ?>" name="nama" />
          <small class="text-danger">
            <?php echo isset($error_message['nama']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['nama'] : ''; ?>
          </small>
        </div>
        <div class="mb-3">
          <label for="no_hp">No Hp</label>
          <input type="tel" class="form-control" placeholder="Masukan no hp" value="<?= $_POST['no_hp'] ?? '' ?>" name="no_hp" />
          <small class="text-danger">
            <?php echo isset($error_message['no_hp']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['no_hp'] : ''; ?>
          </small>
        </div>
        <div class="mb-3">
          <label for="alamat">Alamat</label>
          <textarea class="form-control" name="alamat" placeholder="Masukan alamat"><?= $_POST['alamat'] ?? '' ?></textarea>
          <small class="text-danger">
            <?php echo isset($error_message['alamat']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['alamat'] : ''; ?>
          </small>
        </div>
        <div class="mb-3">
          <label for="password">Password</label>
          <input type="password" class="form-control" value="<?= $_POST['password'] ?? '' ?>" name="password" placeholder="Masukan password" />
          <small class="text-danger">
            <?php echo isset($error_message['password']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['password'] : ''; ?>
          </small>
        </div>
        <button type="submit" name="save" class="btn btn-primary w-100">Simpan</button>
      </form>
    </div>
  </section>
</main>