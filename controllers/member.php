<?php
function saveMember() {
  include "../configs/db.php";

  $id_jabatan = $_POST['id_jabatan'];
  $id_dkm = $_POST['id_dkm'];
  $nama_masjid = $_POST['nama_masjid'];
  $alamat_masjid = $_POST['alamat_masjid'];
  $nama = $_POST['nama'];
  $no_hp = $_POST['no_hp'];
  $alamat = $_POST['alamat'];
  $password = $_POST['password'];
  
  $password_hashed = password_hash($password, PASSWORD_BCRYPT);

  try {
    $sqlInsertNewUser = "INSERT INTO pengguna 
    (nama, no_hp, alamat, nama_masjid, alamat_masjid, id_jabatan, id_dkm, password)
    VALUES (?,?,?,?,?,?,?,?)";
    $stmtInsertNewUser = $conn->prepare($sqlInsertNewUser);
    $stmtInsertNewUser->execute([$nama, $no_hp, $alamat, $nama_masjid, $alamat_masjid, $id_jabatan, $id_dkm, $password_hashed]);

    setcookie('member_message', "Registrasi Anggota baru berhasil.", time() + 5);
    header('Location: index.php?page=members-page');
  } catch (PDOException $th) {
    setcookie('member_message', "ERROR: " . $e->getMessage() . "", time() + 5);
  }
}

function updateMember($id) {
  include "../configs/db.php";

  $nama = $_POST['nama'];
  $no_hp = $_POST['no_hp'];
  $alamat = $_POST['alamat'];

  try {
    $sqlUpdateMember = "UPDATE pengguna SET
    nama=?, no_hp=?, alamat=?
    WHERE id = ?";
    $stmtUpdateMember = $conn->prepare($sqlUpdateMember);
    $stmtUpdateMember->execute([$nama, $no_hp, $alamat, $id]);

    setcookie('member_message', "Update Anggota berhasil.", time() + 5);
    header('Location: index.php?page=members-page');
  } catch (PDOException $th) {
    setcookie('member_message', "ERROR: " . $e->getMessage() . "", time() + 5);
  }
}

function getListAnggota() {
  include "../configs/db.php";

  $id_dkm = $_SESSION['profile']->id;
  $whereClause = '';
  $params[] = $id_dkm;

  try {
    if (isset($_POST['search'])) {
      $params[] = '%' . $_POST['search'] . '%';
      $whereClause = " AND nama LIKE ?";
    }
    $sqlGetListAnggota = "SELECT id, nama, no_hp, alamat FROM pengguna
    WHERE id_dkm = ?" . $whereClause;
    $stmtGetListAnggota = $conn->prepare($sqlGetListAnggota);

    $stmtGetListAnggota->execute($params);

    $data = $stmtGetListAnggota->fetchAll(PDO::FETCH_OBJ);

    return $data;
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); 
  }
}

function anggotaById($id) {
  include "../configs/db.php";

  try {
    $sqlGetAnggotaById = "SELECT id, nama, no_hp, alamat FROM pengguna WHERE id=?";
    $stmtGetAnggotaById = $conn->prepare($sqlGetAnggotaById);
    
    $stmtGetAnggotaById->execute([$id]);

    $data = $stmtGetAnggotaById->fetchObject();

    return $data;
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); 
  }
}

function deleteAnggota($id) {
  include "../configs/db.php";

  try {
    $sqlDeleteAnggota = "DELETE FROM pengguna WHERE id=?";
    $stmtDeleteAnggota = $conn->prepare($sqlDeleteAnggota);
    
    $stmtDeleteAnggota->execute([$id]);

    setcookie('member_message', "Hapus Anggota berhasil.", time() + 5);
    header('Location: index.php?page=members-page');
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); 
  }
}