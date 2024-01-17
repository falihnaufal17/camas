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
    WHERE dibuat_oleh_id_pengguna = :id_pengguna
    AND tanggal BETWEEN :start_date AND :end_date";

    $stmtGetTotalKas = $conn->prepare($sqlGetTotalKas);
    $params = [
      ':id_pengguna' => $id_pengguna,
      ':start_date' => $startDateOfMonth,
      ':end_date' => $currentDateOfMonth
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
  $currentDateOfMonth = date('Y-m-d');

  try {
    $sqlGetAllKas = "SELECT 
      kas.tipe AS tipe,
      kas.nominal AS nominal,
      kas.uraian AS uraian,
      kas.tanggal AS tanggal,
      pengguna.nama AS nama,
      kas.created_at
      FROM kas 
      LEFT JOIN pengguna ON pengguna.id = kas.dibuat_oleh_id_pengguna
      WHERE kas.dibuat_oleh_id_pengguna = :id_pengguna
    AND tanggal BETWEEN :start_date AND :end_date";

    $stmtGetAllKas = $conn->prepare($sqlGetAllKas);

    $params = [
      ':id_pengguna' => $id_pengguna,
      ':start_date' => $startDateOfMonth,
      ':end_date' => $currentDateOfMonth
    ];

    $stmtGetAllKas->execute($params);
    $rowGetAllKas = $stmtGetAllKas->fetchAll(PDO::FETCH_ASSOC);

    return $rowGetAllKas ?? [];
  } catch (PDOException $e) {
    throw new Error("ERROR: " . $e->getMessage());
  }
}
