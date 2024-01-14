<?php
require '../configs/db.php';

$message = '';

if (isset($_POST['daftar'])) {
  $no_hp = $_POST['no_hp'];
  $password = $_POST['password'];

  $password_verified = password_verify($password, '');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/welcome.css">
</head>

<body>
  <header class="text-center p-3">
    <h1>Selamat Datang di Camas</h1>
    <p>
      Camas (Catat kas Masjid) merupakan aplikasi pencatatan kas berbasis web yang dikembangkan untuk mencatat pemasukan dan pengeluaran kas masjid.<br>
      Silakan klik Daftar untuk membuat akun DKM masjid. Jika sudah memiliki akun silakan klik Masuk.
    </p>
  </header>
  <main class="container py-3">
    <div class="d-flex justify-content-between column-gap-3">
      <a href="./login.php" class="btn btn-primary w-100">Masuk</a>
      <a href="./register.php" class="btn btn-outline-primary w-100">Daftar</a>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>