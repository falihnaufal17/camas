<main class="welcome">
  <div class="container py-3">
    <section class="text-center p-3">
      <h1>Selamat Datang di Camas</h1>
      <p>
        Camas (Catat kas Masjid) merupakan aplikasi pencatatan kas berbasis web yang dikembangkan untuk mencatat pemasukan dan pengeluaran kas masjid.<br>
        <?php if (isset($_SESSION['profile'])) : ?>Silakan klik Daftar untuk membuat akun DKM masjid. Jika sudah memiliki akun silakan klik Masuk.<?php endif ?>
      </p>
    </section>
    <div class="d-flex justify-content-between column-gap-3">
      <?php if (isset($_SESSION['profile'])) : ?>
        <a href="./index.php?page=login-page" class="btn btn-primary w-100">Beranda</a>
      <?php else : ?>
        <a href="./index.php?page=login-page" class="btn btn-primary w-100">Masuk</a>
        <a href="./index.php?page=register-page" class="btn btn-outline-primary w-100">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</main>