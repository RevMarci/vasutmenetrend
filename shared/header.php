<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['login'])) {
  $_SESSION['login'] = '';
}

require_once ROOT_PATH . 'config.php';
?>

<header>
  <a href="<?= BASE_URL ?>index.php">
    <img src="<?= BASE_URL ?>assets/SnailRail_logo.png" alt="">
  </a>
  <div>
    <!--
    <a href="<?= BASE_URL ?>pages/stats.php">Statisztika</a>-->
    <a href="<?= BASE_URL ?>pages/stations.php">Állomások</a>
    <a href="<?= BASE_URL ?>pages/search.php">Vonatkereső </a>

    

    <?php
    //$_SESSION['login'] = '';
    if ($_SESSION['login'] === 'tag') {
      echo "<a href='" . BASE_URL . "pages/jegyvasarlas.php'>Jegyvásárlás</a>";
      echo "<a class='blackButton' href='" . BASE_URL . "pages/profile.php'>Profil</a>";
    } elseif ($_SESSION['login'] === 'admin') {
      //echo "<a href='" . BASE_URL . "pages/jegyvasarlas.php'>Jegyvásárlás</a>";
      echo "<a href='" . BASE_URL . "pages/statistics.php'>Statisztika</a>";
      echo "<a class='blackButton' href='" . BASE_URL . "pages/admin.php'>Admin</a>";
    } else {
      echo "<a class='blackButton' href='" . BASE_URL . "pages/login.php'>Bejelentkezés</a>";
    }
    ?>
  </div>
</header>
