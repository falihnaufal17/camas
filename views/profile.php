<?php
include "../controllers/profile.php";

if (isset($_POST['logout'])) {
  logout();
}

if (!isset($_SESSION['profile'])) {
  header('Location: index.php?page=login-page');
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
  <form method="post">
    <button type="submit" name="logout" class="btn btn-danger rounded">Keluar <i class="fa-solid fa-arrow-right-from-bracket"></i> </button>
  </form>
  <?php include '../components/bottom-nav.php' ?>
</main>