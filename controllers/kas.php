<?php

function getTotalKasByTipe($id_pengguna)
{
  include "../configs/db.php";

  $from = $_GET['from'] ?? null;
  $to = $_GET['to'] ?? null;
  $pemasukan = $_GET['pemasukan'] ?? null;
  $pengeluaran = $_GET['pengeluaran'] ?? null;
  $whereClause = '';

  try {
    if (!empty($to)) {
      $whereClause .= " AND kas.tanggal BETWEEN :start_date AND :end_date ";
    }

    if (!empty($pengeluaran) && empty($pemasukan)) {
      $whereClause .= " AND kas.tipe = :pengeluaran";
    }

    if (!empty($pemasukan) && empty($pengeluaran)) {
      $whereClause .= " AND kas.tipe = :pemasukan";
    }

    if (!empty($pemasukan) && !empty($pengeluaran)) {
      $whereClause .= " AND kas.tipe IN (:pemasukan, :pengeluaran)";
    }

    $sqlGetTotalKas = "SELECT
        COALESCE(SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END), 0) AS pemasukan,
        COALESCE(SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END), 0) AS pengeluaran,
        COALESCE(
          GREATEST(
            SUM(CASE WHEN tipe = 1 THEN nominal ELSE 0 END) - SUM(CASE WHEN tipe = 2 THEN nominal ELSE 0 END
          ), 0)
        , 0) AS total
      FROM kas
      WHERE dibuat_oleh_id_pengguna = :id_pengguna"
      . $whereClause;

    $stmtGetTotalKas = $conn->prepare($sqlGetTotalKas);

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

    $stmtGetTotalKas->execute($params);
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

  if (!empty($to)) {
    $whereClause .= " AND kas.tanggal BETWEEN :start_date AND :end_date ";
  }

  if (!empty($pengeluaran) && empty($pemasukan)) {
    $whereClause .= " AND kas.tipe = :pengeluaran";
  }

  if (!empty($pemasukan) && empty($pengeluaran)) {
    $whereClause .= " AND kas.tipe = :pemasukan";
  }

  if (!empty($pemasukan) && !empty($pengeluaran)) {
    $whereClause .= " AND kas.tipe IN (:pemasukan, :pengeluaran)";
  }

  $orderByClause = "ORDER BY kas.created_at " . $sortDirection;

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

function addKas($pengguna_id)
{
  include "../configs/db.php";

  if (isset($_POST['simpan-pemasukan'])) {
    $type = $_POST['type'];
    $tanggal_pemasukan = $_POST['date'];
    $uraian = $_POST['uraian'];
    $nominal = $_POST['nominal'];

    if (empty($tanggal_pemasukan) || empty($uraian) || empty($nominal)) {
      foreach ($_POST as $key => $value) {
        if ($key !== 'simpan-pemasukan' && empty($value)) {
          $error_messages[$key] = LABEL_FORM_PEMASUKAN[$key] . " harus diisi";
        }
      }
      return $error_messages;
    } else {
      try {
        $sqlInsertDebitCash = "INSERT INTO kas
          (tipe, dibuat_oleh_id_pengguna, uraian, nominal, tanggal)
          VALUES (?, ?, ?, ?, ?)";
        $stmtInsertDebitCash = $conn->prepare($sqlInsertDebitCash);
        $stmtInsertDebitCash->execute([$type, $pengguna_id, $uraian, $nominal, $tanggal_pemasukan]);

        setcookie('kas_message', "Kas pemasukan telah tercatat", time() + 5);

        header("Location: kas.php");
      } catch (PDOException $e) {
        setcookie('kas_message', 'ERROR: ' . $e->getMessage(), time() + 5);
      }
    }
  }

  if (isset($_POST['simpan-pengeluaran'])) {
    $type_pengeluaran = $_POST['type-pengeluaran'];
    $tanggal_pengeluaran = $_POST['date-pengeluaran'];
    $uraian_pengeluaran = $_POST['uraian-pengeluaran'];
    $nominal_pengeluaran = $_POST['nominal-pengeluaran'];

    if (empty($tanggal_pengeluaran) || empty($uraian_pengeluaran) || empty($nominal_pengeluaran)) {
      foreach ($_POST as $key => $value) {
        if ($key !== 'simpan-pengeluaran' && empty($value)) {
          $error_messages[$key] = LABEL_FORM_PENGELUARAN[$key] . " harus diisi";
        }
      }

      return $error_messages;
    } else {
      try {
        $sqlInsertCreditCash = "INSERT INTO kas
          (tipe, dibuat_oleh_id_pengguna, uraian, nominal, tanggal)
          VALUES (?, ?, ?, ?, ?)";
        $stmtInsertCreditCash = $conn->prepare($sqlInsertCreditCash);
        $stmtInsertCreditCash->execute([$type_pengeluaran, $pengguna_id, $uraian_pengeluaran, $nominal_pengeluaran, $tanggal_pengeluaran]);

        setcookie('kas_message', "Kas pengeluaran telah tercatat", time() + 5);

        header("Location: kas.php");
      } catch (PDOException $e) {
        setcookie('kas_message', 'ERROR: ' . $e->getMessage(), time() + 5);
      }
    }
  }
}
