<header>
	<img src="images/logo-header2.png" id="logo">
	<h1 id="title">DomHome</h1>
</header>
<nav id="menu-principal">
	<a href="accueil.php"><div class="nav-general-section-blanc"></div></a>
	<a href="accueil.php"><div class="nav-general-section">Accueil
	</div></a>
	<a href="reglage.php"><div class="nav-general-section">Reglage
	</div></a>
<?php
if ($_SESSION['usert']=='admin')
{
?>	<a href="reglage-admin.php"><div class="nav-general-section">Administrateur
	</div></a>
<?php
} else {} ?>
	<a href="deco.php"><div class="nav-general-section-deco">Deconnexion
	</div></a>
	</nav>
