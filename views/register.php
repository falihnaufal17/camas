<?php
require '../configs/db.php';

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
  if (
    !empty($_POST['nama']) &&
    !empty($_POST['no_hp']) &&
    !empty($_POST['alamat']) &&
    !empty($_POST['nama_masjid']) &&
    !empty($_POST['alamat_masjid']) &&
    !empty($_POST['password']) &&
    !empty($_POST['konfirmasi_password'])
  ) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $nama_masjid = $_POST['nama_masjid'];
    $alamat_masjid = $_POST['alamat_masjid'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password === $konfirmasi_password) {
      $password_hashed = password_hash($password, PASSWORD_BCRYPT);

      // cari nomor hp yang sudah terdaftar
      $sqlGetUserByPhone = "SELECT COUNT(*) AS total FROM pengguna WHERE no_hp = '$no_hp'";
      $resultQueryGetUserByPhone = $conn->query($sqlGetUserByPhone);
      $rowUser = $resultQueryGetUserByPhone->fetch_assoc();
      $userExists = intval($rowUser['total']);

      if ($userExists > 0) {
        $error_message['no_hp'] = LABEL_FORM['no_hp'] . " Nomor Hp sudah terdaftar";
      } else {
        $sql = "INSERT INTO pengguna (nama, no_hp, alamat, nama_masjid, alamat_masjid, id_jabatan, password) VALUES ('$nama', '$no_hp', '$alamat', '$nama_masjid', '$alamat_masjid', 1, '$password_hashed')";
      
        if ($conn->query($sql)) {
          setcookie('register_message', "Registrasi DKM berhasil. Silakan masuk.", time() + 5);

          $conn->close();
          header('Location: login.php');
        } else {
          setcookie('register_message', "ERROR: $sql <br> $conn->error", time() + 5);
        }
      }
    } else {
      $error_message = [
        "konfirmasi_password" => "Konfirmasi password tidak sama"
      ];
    }
  } else {
    foreach($_POST as $key => $value) {
      if ($key !== 'daftar' && $value === '') {
        $error_message[$key] = LABEL_FORM[$key] . " harus diisi";
      }
    }
  }
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