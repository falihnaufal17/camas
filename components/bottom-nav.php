<?php
  date_default_timezone_set('Asia/Jakarta');

  $pathUrl = $_SERVER['REQUEST_URI'];
  $arrPath = explode('/', $pathUrl);
  $arrLengthPath = count($arrPath);
  $fileName = $arrPath[$arrLengthPath - 1];
  $arrFileName = explode('.', $fileName);
  $routeName = $arrFileName[0];
?>
<nav class="nav shadow bottom-nav justify-content-between px-3 py-2 bg-white">
  <a href="home.php" class="text-center text-decoration-none <?php echo $routeName === 'home' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-home"></i>
    </div>
    <small>Beranda</small>
  </a>
  <a href="kas.php?<?php echo "from=" . date('Y-m-01') . "&to=" . date('Y-m-d') ?>" class="text-center text-decoration-none <?php echo $routeName === 'kas' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-wallet"></i>
    </div>
    <small>Kas</small>
  </a>
  <a href="profile.php" class="text-center text-decoration-none <?php echo $routeName === 'profile' ? '' : 'text-dark' ?>">
    <div>
      <i class="fa fa-user"></i>
    </div>
    <small>Profil</small>
  </a>
</nav>