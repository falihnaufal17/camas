<?php
function getTotalKas($id_pengguna)
{
  include '../configs/db.php';
  $startDateOfMonth = date('Y-m-01');
  $currentDateOfMonth = date('Y-m-d');

  try {
    $sqlGetTotalKas = "SELECT
      COALESCE(SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END), 0) AS pemasukan,
      COALESCE(SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END), 0) AS pengeluaran,
      COALESCE(
        GREATEST(
          SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END) - SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END
        ), 0)
      , 0) AS total
    FROM kas
    LEFT JOIN pengguna ON pengguna.id = kas.dibuat_oleh_id_pengguna
    WHERE (
        CASE
          WHEN (select id_jabatan from pengguna where id = :id_pengguna) = 1
            THEN kas.dibuat_oleh_id_pengguna IN (select id from pengguna where id_dkm = :id_pengguna) OR pengguna.id = :id_pengguna
          ELSE kas.dibuat_oleh_id_pengguna = :id_pengguna OR pengguna.id_dkm = :id_dkm OR pengguna.id = :id_dkm
        END
      )
    AND tanggal BETWEEN :start_date AND :end_date";

    $stmtGetTotalKas = $conn->prepare($sqlGetTotalKas);
    $params = [
      ':id_pengguna' => $id_pengguna,
      ':start_date' => $startDateOfMonth,
      ':end_date' => $currentDateOfMonth,
      ':id_dkm' => $_SESSION['profile']->id_dkm
    ];

    $stmtGetTotalKas->execute($params);
    $rowGetTotalKas = $stmtGetTotalKas->fetchObject();

    return $rowGetTotalKas;
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
}

function getHistoryKas($id_pengguna)
{
  include "../configs/db.php";
  $startDateOfMonth = date('Y-m-01');
  $currentDateOfMonth = date('Y-m-d', strtotime("+1 days"));

  try {
    $sqlGetAllKas = "SELECT 
      kas.tipe AS tipe,
      kas.nominal AS nominal,
      kas.uraian AS uraian,
      kas.tanggal AS tanggal,
      pembuat.nama AS nama_pembuat,
      pengubah.nama AS nama_pengubah,
      kas.created_at,
      kas.updated_at
      FROM kas 
      LEFT JOIN pengguna AS pembuat ON pembuat.id = kas.dibuat_oleh_id_pengguna
      LEFT JOIN pengguna AS pengubah ON pengubah.id = kas.diubah_oleh_id_pengguna
      WHERE (
        CASE
          WHEN (select id_jabatan from pengguna where id = :id_pengguna) = 1
            THEN kas.dibuat_oleh_id_pengguna IN (select id from pengguna where id_dkm = :id_pengguna) OR pembuat.id = :id_pengguna
          ELSE kas.dibuat_oleh_id_pengguna = :id_pengguna OR pembuat.id_dkm = :id_dkm OR pembuat.id = :id_dkm
        END
      )
    AND kas.tanggal BETWEEN :start_date AND :end_date
    ORDER BY kas.updated_at DESC";

    $stmtGetAllKas = $conn->prepare($sqlGetAllKas);

    $params = [
      ':id_pengguna' => $id_pengguna,
      ':start_date' => $startDateOfMonth,
      ':end_date' => $currentDateOfMonth,
      ':id_dkm' => $_SESSION['profile']->id_dkm
    ];

    $stmtGetAllKas->execute($params);
    $rowGetAllKas = $stmtGetAllKas->fetchAll(PDO::FETCH_ASSOC);

    return $rowGetAllKas ?? [];
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
}

function countAnggota($id)
{
  include '../configs/db.php';

  try {
    $sqlCountAnggota = "SELECT COUNT(*) AS total_anggota FROM pengguna WHERE id_dkm = :id_dkm";
    $stmtCountAnggota = $conn->prepare($sqlCountAnggota);
    $params = [
      ':id_dkm' => $id
    ];
    $stmtCountAnggota->execute($params);
    $dataCount = $stmtCountAnggota->fetchObject()->total_anggota;

    return $dataCount;
  } catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
}
