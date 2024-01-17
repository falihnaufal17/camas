<?php
include_once "../controllers/register.php";

$error_message = [];
$message = '';
define('LABEL_FORM', [
  'nama' => 'Nama',
  'no_hp' => 'No Hp',
  'alamat' => 'Alamat',
  'nama_masjid' => 'Nama Masjid',
  'alamat_masjid' => 'Alamat Masjid',
  'password' => 'Password',
  'konfirmasi_password' => 'Konfirmasi Password'
]);

if (isset($_POST['daftar'])) {
  $error_message = register();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Registrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
</head>

<body>
  <nav class="navbar shadow-sm">
    <div class="container-fluid">
      <a href="javascript:history.go(-1)" class="text-dark">
        <i class="fa-solid fa-arrow-left fs-5"></i>
      </a>
      <span class="navbar-brand mb-0 h1">Pendaftaran DKM</span>
      <div></div>
    </div>
  </nav>
  <main class="container py-3">
    <form method="post" class="needs-validation">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input
          type="text"
          name="nama"
          value="<?php echo $_POST['nama'] ?>"
          id="nama"
          class="form-control <?php echo $error_message['nama'] ? 'border-danger' : '' ?>"
        />
        <small class="text-danger">
          <?php echo $error_message['nama'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['nama'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>No Hp</label>
        <input
          type="tel"
          name="no_hp"
          value="<?php echo $_POST['no_hp'] ?>"
          class="form-control <?php echo $error_message['no_hp'] ? 'border-danger' : '' ?>"
        />
        <small class="text-danger">
          <?php echo $error_message['no_hp'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['no_hp'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Alamat</label>
        <textarea
          name="alamat"
          class="form-control <?php echo $error_message['alamat'] ? 'border-danger' : '' ?>"><?php echo $_POST['alamat'] ?></textarea>
        <small class="text-danger">
          <?php echo $error_message['alamat'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['alamat'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Nama Masjid</label>
        <input
          type="text"
          name="nama_masjid"
          value="<?php echo $_POST['nama_masjid'] ?>"
          class="form-control <?php echo $error_message['nama_masjid'] ? 'border-danger' : '' ?>"
        />
        <small class="text-danger">
          <?php echo $error_message['nama_masjid'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['nama_masjid'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Alamat Masjid</label>
        <textarea
          name="alamat_masjid"
          class="form-control <?php echo $error_message['alamat_masjid'] ? 'border-danger' : '' ?>"><?php echo $_POST['alamat_masjid'] ?></textarea>
        <small class="text-danger">
          <?php echo $error_message['alamat_masjid'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['alamat_masjid'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input
          type="password"
          value="<?php echo $_POST['password'] ?>"
          name="password"
          class="form-control <?php echo $error_message['password'] ? 'border-danger' : '' ?>"
        />
        <small class="text-danger">
          <?php echo $error_message['password'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['password'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input
          type="password"
          value="<?php echo $_POST['konfirmasi_password'] ?>"
          name="konfirmasi_password"
          class="form-control <?php echo $error_message['konfirmasi_password'] ? 'border-danger' : '' ?>"
        />
        <small class="text-danger">
          <?php echo $error_message['konfirmasi_password'] ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['konfirmasi_password'] : ''; ?>
        </small>
      </div>
      <button type="submit" class="btn btn-outline-primary w-100" name="daftar">Daftar</button>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>