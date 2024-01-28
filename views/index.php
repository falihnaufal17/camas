<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
    $title = '';
    $pageExplode = isset($_GET['page']) ? explode('-', $_GET['page']) : [];
    array_pop($pageExplode);

    foreach ($pageExplode as $item) {
      $title .= ' '. $item;
    }
  ?>
  <title>Camas <?= $title ? '|' . $title : '' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1ba5ca05fe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/welcome.css">
  <link rel="stylesheet" href="../assets/css/member.css">
</head>

<body>
  <?php
  session_start();
  date_default_timezone_set('Asia/Jakarta');

  if (isset($_GET['page'])) {
    if ($_GET['page'] === 'login-page') {
      include './login.php';
    } else if ($_GET['page'] === 'register-page') {
      include './register.php';
    } else if ($_GET['page'] === 'home-page') {
      include './home.php';
    } else if ($_GET['page'] === 'kas-page') {
      include './kas.php';
    } else if ($_GET['page'] === 'profile-page') {
      include './profile.php';
    } else if ($_GET['page'] === 'form-add-kas-page') {
      include './form-add-kas.php';
    } else if ($_GET['page'] === 'delete-kas-page') {
      include '../actions/delete-kas.php';
    } else if ($_GET['page'] === 'form-edit-kas-page') {
      include './form-edit-kas.php';
    } else if ($_GET['page'] === 'form-add-member-page') {
      include './form-add-member.php';
    } else if ($_GET['page'] === 'members-page') {
      include './members.php';
    } else if ($_GET['page'] === 'form-edit-member-page') {
      include './form-edit-member.php';
    } else if ($_GET['page'] === 'delete-member-page') {
      include '../actions/delete-member.php';
    } else {
      echo "<h1>404 Not Found</h1>";
    }
  } else {
    include '../views/welcome.php';
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>