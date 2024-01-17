<?php
  session_start();

  function logout() {
    session_unset();
    session_destroy();
    header("Location: welcome.php");
    exit();
  }

?>