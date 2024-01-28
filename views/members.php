<?php
include '../controllers/member.php';

$memberList = getListAnggota();
?>

<header class="navbar shadow-sm mb-3">
  <div class="container-fluid">
    <div></div>
    <h1 class="navbar-brand mb-0 h1">Anggota</h1>
    <div></div>
  </div>
</header>
<main class="container">
  <?php if (isset($_COOKIE['member_message'])) : ?>
    <div class="alert alert-success">
      <?= $_COOKIE['member_message'] ?>
    </div>
  <?php endif ?>
  <section class="card">
    <div class="card-body">
      <div class="text-end">
        <a href="index.php?page=form-add-member-page" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Tambah Anggota</a>
      </div>
      <form class="d-flex flex-column row-gap-3 mb-3" method="post">
        <input type="search" class="form-control" name="search" placeholder="Cari nama" value="<?= $_POST['search'] ?? ''; ?>" />
        <small><strong>Catatan:</strong> Kosongkan kolom pencarian untuk melihat seluruh anggota</small>
        <button class="btn btn-success" name="btn-cari">Cari</button>
      </form>
      <div class="row row-gap-3">
        <?php if (count($memberList) > 0) : ?>
          <?php foreach ($memberList as $item) : ?>
            <div class="col-12 col-md-6">
              <div class="card shadow border-0 card-member">
                <div class="card-body">
                  <table class="table table-borderless">
                    <tr>
                      <td width="150">Nama Lengkap</td>
                      <td>:</td>
                      <td><?= $item->nama ?></td>
                    </tr>
                    <tr>
                      <td>No Hp</td>
                      <td>:</td>
                      <td><?= $item->no_hp ?></td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td><?= $item->alamat ?></td>
                    </tr>
                  </table>
                </div>
                <?php if ($_SESSION['profile']->id_jabatan === 1) : ?>
                  <div class="card-footer">
                    <div class="d-flex justify-content-end  column-gap-2">
                      <a href="index.php?page=form-edit-member-page&id=<?= $item->id ?>" class="btn btn-success btn-sm">Edit</a>
                      <a href="index.php?page=delete-member-page&id=<?= $item->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin ingin menghapus data ini?')">Hapus</a>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach ?>
        <?php else : ?>
          <div class="col-12 col-md-12 text-center">
            Belum ada daftar anggota
          </div>
        <?php endif ?>
      </div>
    </div>
  </section>
  <?php include '../components/bottom-nav.php' ?>
</main>