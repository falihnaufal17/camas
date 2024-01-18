<?php 
  function register() {
    include "../configs/db.php";
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
        
        try {
          // cari nomor hp yang sudah terdaftar
          $sqlGetUserByPhone = "SELECT COUNT(*) AS total FROM pengguna WHERE no_hp = ?";
          $stmtGetUserByPhone = $conn->prepare($sqlGetUserByPhone);
          $stmtGetUserByPhone->execute([$no_hp]);
          $rowGetUserByPhone = $stmtGetUserByPhone->fetchObject();
          $userExists = intval($rowGetUserByPhone->total);

          if ($userExists > 0) {
            $error_message['no_hp'] = LABEL_FORM['no_hp'] . " Nomor Hp sudah terdaftar";
            return $error_message;
          } else {
            $sqlInsertNewUser = "INSERT INTO pengguna 
            (nama, no_hp, alamat, nama_masjid, alamat_masjid, id_jabatan, password)
            VALUES (?,?,?,?,?,?,?)";
            $stmtInsertNewUser = $conn->prepare($sqlInsertNewUser);
            $stmtInsertNewUser->execute([$nama, $no_hp, $alamat, $nama_masjid, $alamat_masjid, 1, $password_hashed]);

            setcookie('register_message', "Registrasi DKM berhasil. Silakan masuk.", time() + 5);
            header('Location: index.php?page=login-page');
          }
        } catch (PDOException $e) {
          setcookie('register_message', "ERROR: " . $e->getMessage() . "", time() + 5);
        }
      } else {
        $error_message = [
          "konfirmasi_password" => "Konfirmasi password tidak sama"
        ];

        return $error_message;
      }
    } else {
      foreach($_POST as $key => $value) {
        if ($key !== 'daftar' && $value === '') {
          $error_message[$key] = LABEL_FORM[$key] . " harus diisi";
        }
      }

      return $error_message;
    }
  }
?>