<?php 
$konten = isset($_GET['konten']) ? $_GET['konten'] : 'home';
?>

<h5 class="text-white">Tubes King's</h5>
<nav class="nav flex-column">

    <a href="index.php" class="nav-link <?= ($konten == 'home') ? 'active' : '' ?>">
        <i class="bi bi-house-door"></i> Home
    </a>
</nav>
