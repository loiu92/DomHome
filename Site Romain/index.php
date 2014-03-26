<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Se connecter</title>
  <link rel="stylesheet" href="style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<?php
//erreur mot de passe
if (isset($_GET['connexion']) AND ($_GET['connexion']=="false"))
{
	echo '<div class="mdp-false"><p>Vous avez entré un mauvais mot de passe</p></div>';
}
?>
<div class="connection">
	<form class="sign-up" action="test.php" method="post">
		<input type="text" class="sign-up-input" placeholder="nom du compte" autofocus name="nom">
		<input type="password" class="sign-up-input" placeholder="mot de passe" name="mdp">
		<input type="submit" value="Se connecter !" class="sign-up-button">
	</form>
</div>
</body>