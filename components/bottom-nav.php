<nav class="nav shadow bottom-nav justify-content-between px-3 py-2 bg-white">
  <a href="index.php?page=home-page" class="text-center text-decoration-none <?php echo $_GET['page'] === 'home-page' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-home"></i>
    </div>
    <small>Beranda</small>
  </a>
  <a href="index.php?page=kas-page&<?php echo "from=" . date('Y-m-01') . "&to=" . date('Y-m-d') ?>" class="text-center text-decoration-none <?php echo $_GET['page'] === 'kas-page' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-wallet"></i>
    </div>
    <small>Kas</small>
  </a>
  <a href="index.php?page=profile-page" class="text-center text-decoration-none <?php echo $_GET['page'] === 'profile-page' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-user"></i>
    </div>
    <small>Profil</small>
  </a>
</nav>