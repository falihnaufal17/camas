<?php
session_start();

function login()
{
  include "../configs/db.php";
  if (
    !empty($_POST['no_hp']) &&
    !empty($_POST['password'])
  ) {
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];

    try {
      $sqlGetUserByPhone = "SELECT * FROM pengguna WHERE no_hp = ?";
      $stmtGetUserByPhone = $conn->prepare($sqlGetUserByPhone);
      $stmtGetUserByPhone->execute([$no_hp]);
      $rowGetUserByPhone = $stmtGetUserByPhone->fetchObject();

      if (!$rowGetUserByPhone) {
        $error_message['no_hp'] = LABEL_FORM_LOGIN['no_hp'] . " belum terdaftar";
        
        return $error_message;
      }

      $password_verified = password_verify($password, $rowGetUserByPhone->password);

      if (!$password_verified) {
        $error_message['password'] = LABEL_FORM_LOGIN['password'] . " salah";

        return $error_message;
      }

      $_SESSION['profile'] = $rowGetUserByPhone;
    } catch (PDOException $e) {
      echo "Registration failed: " . $e->getMessage();
    }
  } else {
    foreach ($_POST as $key => $value) {
      if ($key !== 'masuk' && $value === '') {
        $error_message[$key] = LABEL_FORM_LOGIN[$key] . " harus diisi";
      }
    }
    return $error_message;
  }
}
