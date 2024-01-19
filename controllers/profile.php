<?php
function logout()
{
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit();
}

function getProfile($id_pengguna)
{
  include '../configs/db.php';

  try {
    $sqlGetProfile = "SELECT
      pengguna.id,
      pengguna.nama,
      pengguna.id_dkm,
      pengguna.alamat,
      pengguna.nama_masjid,
      pengguna.alamat_masjid,
      pengguna.no_hp,
      pengguna.id_jabatan,
      jabatan.nama_jabatan,
      dkm.nama AS nama_dkm,
      (SELECT COUNT(*) FROM pengguna WHERE pengguna.id_dkm = :id_dkm AND pengguna.id_jabatan = 2) AS jumlah_anggota
      FROM pengguna
      INNER JOIN jabatan ON jabatan.id = pengguna.id_jabatan
      LEFT JOIN pengguna AS dkm ON dkm.id_dkm = pengguna.id
      WHERE pengguna.id = :id_pengguna;";
    $stmtGetProfile = $conn->prepare($sqlGetProfile);

    $params = [
      ':id_dkm' => $id_pengguna,
      ':id_pengguna' => $id_pengguna
    ];

    $stmtGetProfile->execute($params);

    $dataProfile = $stmtGetProfile->fetchObject();

    return $dataProfile ?? null;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getJabatan()
{
  include '../configs/db.php';

  try {
    $sqlGetJabatan = "SELECT * FROM jabatan";
    $stmtGetJabatan = $conn->prepare($sqlGetJabatan);
    $stmtGetJabatan->execute();
    $dataJabatan = $stmtGetJabatan->fetchAll(PDO::FETCH_OBJ);

    return $dataJabatan;
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
}

function updateProfile($dataProfile)
{
  include '../configs/db.php';

  $nama = $_POST['nama'] ?? $dataProfile->nama;
  $no_hp = $_POST['no_hp'] ?? $dataProfile->no_hp;
  $alamat = $_POST['alamat'] ?? $dataProfile->alamat;
  $nama_masjid = $_POST['nama_masjid'] ?? $dataProfile->nama_masjid;
  $alamat_masjid = $_POST['alamat_masjid'] ?? $dataProfile->alamat_masjid;

  try {
    $sqlUpdateProfile = "UPDATE pengguna SET
      nama=:nama, no_hp=:no_hp, alamat=:alamat, nama_masjid=:nama_masjid, alamat_masjid=:alamat_masjid
      WHERE id=:id";
    $stmtUpdateProfile = $conn->prepare($sqlUpdateProfile);
    $params = [
      ':nama' => $nama,
      ':no_hp' => $no_hp,
      ':alamat' => $alamat,
      ':nama_masjid' => $nama_masjid,
      ':alamat_masjid' => $alamat_masjid,
      ':id' => $dataProfile->id
    ];
    $stmtUpdateProfile->execute($params);

    setcookie('profile_message', 'Berhasil mengubah data profil', time() + 5);
    header('Location: index.php?page=profile-page');
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
}
