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
  header('Location: home.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camas | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
</head>

<body>
  <nav class="navbar  mb-3 shadow-sm ">
    <div class="container-fluid">
      <a href="./welcome.php" class="text-dark">
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
        <input
          type="tel"
          name="no_hp"
          class="form-control <?php echo isset($error_message['no_hp']) ? 'border-danger' : '' ?>"
          value="<?php echo $_POST['no_hp'] ?? '' ?>"
        />
        <small class="text-danger">
          <?php echo isset($error_message['no_hp']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['no_hp'] : ''; ?>
        </small>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input
          type="password"
          name="password"
          class="form-control <?php echo isset($error_message['password']) ? 'border-danger' : '' ?>"
          value="<?php echo $_POST['password'] ?? '' ?>" 
        />
        <small class="text-danger">
          <?php echo isset($error_message['password']) ? '<i class="fa-solid fa-circle-exclamation"></i> ' . $error_message['password'] : ''; ?>
        </small>
      </div>
      <button type="submit" class="btn btn-outline-primary mb-3 w-100" name="masuk">Masuk</button>
      <div>
        Belum punya akun DKM?
        <br />buat akun DKM <a href="./register.php">di sini</a>
      </div>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>