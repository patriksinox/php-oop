<?php

//session_start();

$role = $_SESSION["role"];


?>

<header>

<h1>Rokfort - Hlavička</h1>
<nav>
<ul>

<li> <a href="../../php-oop/admin/ziaci.php">Žiaci</a> </li>
<li> <a href="../../php-oop/admin/photos.php">Fotky</a>  </li>

<?php if($role === "admin"): ?>
<li> <a href="../../php-oop/admin/pridat-ziaka.php">Pridať Žiaka</a> </li>
<?php endif ?>
<li> <a href="/php-oop/contact.php">Kontaktný formulár</a> </li>
<li> <a href="../../php-oop/admin/log-out.php">Odhlasenie</a>  </li>

</ul>
</nav>
</header>
