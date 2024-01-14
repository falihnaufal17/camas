<?php
session_start();

if (!isset($_SESSION['profile'])) {
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
      <h1 class="navbar-brand mb-0 h1">Profil</h1>
      <div></div>
    </div>
  </header>
  <main class="container">
    <nav class="nav shadow bottom-nav justify-content-between px-3 py-2">
      <a href="home.php" class="text-center text-decoration-none text-dark">
        <div>
          <i class="fa fa-home"></i>
        </div>
        <small>Beranda</small>
      </a>
      <a href="kas.php" class="text-center text-decoration-none text-dark">
        <div>
          <i class="fa fa-wallet"></i>
        </div>
        <small>Kas</small>
      </a>
      <a href="profile.php" class="text-center text-decoration-none">
        <div>
          <i class="fa fa-user"></i>
        </div>
        <small>Profil</small>
      </a>
    </nav>
  </main>
</body>

</html>