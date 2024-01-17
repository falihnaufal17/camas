<?php

function getTotalKasByTipe($id_pengguna)
{
  include "../configs/db.php";

  try {
    $sqlGetTotalKas = "SELECT
        SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END) AS pemasukan,
        SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END) AS pengeluaran
      FROM kas
      WHERE dibuat_oleh_id_pengguna = ?
        AND tipe IN (1, 2);";
    $stmtGetTotalKas = $conn->prepare($sqlGetTotalKas);
    $stmtGetTotalKas->execute([$id_pengguna]);
    $rowGetTotalKas = $stmtGetTotalKas->fetchObject();

    return $rowGetTotalKas;
  } catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
  }
}

function getAllKas($id_pengguna)
{
  include "../configs/db.php";

  $sortDirection = 'DESC';
  $from = $_GET['from'] ?? null;
  $to = $_GET['to'] ?? null;
  $pemasukan = $_GET['pemasukan'] ?? null;
  $pengeluaran = $_GET['pengeluaran'] ?? null;
  $whereClause = '';

  if (isset($_GET['sort'])) {
    $sortDirection = ($_GET['sort'] === 'terlama') ? 'ASC' : 'DESC';
  }

  if (isset($_GET['submit-filter'])) {
    if (!empty($to)) {
      $whereClause .= " AND kas.tanggal BETWEEN :start_date AND :end_date ";
    }

    if (!empty($pengeluaran)) {
      $whereClause .= " AND kas.tipe = :pengeluaran";
    }

    if (!empty($pemasukan)) {
      $whereClause .= " OR kas.tipe = :pemasukan";
    }
  }

  $orderByClause = "ORDER BY kas.created_at " . $sortDirection;

  try {
    $sqlGetAllKas = "SELECT 
            kas.tipe AS tipe,
            kas.nominal AS nominal,
            kas.uraian AS uraian,
            kas.tanggal AS tanggal,
            pengguna.nama AS nama
            FROM kas 
            LEFT JOIN pengguna ON pengguna.id = kas.dibuat_oleh_id_pengguna
            WHERE kas.dibuat_oleh_id_pengguna = :id_pengguna"
      . $whereClause . " "
      . $orderByClause;
    $stmtGetAllKas = $conn->prepare($sqlGetAllKas);

    $params = [':id_pengguna' => $id_pengguna];
    if (!empty($to)) {
      $params[':start_date'] = $from;
      $params[':end_date'] = $to;
    }

    if (!empty($pemasukan)) {
      $params[':pemasukan'] = $pemasukan;
    }

    if (!empty($pengeluaran)) {
      $params[':pengeluaran'] = $pengeluaran;
    }

    $stmtGetAllKas->execute($params);
    $rowGetAllKas = $stmtGetAllKas->fetchAll(PDO::FETCH_ASSOC);

    return $rowGetAllKas ?? [];
  } catch (PDOException $e) {
    throw new Error("ERROR: " . $e->getMessage());
  }
}
