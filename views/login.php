<?php

include "../controllers/login.php";

$error_message = [];

define('LABEL_FORM_LOGIN', [
  'no_hp' => 'No Hp',
  'password' => 'Password'
]);

if (isset($_POST['masuk'])) {
  $error_message = login();
}

if (isset($_SESSION['profile'])) {
  header('Location: index.php?page=home-page');
}

?>

<nav class="navbar  mb-3 shadow-sm ">
  <div class="container-fluid">
    <a href="index.php" class="text-dark">
      <i class="fa-solid fa-arrow-left fs-5"></i>
    </a>
    <span class="navbar-brand mb-0 h1">Masuk</span>
    <div></div>
  </div>
</nav>
<main class="container py-3 d-flex flex-column justify-content-center">
  <?php if (isset($_COOKIE['register_message'])) : ?>
    <div class="alert alert-success" role="alert">
      <?php echo $_COOKIE['register_message'] ?>
    </div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label>No Hp</label>
      <input type="tel" name="no_hp" class="form-control <?php echo isset($error_message['no_hp']) ? 'border-danger' : '' ?>" value="<?php echo $_POST['no_hp'] ?? '' ?>" />
      <small class="text-danger">
        <?php echo isset($error_message['no_hp']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['no_hp'] : ''; ?>
      </small>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control <?php echo isset($error_message['password']) ? 'border-danger' : '' ?>" value="<?php echo $_POST['password'] ?? '' ?>" />
      <small class="text-danger">
        <?php echo isset($error_message['password']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['password'] : ''; ?>
      </small>
    </div>
    <button type="submit" class="btn btn-outline-primary mb-3 w-100" name="masuk">Masuk</button>
    <div>
      Belum punya akun DKM?
      <br />buat akun DKM <a href="./index.php?page=register-page">di sini</a>
    </div>
  </form>
</main>